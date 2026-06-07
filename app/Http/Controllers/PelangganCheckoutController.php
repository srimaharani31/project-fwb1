<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Illuminate\Support\Collections;

class PelangganCheckoutController extends Controller
{
    public function index()
    {
        // Checkout page mostly static; real implementation uses cart.
        return view('checkout');
    }

    public function store(Request $request)
    {
        // Karena form checkout saat ini belum mengirim items cart, kita implement minimal:
        // - Simpan order dengan total_price dari session cart (jika ada)
        // - order_items dari session cart (jika ada)
        // Struktur session cart yang kita dukung:
        // session('cart') = [ [product_id, quantity], ... ] atau map: product_id => quantity

        $user = Auth::user();

        $cart = session('cart', []);
        if (empty($cart)) {
            return redirect()->route('pelanggan.dashboard')->with('error', 'Keranjang kosong.');
        }

        $items = $this->normalizeCartItems($cart);
        if ($items->isEmpty()) {
            return redirect()->route('pelanggan.dashboard')->with('error', 'Keranjang kosong.');
        }

        $productIds = $items->pluck('product_id')->all();
        $products = Product::whereIn('id', $productIds)->get()->keyBy('id');

        // Validasi quantity & stok (opsional ketat: stock >= qty)
        foreach ($items as $it) {
            if (!$products->has($it['product_id'])) {
                return back()->with('error', 'Produk tidak ditemukan.');
            }
            $p = $products->get($it['product_id']);
            if ((int) $p->stock < (int) $it['quantity']) {
                return back()->with('error', 'Stok tidak mencukupi untuk produk: ' . $p->name);
            }
        }

        $total = 0;
        foreach ($items as $it) {
            $p = $products->get($it['product_id']);
            $total += ((float) $p->price) * (int) $it['quantity'];
        }

        $order = Order::create([
            'user_id' => $user->id,
            'total_price' => $total,
            'status' => 'pending',
        ]);

        // Buat order items + kurangi stok
        foreach ($items as $it) {
            $p = $products->get($it['product_id']);
            $quantity = (int) $it['quantity'];

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $p->id,
                'quantity' => $quantity,
                'price' => $p->price,
            ]);

            $p->decrement('stock', $quantity);
        }

        // Bersihkan cart
        session()->forget('cart');

        return redirect()->route('thankyou', ['order' => $order->id]);
    }

    private function normalizeCartItems($cart): Collections\Collection
    {
        // Support beberapa format:
        // 1) [ ['product_id'=>1,'quantity'=>2], ... ]
        // 2) [ 1 => 2, 3 => 1 ]
        // 3) [ 'items' => [ ... ] ]

        if (is_array($cart) && array_key_exists('items', $cart) && is_array($cart['items'])) {
            $cart = $cart['items'];
        }

        if (empty($cart)) {
            return collect();
        }

        // case 2: map
        if (is_array($cart) && !isset($cart[0]) && count(array_filter(array_keys($cart), 'is_int')) === 0) {
            // likely associative map with int keys already; still treat as map
        }

        // If first level item has product_id => list format
        if (is_array($cart) && isset($cart[0]) && is_array($cart[0]) && isset($cart[0]['product_id'])) {
            return collect($cart)->map(function ($it) {
                return [
                    'product_id' => (int) $it['product_id'],
                    'quantity' => (int) ($it['quantity'] ?? 1),
                ];
            })->filter(fn($it) => $it['product_id'] > 0 && $it['quantity'] > 0);
        }

        // Otherwise treat as map product_id => quantity
        if (is_array($cart)) {
            return collect($cart)->map(function ($qty, $productId) {
                return [
                    'product_id' => (int) $productId,
                    'quantity' => (int) $qty,
                ];
            })->filter(fn($it) => $it['product_id'] > 0 && $it['quantity'] > 0);
        }

        return collect();
    }
}

