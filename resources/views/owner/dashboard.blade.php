@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Dashboard Owner</h1>
</div>

<div class="row">
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col me-2">
                        <div class="text-xs fw-bold text-primary text-uppercase mb-1">
                            Total Produk Saya
                        </div>
                        <div class="h5 mb-0 fw-bold text-gray-800">{{ $totalProducts }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-box-open fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col me-2">
                        <div class="text-xs fw-bold text-success text-uppercase mb-1">
                            Pesanan Terbaru
                        </div>
                        <div class="h5 mb-0 fw-bold text-gray-800">{{ $recentOrdersCount }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-receipt fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col me-2">
                        <div class="text-xs fw-bold text-info text-uppercase mb-1">
                            Ulasan Baru
                        </div>
                        <div class="h5 mb-0 fw-bold text-gray-800">{{ $newReviewsCount }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-star fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 fw-bold text-primary">Statistik Penjualan Ringkas Produk Anda</h6>
            </div>
            <div class="card-body">
                <p>Total Pendapatan Bulan Ini: <strong>Rp {{ number_format($totalRevenueMonth, 0, ',', '.') }}</strong></p>
                <p>Produk Paling Laris: <strong>{{ $topSellingProductName }}</strong></p>
                <p>Rata-rata Rating Produk:
                    <strong class="text-warning">
                        @if($averageProductRating !== 'N/A')
                            @for($i = 0; $i < floor($averageProductRating); $i++)
                                <i class="fas fa-star"></i>
                            @endfor
                            @if($averageProductRating - floor($averageProductRating) > 0)
                                <i class="fas fa-star-half-alt"></i>
                            @endif
                            ({{ $averageProductRating }}/5)
                        @else
                            N/A
                        @endif
                    </strong>
                </p>
                <a href="{{ route('owner.statistics') }}" class="btn btn-outline-primary mt-3">Lihat Statistik Lengkap</a>
            </div>
        </div>
    </div>
</div>
@endsection