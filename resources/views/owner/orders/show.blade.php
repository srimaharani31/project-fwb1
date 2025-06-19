{{-- Contoh sederhana untuk resources/views/owner/orders/show.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Detail Pesanan #ORDER-{{ $order->id }}</h1>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 fw-bold text-primary">Informasi Pesanan</h6>
    </div>
    <div class="card-body">
        <p><strong>Pelanggan:</strong> {{ $order->user->name ?? 'N/A' }}</p>
        <p><strong>Email Pelanggan:</strong> {{ $order->user->email ?? 'N/A' }}</p>
        <p><strong>Total Harga Pesanan:</strong> Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
        <p><strong>Status:</strong> <span class="badge bg-info">{{ ucfirst(str_replace('_', ' ', $order->status)) }}</span></p>
        <p><strong>Tanggal Pesan:</strong> {{ $order->created_at->format('d M Y, H:i') }}</p>
        <p><strong>Alamat Pengiriman:</strong> {{ $order->shipping_address ?? '-' }}</p>
        <p><strong>Metode Pembayaran:</strong> {{ $order->payment_method ?? '-' }}</p>

        <h6 class="mt-4 fw-bold">Detail Produk Anda dalam Pesanan Ini:</h6>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Harga Satuan</th>
                        <th>Jumlah</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Loop melalui item-item pesanan yang sudah difilter di controller --}}
                    @forelse ($order->orderItems as $item)
                        <tr>
                            <td>{{ $item->product->name ?? 'Produk Tidak Ditemukan' }}</td>
                            <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">Tidak ada produk Anda dalam pesanan ini.</td>
                        </tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3" class="text-end">Total Harga Produk Anda:</th>
                        <th>Rp {{ number_format($order->orderItems->sum(function($item) { return $item->quantity * $item->price; }), 0, ',', '.') }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="d-flex justify-content-end mt-3">
            <a href="{{ route('owner.orders.index') }}" class="btn btn-secondary">Kembali ke Daftar Pesanan</a>
            {{-- Tambahkan tombol aksi seperti update status, dll. jika diperlukan --}}
            {{-- Contoh:
            @if ($order->status == 'pending_payment')
                <button class="btn btn-success ms-2">Konfirmasi Pembayaran</button>
            @endif
            --}}
        </div>
    </div>
</div>
@endsection