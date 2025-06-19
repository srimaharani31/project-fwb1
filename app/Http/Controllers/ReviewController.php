<?php

namespace App\Http\Controllers;

use App\Models\Review; // Pastikan model Review diimpor
use App\Models\Order; // Diperlukan jika Anda ingin validasi lebih lanjut
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Menyimpan ulasan baru dari pelanggan.
     */
    public function store(Request $request)
    {
        // Validasi data yang masuk dari form ulasan
        $validatedData = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:500',
        ]);

        // Secara otomatis mengisi user_id dengan ID pelanggan yang sedang login
        $validatedData['user_id'] = Auth::id();

        // Opsional: Anda bisa menambahkan validasi lebih lanjut di sini
        // Misalnya, memastikan bahwa produk_id yang diulas memang bagian dari order_id tersebut
        // dan bahwa user yang login adalah pemilik order tersebut.
        /*
        $order = Order::where('id', $validatedData['order_id'])
                      ->where('user_id', Auth::id())
                      ->first();
        if (!$order) {
            return back()->withErrors(['order_id' => 'Pesanan tidak ditemukan atau bukan milik Anda.'])->withInput();
        }
        $orderItemExists = $order->orderItems()->where('product_id', $validatedData['product_id'])->exists();
        if (!$orderItemExists) {
            return back()->withErrors(['product_id' => 'Produk ini bukan bagian dari pesanan Anda.'])->withInput();
        }
        */

        // Buat record ulasan baru di database
        Review::create($validatedData);

        // Kembali ke halaman sebelumnya dengan pesan sukses
        return back()->with('success', 'Ulasan Anda berhasil dikirim!');
    }
}