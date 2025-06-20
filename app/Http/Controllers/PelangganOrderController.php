<?php

namespace App\Http\Controllers;

use App\Models\Order; 
use App\Models\Product; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 

class PelangganOrderController extends Controller
{
    public function index()
    {
      
        $orders = Auth::user()->orders()->orderBy('created_at', 'desc')->get();

        return view('pelanggan.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
     
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki izin untuk melihat pesanan ini.');
        }

        // Muat relasi order_items dan produk terkait di dalamnya
        $order->load('orderItems.product');

        // Untuk form ulasan, ambil produk dari order_items yang sudah dibeli
        // Ini akan digunakan untuk dropdown "Pilih Produk" di form ulasan
        $productsInOrder = $order->orderItems->map(function($item) {
            return $item->product;
        })->filter()->unique('id'); // Pastikan unik dan bukan null

        return view('pelanggan.orders.show', compact('order', 'productsInOrder'));
    }

    // Metode 'store' untuk membuat pesanan (biasanya dari keranjang belanja)
    // Saya asumsikan Anda memiliki logika keranjang belanja terpisah yang memanggil ini.
    // Ini contoh sederhana jika Anda langsung "beli sekarang" 1 produk.
    public function store(Request $request)
    {
        // Contoh validasi dasar
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            // Tambahkan validasi lain seperti alamat pengiriman, metode pembayaran, dll.
            'shipping_address' => 'required|string',
            'payment_method' => 'required|string',
        ]);

        $product = Product::findOrFail($request->product_id);
        $totalPrice = $product->price * $request->quantity;

        // Buat entri Order baru
        $order = Auth::user()->orders()->create([
            'total_price' => $totalPrice,
            'status' => 'pending_payment', // Status awal
            'shipping_address' => $request->shipping_address,
            'payment_method' => $request->payment_method,
            // Tambahkan kolom lain jika ada, misal order_number, dsb.
        ]);

        // Tambahkan item produk ke order_items
        $order->orderItems()->create([
            'product_id' => $product->id,
            'quantity' => $request->quantity,
            'price' => $product->price, // Harga saat pesanan dibuat
        ]);

        // Kurangi stok produk (penting!)
        $product->decrement('stock', $request->quantity);

        return redirect()->route('orders.show', $order->id)->with('success', 'Pesanan Anda berhasil dibuat!');
    }
}