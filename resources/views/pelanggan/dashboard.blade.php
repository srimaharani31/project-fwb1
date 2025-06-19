@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Dashboard Pelanggan</h1>
</div>

<div class="row">
    {{-- Card: Pesanan Aktif --}}
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col me-2">
                        <div class="text-xs fw-bold text-primary text-uppercase mb-1">
                            Pesanan Aktif
                        </div>
                        {{-- Data dinamis: {{ $activeOrdersCount }} --}}
                        <div class="h5 mb-0 fw-bold text-gray-800">{{ $activeOrdersCount ?? 0 }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-receipt fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Card: Total Pembelian --}}
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col me-2">
                        <div class="text-xs fw-bold text-success text-uppercase mb-1">
                            Total Pembelian
                        </div>
                        {{-- Data dinamis: {{ $totalPurchaseAmount }} --}}
                        <div class="h5 mb-0 fw-bold text-gray-800">{{ 'Rp ' . number_format($totalPurchaseAmount ?? 0, 0, ',', '.') }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Card: Jumlah Produk Diinginkan (Wishlist) --}}
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col me-2">
                        <div class="text-xs fw-bold text-info text-uppercase mb-1">
                            Jumlah Produk Diinginkan
                        </div>
                        {{-- Data dinamis: {{ $wishlistCount }} --}}
                        <div class="h5 mb-0 fw-bold text-gray-800">{{ $wishlistCount ?? 0 }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-heart fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    {{-- Card: Pesanan Terbaru Anda --}}
    <div class="col-lg-6 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 fw-bold text-primary">Pesanan Terbaru Anda</h6>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    @forelse($recentOrders as $order)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Pesanan #{{ $order->order_number ?? $order->id }} - {{ 'Rp ' . number_format($order->total_amount ?? 0, 0, ',', '.') }}
                            @php
                                $badgeClass = 'bg-secondary'; // Default
                                switch($order->status) {
                                    case 'pending':
                                        $badgeClass = 'bg-warning';
                                        break;
                                    case 'processing':
                                        $badgeClass = 'bg-info';
                                        break;
                                    case 'completed':
                                        $badgeClass = 'bg-success';
                                        break;
                                    case 'cancelled':
                                        $badgeClass = 'bg-danger';
                                        break;
                                    default:
                                        $badgeClass = 'bg-secondary';
                                        break;
                                }
                            @endphp
                            <span class="badge {{ $badgeClass }}">{{ ucfirst($order->status) }}</span>
                        </li>
                    @empty
                        <li class="list-group-item text-center text-muted">
                            Belum ada pesanan terbaru.
                        </li>
                    @endforelse
                </ul>
                <a href="{{ route('orders.index') }}" class="btn btn-outline-primary mt-3">Lihat Semua Pesanan</a>
            </div>
        </div>
    </div>

    {{-- Card: Jelajahi Produk --}}
    <div class="col-lg-6 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 fw-bold text-primary">Jelajahi Produk</h6>
            </div>
            <div class="card-body text-center">
                <p>Temukan produk-produk menarik yang mungkin Anda suka!</p>
                <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg">Mulai Belanja Sekarang <i class="fas fa-arrow-right ms-2"></i></a>
            </div>
        </div>
    </div>
</div>
@endsection