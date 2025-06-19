<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; 
use App\Models\Product; 
use App\Models\Order; 

class AdminController extends Controller
{
    public function index()
    {
        // Ambil jumlah pengguna
        $totalUsers = User::count();

        // Ambil total produk
        $totalProducts = Product::count();

        // Ambil pesanan baru (misalnya, status 'pending' atau 'baru')
        $newOrders = Order::where('status', 'pending')->count(); // Sesuaikan dengan kolom status Anda

        // Hitung pendapatan hari ini
        $todayRevenue = Order::whereDate('created_at', today())
                             ->where('status', 'completed') // Hanya pesanan yang selesai
                             ->sum('total_amount'); // Asumsikan ada kolom total_price di tabel orders

        // Ambil aktivitas terkini (misalnya, 3 aktivitas terbaru dari log atau model terkait)
        // Ini bisa lebih kompleks tergantung bagaimana Anda mencatat aktivitas.
        // Contoh sederhana: 3 order atau user terbaru
        $recentActivities = [
            'users' => User::latest()->take(1)->get(), // 1 user terbaru
            'orders' => Order::latest()->take(2)->get(), // 2 order terbaru
            'products' => Product::latest()->take(1)->get(), // 1 produk terbaru
        ];


        return view('admin.dashboard', compact(
            'totalUsers',
            'totalProducts',
            'newOrders',
            'todayRevenue',
            'recentActivities'
        ));
    }
}
