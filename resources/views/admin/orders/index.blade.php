@extends('layouts.app') 

@section('content')
<div class="container">
    <h1>Daftar Pesanan</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>ID Pesanan</th>
                    <th>Pelanggan</th>
                    <th>Jumlah Total</th>
                    <th>Alamat Pengiriman</th>
                    <th>Status</th>
                    <th>Tanggal Pesanan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->user->name ?? 'Pengguna Tidak Dikenal' }}</td> {{-- Menampilkan nama pengguna --}}
                        <td>Rp{{ number_format($order->total_amount, 2, ',', '.') }}</td>
                        <td>{{ $order->address }}</td>
                        <td>
                            <span class="badge {{
                                $order->status == 'pending' ? 'bg-warning' :
                                ($order->status == 'paid' ? 'bg-info' :
                                ($order->status == 'shipped' ? 'bg-primary' :
                                ($order->status == 'completed' ? 'bg-success' :
                                'bg-danger')))
                            }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td>{{ $order->created_at->format('d M Y H:i') }}</td>
                        <td>
                            <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-info btn-sm">Lihat</a>
                            {{-- Tambahkan tombol aksi lain jika diperlukan, misalnya untuk update status --}}
                            {{-- <a href="{{ route('admin.orders.edit', $order->id) }}" class="btn btn-warning btn-sm">Edit</a> --}}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">Tidak ada pesanan ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection