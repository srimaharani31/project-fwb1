<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function placeOrder(Request $request, Product $product)
    {
        // Pastikan pengguna adalah pelanggan
        if (Auth::user()->role !== 'pelanggan') {
            return redirect()->back()->with('error', 'Hanya pelanggan yang dapat melakukan pembelian.');
        }

        $quantity = 1; // Untuk tombol "Beli Sekarang", kita asumsikan kuantitas 1.
                      // Anda bisa membuatnya dinamis jika ada form input kuantitas.

        if ($product->stock < $quantity) {
            return redirect()->back()->with('error', 'Stok produk tidak mencukupi.');
        }

        DB::beginTransaction();
        try {
            // Buat pesanan baru
            $order = Order::create([
                'user_id' => Auth::id(),
                'order_code' => 'ORD-' . Str::upper(Str::random(8)),
                'total_amount' => $product->price * $quantity,
                'status' => 'pending',
            ]);

            // Tambahkan item pesanan
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'quantity' => $quantity,
                'price' => $product->price,
            ]);

            // Kurangi stok produk
            $product->stock -= $quantity;
            $product->save();

            DB::commit();

            return redirect()->route('products.index')->with('success', 'Pesanan berhasil dibuat! Kode Pesanan: ' . $order->order_code);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memproses pesanan: ' . $e->getMessage());
        }
    }

    public function index()
    {
        // Hanya admin dan owner yang bisa melihat semua pesanan
        if (Auth::user()->role === 'admin' || Auth::user()->role === 'owner') {
            $orders = Order::with(['user', 'items.product'])->latest()->paginate(10);
        } else {
            // Pelanggan hanya bisa melihat pesanan mereka sendiri
            $orders = Order::where('user_id', Auth::id())->with(['user', 'items.product'])->latest()->paginate(10);
        }
        return view('orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        // Pastikan pengguna berwenang untuk melihat pesanan ini
        if (Auth::user()->role === 'pelanggan' && Auth::id() !== $order->user_id) {
            abort(403, 'Unauthorized action.');
        }
        $order->load(['user', 'items.product']);
        return view('orders.show', compact('order'));
    }

    // Anda bisa menambahkan method untuk update status pesanan oleh admin/owner di sini
    public function updateStatus(Request $request, Order $order)
    {
        if (Auth::user()->role === 'pelanggan') {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk mengubah status pesanan.');
        }

        $request->validate([
            'status' => 'required|in:pending,completed,cancelled',
        ]);

        $order->status = $request->status;
        $order->save();

        return redirect()->route('orders.index')->with('success', 'Status pesanan berhasil diperbarui.');
    }

    public function cancel(Request $request, Order $order)
    {
        // Otorisasi: Pastikan pelanggan yang sedang login adalah pemilik pesanan ini.
        if ($request->user()->id !== $order->user_id) {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk membatalkan pesanan ini.');
        }

        // Validasi: Hanya pesanan dengan status tertentu yang bisa dibatalkan
        if (!in_array($order->status, ['pending_payment', 'processing'])) {
            return redirect()->back()->with('error', 'Pesanan ini tidak dapat dibatalkan karena statusnya sudah ' . ucfirst(str_replace('_', ' ', $order->status)) . '.');
        }

        // Memulai transaksi database untuk memastikan konsistensi data
        DB::beginTransaction();
        try {
            // Ubah status pesanan menjadi 'cancelled'
            $order->status = 'cancelled';
            $order->save();

            // Opsional: Kembalikan stok produk yang ada di pesanan ini
            // Ini penting jika Anda mengelola inventaris
            foreach ($order->orderItems as $item) {
                $product = $item->product; // Asumsi OrderItem memiliki relasi ke Product
                if ($product) {
                    $product->stock += $item->quantity; // Tambahkan kembali kuantitas ke stok
                    $product->save();
                }
            }

            DB::commit(); // Selesaikan transaksi

            return redirect()->route('orders.index')->with('success', 'Pesanan #PEL-'.$order->id.' berhasil dibatalkan.');

        } catch (\Exception $e) {
            DB::rollBack(); // Batalkan semua perubahan jika terjadi error
            return redirect()->back()->with('error', 'Gagal membatalkan pesanan. Silakan coba lagi. Error: ' . $e->getMessage());
        }
    }
}