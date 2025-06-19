<?php

namespace App\Http\Controllers;

use App\Models\Order; 
use App\Models\OrderItem; 
use App\Models\Product; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 

class OwnerOrderController extends Controller
{
    
    public function index()
    {
        $ownerId = Auth::id(); 

        // Ambil ID semua produk yang dimiliki oleh owner yang sedang login
        $ownerProductIds = Product::where('user_id', $ownerId)->pluck('id');

        // Jika owner tidak memiliki produk, tidak ada pesanan yang akan ditampilkan
        if ($ownerProductIds->isEmpty()) {
            $orders = collect(); // Membuat koleksi kosong
        } else {
            // Temukan semua OrderItem yang terkait dengan produk owner ini
            // Kemudian dapatkan ID Order dari OrderItem tersebut
            $orderIds = OrderItem::whereIn('product_id', $ownerProductIds)
                                 ->pluck('order_id')
                                 ->unique(); // Pastikan ID pesanan unik

            // Ambil pesanan berdasarkan ID yang ditemukan
            // Muat relasi user (pelanggan) dan orderItems
            $orders = Order::whereIn('id', $orderIds)
                           ->with('user', 'orderItems.product') // Muat user (pelanggan) dan item-itemnya beserta produk
                           ->orderBy('created_at', 'desc')
                           ->get();

            // Filter orderItems untuk setiap order, hanya menampilkan yang relevan dengan produk owner ini
            $orders->each(function($order) use ($ownerProductIds) {
                $order->setRelation('orderItems', $order->orderItems->filter(function($item) use ($ownerProductIds) {
                    return $ownerProductIds->contains($item->product_id);
                }));
            });
        }

        // Kirim data pesanan ke view
        return view('owner.orders.index', compact('orders'));
    }

    /**
     * Menampilkan detail pesanan tertentu untuk owner.
     */
    public function show($orderId)
    {
        $ownerId = Auth::id();

        // Cari pesanan
        $order = Order::with(['user', 'orderItems.product'])->findOrFail($orderId);

        // Validasi: Pastikan pesanan ini mengandung setidaknya satu produk dari owner yang login
        $hasOwnerProduct = $order->orderItems->contains(function ($item) use ($ownerId) {
            return $item->product->user_id === $ownerId;
        });

        if (!$hasOwnerProduct) {
            abort(403, 'Anda tidak memiliki izin untuk melihat detail pesanan ini karena tidak mengandung produk Anda.');
        }

        // Filter orderItems untuk pesanan ini, hanya tampilkan yang relevan dengan produk owner ini
        $order->setRelation('orderItems', $order->orderItems->filter(function($item) use ($ownerId) {
            return $item->product->user_id === $ownerId;
        }));

        return view('owner.orders.show', compact('order'));
    }

}