<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;

class PelangganController extends Controller
{
    /**
     * Display the customer dashboard.
     */
    public function index()
    {
        $userId = Auth::id();
        $activeOrdersCount = Order::where('user_id', $userId)->whereNotIn('status', ['completed', 'cancelled'])->count();
        $totalPurchaseAmount = Order::where('user_id', $userId)->where('status', 'completed')->sum('total_amount');
        // Example of wishlist count if you implement a wishlist feature
        $wishlistCount = 0; // Placeholder

        $recentOrders = Order::where('user_id', $userId)
                                ->orderBy('created_at', 'desc')
                                ->take(5)
                                ->get();

        return view('pelanggan.dashboard', compact('activeOrdersCount', 'totalPurchaseAmount', 'wishlistCount', 'recentOrders'));
    }
}
