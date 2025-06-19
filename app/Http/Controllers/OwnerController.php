<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon; // Pastikan ini ada

class OwnerController extends Controller
{
    /**
     * Menampilkan dashboard utama untuk owner.
     */
    public function index()
    {
        $ownerId = Auth::id();

        $totalProducts = Product::where('user_id', $ownerId)->count();
        $ownerProductIds = Product::where('user_id', $ownerId)->pluck('id');

        if ($ownerProductIds->isEmpty()) {
            return view('owner.dashboard', [
                'totalProducts' => 0,
                'recentOrdersCount' => 0,
                'newReviewsCount' => 0,
                'totalRevenueMonth' => 0,
                'topSellingProductName' => 'N/A',
                'averageProductRating' => 'N/A',
            ]);
        }

        $recentOrderItems = OrderItem::whereIn('product_id', $ownerProductIds)
            ->whereHas('order', function ($query) {
                $query->where('created_at', '>=', Carbon::now()->subDays(7))
                      ->where('status', '!=', 'completed');
            })
            ->select('order_id')
            ->distinct()
            ->count();

        $newReviewsCount = Review::whereIn('product_id', $ownerProductIds)
                                 ->whereNull('reply')
                                 ->orWhere(function($query) {
                                     $query->where('created_at', '>=', Carbon::now()->subDays(7));
                                 })
                                 ->count();

        $totalRevenueMonth = 0;
        $startOfMonth = Carbon::now()->startOfMonth();

        $ownerOrderItemsCompleted = OrderItem::whereIn('product_id', $ownerProductIds)
                                            ->whereHas('order', function ($query) use ($startOfMonth) {
                                                $query->where('status', 'completed')
                                                      ->where('created_at', '>=', $startOfMonth);
                                            })
                                            ->get();

        foreach ($ownerOrderItemsCompleted as $item) {
            $totalRevenueMonth += ($item->quantity * $item->price);
        }

        $topSellingProduct = 'Belum ada penjualan';
        if ($ownerOrderItemsCompleted->isNotEmpty()) {
            $topSellingProductData = $ownerOrderItemsCompleted->groupBy('product_id')
                ->map(function ($items, $productId) {
                    return (object)[
                        'product_id' => $productId,
                        'total_sold' => $items->sum('quantity')
                    ];
                })
                ->sortByDesc('total_sold')
                ->first();

            if ($topSellingProductData) {
                $topSellingProduct = Product::find($topSellingProductData->product_id)->name ?? 'N/A';
            }
        }

        $averageProductRating = 'N/A';
        $productRatings = Review::whereIn('product_id', $ownerProductIds)
                                ->avg('rating');

        if ($productRatings !== null) {
            $averageProductRating = number_format($productRatings, 1);
        }

        return view('owner.dashboard', [
            'totalProducts' => $totalProducts,
            'recentOrdersCount' => $recentOrderItems,
            'newReviewsCount' => $newReviewsCount,
            'totalRevenueMonth' => $totalRevenueMonth,
            'topSellingProductName' => $topSellingProduct,
            'averageProductRating' => $averageProductRating,
        ]);
    }

    public function statistics() // <---- Pastikan metode ini ada!
    {
        $ownerId = Auth::id();

        // 1. Dapatkan semua produk milik owner ini
        $ownerProductIds = Product::where('user_id', $ownerId)->pluck('id');

        // Jika owner tidak punya produk, langsung tampilkan data kosong
        if ($ownerProductIds->isEmpty()) {
            return view('owner.statistics', [
                'totalRevenueToday' => 0,
                'totalRevenueWeek' => 0,
                'totalRevenueMonth' => 0,
                'topSellingProducts' => collect(),
                'monthlySalesData' => ['labels' => [], 'data' => []]
            ]);
        }

        // 2. Dapatkan semua OrderItem yang terkait dengan produk owner ini
        //    dan muat relasi order dan product
        $ownerOrderItems = OrderItem::whereIn('product_id', $ownerProductIds)
                                    ->with('order', 'product')
                                    ->get();

        // 3. Hitung Pendapatan
        $today = Carbon::now();
        $startOfWeek = Carbon::now()->startOfWeek();
        $startOfMonth = Carbon::now()->startOfMonth();

        $totalRevenueToday = 0;
        $totalRevenueWeek = 0;
        $totalRevenueMonth = 0;

        foreach ($ownerOrderItems as $item) {
            // Pastikan pesanan sudah completed atau sudah dibayar (sesuaikan status Anda)
            if ($item->order && $item->order->status === 'completed') {
                $itemRevenue = $item->quantity * $item->price;

                if ($item->order->created_at->isSameDay($today)) {
                    $totalRevenueToday += $itemRevenue;
                }
                if ($item->order->created_at->isBetween($startOfWeek, $today, true)) {
                    $totalRevenueWeek += $itemRevenue;
                }
                if ($item->order->created_at->isBetween($startOfMonth, $today, true)) {
                    $totalRevenueMonth += $itemRevenue;
                }
            }
        }

        // 4. Produk Paling Laris (Top Selling Products)
        // Agregasi jumlah terjual per produk dari ownerOrderItems
        $topSellingProducts = $ownerOrderItems->groupBy('product_id')
            ->map(function ($items, $productId) {
                $totalSold = $items->filter(function($item) {
                    return $item->order && $item->order->status === 'completed';
                })->sum('quantity');

                $productName = Product::find($productId)->name ?? 'Produk Tidak Ditemukan';
                return (object)['product_name' => $productName, 'total_sold' => $totalSold];
            })
            ->sortByDesc('total_sold')
            ->take(5);

        // 5. Data Penjualan Bulanan (untuk Chart.js)
        $monthlySales = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $monthName = $month->translatedFormat('M Y');
            $monthlySales[$monthName] = 0;
        }

        foreach ($ownerOrderItems as $item) {
            if ($item->order && $item->order->status === 'completed') {
                $orderMonth = $item->order->created_at->translatedFormat('M Y');
                if (isset($monthlySales[$orderMonth])) {
                    $monthlySales[$orderMonth] += ($item->quantity * $item->price);
                }
            }
        }

        $monthlySalesLabels = array_keys($monthlySales);
        $monthlySalesData = array_values($monthlySales);

        return view('owner.statistics', [
            'totalRevenueToday' => $totalRevenueToday,
            'totalRevenueWeek' => $totalRevenueWeek,
            'totalRevenueMonth' => $totalRevenueMonth,
            'topSellingProducts' => $topSellingProducts,
            'monthlySalesData' => [
                'labels' => $monthlySalesLabels,
                'data' => $monthlySalesData
            ]
        ]);
    }

    // ... (metode lain seperti show, reply, destroy jika ada)
}