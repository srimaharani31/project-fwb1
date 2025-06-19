<?php

namespace App\Http\Controllers;

use App\Models\Order; // Assuming you have an Order model
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    /**
     * Display a listing of the resource (orders).
     */
    public function index()
    {
        $orders = Order::with('user')->get(); // Load the user associated with the order
        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Display the specified resource (order).
     */
    public function show(Order $order)
    {
        // Load order details and related products
        $order->load('user', 'orderDetails.product');
        return view('admin.orders.show', compact('order'));
    }

    // You might add update status methods here if needed, e.g., updateStatus(Request $request, Order $order)
}
