@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Pesanan Saya</h1>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 fw-bold text-primary">Daftar Semua Pesanan Anda</h6>
    </div>
    <div class="card-body">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>ID Pesanan</th>
                        <th>Tanggal Pesan</th>
                        <th>Total Harga</th>
                        <th>Status</th>
                        <th>Aksi</th> {{-- Tambahkan kolom Aksi --}}
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orders as $order)
                        <tr>
                            <td>#PEL-{{ $order->id }}</td>
                            <td>{{ $order->created_at->format('Y-m-d H:i') }}</td>
                            <td>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                            <td>
                                @php
                                    $badgeClass = '';
                                    switch ($order->status) {
                                        case 'pending_payment':
                                            $badgeClass = 'bg-warning';
                                            break;
                                        case 'processing':
                                            $badgeClass = 'bg-info';
                                            break;
                                        case 'shipped':
                                            $badgeClass = 'bg-primary';
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
                                <span class="badge {{ $badgeClass }}">{{ ucfirst(str_replace('_', ' ', $order->status)) }}</span>
                            </td>
                            <td>
                                {{-- Tombol Detail --}}
                                <a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm btn-info me-1"><i class="fas fa-eye"></i> Detail</a>

                                {{-- Tombol Batalkan (hanya jika status memungkinkan) --}}
                                @if ($order->status == 'pending_payment' || $order->status == 'processing')
                                    <form action="{{ route('orders.cancel', $order->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PUT') {{-- Gunakan PUT untuk update status --}}
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin membatalkan pesanan ini? Aksi ini tidak dapat dibatalkan.');">
                                            <i class="fas fa-times-circle"></i> Batalkan
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Anda belum memiliki pesanan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection