@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Dashboard Admin</h1>
</div>

<div class="row">
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col me-2">
                        <div class="text-xs fw-bold text-primary text-uppercase mb-1">
                            Jumlah Pengguna
                        </div>
                        <div class="h5 mb-0 fw-bold text-gray-800">{{ $totalUsers }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Card Total Produk --}}
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col me-2">
                        <div class="text-xs fw-bold text-success text-uppercase mb-1">
                            Total Produk
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

    {{-- Card Pesanan Baru --}}
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col me-2">
                        <div class="text-xs fw-bold text-info text-uppercase mb-1">
                            Pesanan Baru
                        </div>
                        <div class="h5 mb-0 fw-bold text-gray-800">{{ $newOrders }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-receipt fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Card Pendapatan Hari Ini --}}
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col me-2">
                        <div class="text-xs fw-bold text-warning text-uppercase mb-1">
                            Pendapatan Hari Ini
                        </div>
                        <div class="h5 mb-0 fw-bold text-gray-800">Rp {{ number_format($todayRevenue, 0, ',', '.') }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    {{-- Aktivitas Terkini --}}
    <div class="col-lg-6 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 fw-bold text-primary">Aktivitas Terkini</h6>
            </div>
            <div class="card-body">
                @forelse($recentActivities['users'] as $user)
                    <p>{{ $user->created_at->diffForHumans() }}: Pengguna baru '{{ $user->name }}' mendaftar.</p>
                @empty
                    <p>Tidak ada aktivitas pengguna baru.</p>
                @endforelse

                @forelse($recentActivities['orders'] as $order)
                    <p>{{ $order->created_at->diffForHumans() }}: Pesanan #{{ $order->id }} diterima.</p>
                @empty
                    <p>Tidak ada aktivitas pesanan baru.</p>
                @endforelse

                @forelse($recentActivities['products'] as $product)
                    <p>{{ $product->created_at->diffForHumans() }}: Produk '{{ $product->name }}' ditambahkan.</p>
                @empty
                    <p>Tidak ada aktivitas produk baru.</p>
                @endforelse

                @if(empty($recentActivities['users']->first()) && empty($recentActivities['orders']->first()) && empty($recentActivities['products']->first()))
                    <p>Belum ada aktivitas terkini.</p>
                @endif
            </div>
        </div>
    </div>
    

    <div class="col-lg-6 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 fw-bold text-primary">Laporan Penjualan (Contoh Grafik)</h6>
            </div>
            <div class="card-body">
                <canvas id="salesChart"></canvas>
                <p class="text-center text-muted mt-3">Grafik ini akan membutuhkan library seperti Chart.js. Data perlu disiapkan dari controller.</p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
{{-- Sertakan library Chart.js di sini jika belum ada di layout utama --}}
{{-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> --}}
<script>
    // Contoh data untuk grafik (Anda perlu mengisi ini dari controller juga)
    const salesData = {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'], // Bulan
        datasets: [{
            label: 'Penjualan',
            data: [1200000, 1500000, 1000000, 1800000, 2000000, 1700000], // Contoh data penjualan
            backgroundColor: 'rgba(78, 115, 223, 0.5)',
            borderColor: 'rgba(78, 115, 223, 1)',
            borderWidth: 1
        }]
    };

    const ctx = document.getElementById('salesChart').getContext('2d');
    const salesChart = new Chart(ctx, {
        type: 'bar', // Anda bisa ganti menjadi 'line', 'pie', dll.
        data: salesData,
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
@endpush