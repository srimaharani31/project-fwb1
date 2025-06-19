@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Daftar Pesanan</h1>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 fw-bold text-primary">Pesanan yang Mengandung Produk Anda</h6>
    </div>
    <div class="card-body">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>ID Pesanan</th>
                        <th>Pelanggan</th>
                        <th>Jumlah Produk Anda</th> {{-- Mengganti "Total Harga" untuk relevansi owner --}}
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orders as $order)
                        {{-- Hitung total harga produk milik owner dalam pesanan ini --}}
                        @php
                            $ownerSpecificTotalPrice = $order->orderItems->sum(function($item) {
                                return $item->quantity * $item->price;
                            });
                            // Tentukan kelas badge berdasarkan status
                            $badgeClass = '';
                            switch ($order->status) {
                                case 'pending_payment':
                                    $badgeClass = 'bg-warning'; // Kuning
                                    break;
                                case 'processing':
                                    $badgeClass = 'bg-info'; // Biru terang
                                    break;
                                case 'shipped':
                                    $badgeClass = 'bg-primary'; // Biru
                                    break;
                                case 'completed':
                                    $badgeClass = 'bg-success'; // Hijau
                                    break;
                                case 'cancelled':
                                    $badgeClass = 'bg-danger'; // Merah
                                    break;
                                default:
                                    $badgeClass = 'bg-secondary'; // Abu-abu
                                    break;
                            }
                        @endphp
                        <tr>
                            <td>#ORDER-{{ $order->id }}</td>
                            <td>{{ $order->user->name ?? 'Pelanggan Tidak Ditemukan' }}</td>
                            {{-- Menampilkan total harga produk owner dalam pesanan ini --}}
                            <td>Rp {{ number_format($ownerSpecificTotalPrice, 0, ',', '.') }}</td>
                            <td><span class="badge {{ $badgeClass }}">{{ ucfirst(str_replace('_', ' ', $order->status)) }}</span></td>
                            <td>{{ $order->created_at->format('d M Y, H:i') }}</td>
                            <td>
                                {{-- Link ke halaman detail pesanan owner --}}
                                <a href="{{ route('owner.orders.show', $order->id) }}" class="btn btn-sm btn-info"><i class="fas fa-eye"></i> Detail</a>
                                {{-- Tambahkan aksi lain seperti update status jika diperlukan --}}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Tidak ada pesanan yang mengandung produk Anda.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection