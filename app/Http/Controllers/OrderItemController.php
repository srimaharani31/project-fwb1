<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index() {
        $orders = Order::with('user')->get();
        return view('orders.index', compact('orders'));
    }

    public function show(Order $order) {
        $order->load('user', 'orderItems.product');
        return view('orders.show', compact('order'));
    }

    public function update(Request $request, Order $order) {
        $request->validate([
            'status' => 'required|in:pending,paid,shipped,completed,cancelled'
        ]);
        $order->update(['status' => $request->status]);
        return redirect()->route('orders.index');
    }

    public function destroy(Order $order) {
        $order->delete();
        return redirect()->route('orders.index');
    }
}
