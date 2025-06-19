<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class OwnerReviewController extends Controller
{
    /**
     * Menampilkan daftar ulasan untuk produk milik owner yang sedang login.
     */
    public function index()
    {
        $ownerId = Auth::id();

        // Dapatkan ID produk yang dimiliki oleh owner yang sedang login
        $ownerProductIds = Product::where('user_id', $ownerId)->pluck('id');

        // Ambil ulasan yang terkait dengan produk owner, muat relasi produk dan user
        $reviews = Review::whereIn('product_id', $ownerProductIds)
                         ->with('product', 'user')
                         ->orderBy('created_at', 'desc')
                         ->get();

        return view('owner.reviews.index', compact('reviews'));
    }

    /**
     * Menyimpan balasan untuk ulasan tertentu.
     */
    public function reply(Request $request, Review $review)
    {
        $ownerId = Auth::id();

        // Validasi bahwa ulasan tersebut terkait dengan produk milik owner ini
        if ($review->product->user_id !== $ownerId) {
            abort(403, 'Anda tidak memiliki izin untuk membalas ulasan ini.');
        }

        $request->validate([
            'reply_message' => 'required|string|max:1000',
        ]);

        $review->update([
            'reply' => $request->reply_message,
            'replied_at' => Carbon::now(),
        ]);

        return redirect()->route('owner.reviews.index')->with('success', 'Balasan berhasil dikirim!');
    }

    /**
     * Menghapus ulasan.
     */
    public function destroy(Review $review)
    {
        $ownerId = Auth::id();

        // Validasi bahwa ulasan tersebut terkait dengan produk milik owner ini
        if ($review->product->user_id !== $ownerId) {
            abort(403, 'Anda tidak memiliki izin untuk menghapus ulasan ini.');
        }

        $review->delete();

        return redirect()->route('owner.reviews.index')->with('success', 'Ulasan berhasil dihapus!');
    }
}