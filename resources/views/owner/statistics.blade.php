@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Statistik Bisnis Saya</h1>
</div>

<div class="row">
    <div class="col-lg-6 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 fw-bold text-primary">Penjualan Bulanan (Grafik Pendapatan)</h6>
            </div>
            <div class="card-body">
                <canvas id="monthlySalesChart"></canvas>
                <p class="text-center text-muted mt-3">Visualisasi data pendapatan produk Anda per bulan.</p>
            </div>
        </div>
    </div>
    <div class="col-lg-6 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 fw-bold text-primary">Produk Paling Laris Anda</h6>
            </div>
            <div class="card-body">
                @if($topSellingProducts->isEmpty())
                    <p class="text-center text-muted">Belum ada produk yang terjual.</p>
                @else
                    <ul class="list-group list-group-flush">
                        @foreach($topSellingProducts as $product)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ $product->product_name }}
                                <span class="badge bg-primary rounded-pill">{{ $product->total_sold }} Terjual</span>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 fw-bold text-primary">Ringkasan Pendapatan Produk Anda</h6>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-md-4">
                        <div class="h5 mb-0 text-success">Rp {{ number_format($totalRevenueMonth, 0, ',', '.') }}</div>
                        <div class="text-muted">Total Pendapatan Bulan Ini</div>
                    </div>
                    <div class="col-md-4">
                        <div class="h5 mb-0 text-info">Rp {{ number_format($totalRevenueWeek, 0, ',', '.') }}</div>
                        <div class="text-muted">Pendapatan Minggu Ini</div>
                    </div>
                    <div class="col-md-4">
                        <div class="h5 mb-0 text-warning">Rp {{ number_format($totalRevenueToday, 0, ',', '.') }}</div>
                        <div class="text-muted">Pendapatan Hari Ini</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
{{-- Sertakan Chart.js dari CDN --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Data dari controller untuk grafik
    const monthlySalesLabels = @json($monthlySalesData['labels']);
    const monthlySalesValues = @json($monthlySalesData['data']);

    // Inisialisasi Chart.js
    const ctx = document.getElementById('monthlySalesChart').getContext('2d');
    const monthlySalesChart = new Chart(ctx, {
        type: 'line', // Jenis grafik: garis
        data: {
            labels: monthlySalesLabels,
            datasets: [{
                label: 'Pendapatan Bulanan',
                data: monthlySalesValues,
                backgroundColor: 'rgba(78, 115, 223, 0.2)', // Warna latar belakang area di bawah garis
                borderColor: 'rgba(78, 115, 223, 1)', // Warna garis
                borderWidth: 2,
                fill: true, // Mengisi area di bawah garis
                tension: 0.4 // Membuat garis sedikit melengkung
            }]
        },
        options: {
            maintainAspectRatio: false,
            layout: {
                padding: {
                    left: 10,
                    right: 25,
                    top: 25,
                    bottom: 0
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false,
                        drawBorder: false
                    },
                    ticks: {
                        maxTicksLimit: 7
                    }
                },
                y: {
                    ticks: {
                        min: 0,
                        maxTicksLimit: 5,
                        padding: 10,
                        // Format mata uang Rupiah
                        callback: function(value, index, values) {
                            return 'Rp ' + value.toLocaleString('id-ID');
                        }
                    },
                    grid: {
                        color: "rgb(234, 236, 244)",
                        zeroLineColor: "rgb(234, 236, 244)",
                        drawBorder: false,
                        borderDash: [2],
                        zeroLineBorderDash: [2]
                    }
                },
            },
            plugins: {
                tooltip: {
                    backgroundColor: "rgb(255,255,255)",
                    bodyFontColor: "#858796",
                    titleMarginBottom: 10,
                    titleFontColor: '#6e707e',
                    titleFontSize: 14,
                    borderColor: '#dddfeb',
                    borderWidth: 1,
                    xPadding: 15,
                    yPadding: 15,
                    displayColors: false,
                    intersect: false,
                    mode: 'index',
                    caretPadding: 10,
                    callbacks: {
                        label: function(context) {
                            var label = context.dataset.label || '';
                            if (label) {
                                label += ': ';
                            }
                            return label + 'Rp ' + context.parsed.y.toLocaleString('id-ID');
                        }
                    }
                }
            }
        }
    });
});
</script>
@endpush