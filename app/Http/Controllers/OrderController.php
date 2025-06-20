<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log; // <--- Tambahkan ini untuk logging error

class OrderController extends Controller
{
 
    public function placeOrder(Request $request, Product $product)
    {
        // Otorisasi: Pastikan pengguna adalah pelanggan
        if (Auth::user()->role !== 'pelanggan') {
            return redirect()->back()->with('error', 'Hanya pelanggan yang dapat melakukan pembelian.');
        }

      
        $quantity = 1;
       
        // Validasi stok di awal (sebelum memulai transaksi)
        if ($product->stock < $quantity) {
            return redirect()->back()->with('error', 'Stok produk "' . $product->name . '" tidak mencukupi. Sisa stok: ' . $product->stock);
        }

        // --- Memulai Transaksi Database ---
        DB::beginTransaction();
        try {
            // Buat kode pesanan unik
            $orderCode = 'ORD-' . Str::upper(Str::random(8));
           

            // 1. Buat pesanan baru
            $order = Order::create([
                'user_id' => Auth::id(),
                'order_code' => $orderCode,
                'total_amount' => $product->price * $quantity,
                'status' => 'pending', // Ganti 'pending' menjadi 'pending_payment' untuk lebih spesifik
              
            ]);

            // 2. Tambahkan item pesanan
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'quantity' => $quantity,
                'price' => $product->price, // Simpan harga produk saat ini untuk riwayat yang akurat
            ]);

            // 3. Kurangi stok produk secara aman
            // Menggunakan decrement() lebih disarankan untuk menghindari race condition
            $product->decrement('stock', $quantity);

            // --- Komit Transaksi ---
            // Jika semua operasi di atas berhasil, simpan perubahan secara permanen ke database
            DB::commit();

            // Redirect ke halaman detail pesanan yang baru dibuat atau daftar pesanan
            return redirect()->route('orders.show', $order->id)->with('success', 'Pesanan berhasil dibuat! Kode Pesanan: ' . $order->order_code);

        } catch (\Exception $e) {
           
            DB::rollBack();
            // Log error untuk debugging yang lebih baik
            Log::error('Error in placeOrder: ' . $e->getMessage(), [
                'user_id' => Auth::id(),
                'product_id' => $product->id,
                'quantity' => $quantity,
                'trace' => $e->getTraceAsString(),
            ]);
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memproses pesanan: ' . $e->getMessage());
        }
    }

    public function index()
    {
        $user = Auth::user();

        // Query dasar untuk pesanan
        $query = Order::with(['user', 'items.product'])->latest();

        // Filter berdasarkan peran pengguna
        if ($user->role === 'pelanggan') {
            $query->where('user_id', $user->id);
        }
        // Jika admin atau owner, tidak ada filter user_id, mereka melihat semua

        $orders = $query->paginate(10); // Pagination untuk performa

        return view('orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $user = Auth::user();

        // Otorisasi: Pastikan pengguna berwenang untuk melihat pesanan ini
        if ($user->role === 'pelanggan' && $order->user_id !== $user->id) {
            abort(403, 'Unauthorized action. Anda tidak memiliki izin untuk melihat pesanan ini.');
        }
        // Admin dan Owner diizinkan melihat semua

        $order->load(['user', 'items.product']);

        // Mengambil produk unik dari pesanan untuk tampilan, misalnya jika ada fitur ulasan
        $productsInOrder = $order->items
                                ->map(fn($item) => $item->product)
                                ->filter()
                                ->unique('id');

        return view('orders.show', compact('order', 'productsInOrder'));
    }

   
    public function updateStatus(Request $request, Order $order)
    {
        // Otorisasi: Hanya admin atau owner yang diizinkan mengubah status.
        if (Auth::user()->role === 'pelanggan') {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk mengubah status pesanan.');
        }

        $request->validate([
            // Tambahkan lebih banyak status jika ada alur yang kompleks (misal: shipped, delivered, refunded)
            'status' => 'required|in:pending_payment,processing,shipped,completed,cancelled,refunded',
        ]);

        DB::beginTransaction(); // Memulai transaksi
        try {
            $oldStatus = $order->status;
            $newStatus = $request->status;

            $order->status = $newStatus;
            $order->save();

            // Contoh: Logika tambahan jika status berubah menjadi 'cancelled' oleh admin
            if ($newStatus === 'cancelled' && $oldStatus !== 'cancelled') {
                foreach ($order->items as $item) { // Pastikan relasi 'items' ada di model Order
                    $product = $item->product; // Asumsi OrderItem memiliki relasi ke Product
                    if ($product) {
                        $product->increment('stock', $item->quantity); // Kembalikan stok
                        $product->save();
                    }
                }
            }
            // Tambahkan logika lain untuk status seperti 'refunded' atau 'completed'

            DB::commit(); // Transaksi selesai dan perubahan disimpan
            return redirect()->route('orders.index')->with('success', 'Status pesanan berhasil diperbarui menjadi ' . ucfirst(str_replace('_', ' ', $newStatus)) . '.');

        } catch (\Exception $e) {
            DB::rollBack(); // Batalkan semua perubahan jika terjadi error
            Log::error('Error updating order status: ' . $e->getMessage(), [
                'order_id' => $order->id,
                'user_id' => Auth::id(),
                'new_status' => $request->status,
                'trace' => $e->getTraceAsString(),
            ]);
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui status pesanan. Error: ' . $e->getMessage());
        }
    }

    
    public function cancel(Request $request, Order $order)
    {
        $user = Auth::user();

       
        if ($user->role === 'pelanggan' && $request->user()->id !== $order->user_id) {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk membatalkan pesanan ini.');
        }
      
        if (!in_array($order->status, ['pending', 'pending_payment', 'processing'])) {
            return redirect()->back()->with('error', 'Pesanan ini tidak dapat dibatalkan karena statusnya sudah ' . ucfirst(str_replace('_', ' ', $order->status)) . '.');
        }

        // Memulai transaksi database untuk memastikan konsistensi data
        DB::beginTransaction();
        try {
            // Ubah status pesanan menjadi 'cancelled'
            $order->status = 'cancelled';
            $order->save();

           
            foreach ($order->items as $item) {
                $product = $item->product; // Asumsi OrderItem memiliki relasi ke Product
                if ($product) {
                    $product->increment('stock', $item->quantity); // Tambahkan kembali kuantitas ke stok secara aman
                    $product->save();
                }
            }

            DB::commit(); // Selesaikan transaksi dan simpan perubahan

            return redirect()->route('orders.index')->with('success', 'Pesanan dengan kode ' . $order->order_code . ' berhasil dibatalkan.');

        } catch (\Exception $e) {
            DB::rollBack(); // Batalkan semua perubahan jika terjadi error
            Log::error('Error cancelling order: ' . $e->getMessage(), [
                'order_id' => $order->id,
                'user_id' => Auth::id(),
                'trace' => $e->getTraceAsString(),
            ]);
            return redirect()->back()->with('error', 'Gagal membatalkan pesanan. Silakan coba lagi. Error: ' . $e->getMessage());
        }
    }
}