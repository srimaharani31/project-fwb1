@extends('layouts.app') 

@section('content')
<div class="container">
    <h1>Detail Pesanan #{{ $order->id }}</h1>

    <div class="card mb-4">
        <div class="card-header">
            Informasi Pesanan
        </div>
        <div class="card-body">
            <p><strong>Pelanggan:</strong> {{ $order->user->name ?? 'Pengguna Tidak Dikenal' }} ({{ $order->user->email ?? '-' }})</p>
            <p><strong>Tanggal Pesanan:</strong> {{ $order->created_at->format('d M Y H:i') }}</p>
            <p><strong>Jumlah Total:</strong> Rp{{ number_format($order->total_amount, 2, ',', '.') }}</p>
            <p><strong>Alamat Pengiriman:</strong> {{ $order->address ?? '-' }}</p>
            <p>
                <strong>Status:</strong>
                <span class="badge {{
                    $order->status == 'pending' ? 'bg-warning' :
                    ($order->status == 'paid' ? 'bg-info' :
                    ($order->status == 'shipped' ? 'bg-primary' :
                    ($order->status == 'completed' ? 'bg-success' :
                    'bg-danger')))
                }}">
                    {{ ucfirst($order->status) }}
                </span>
            </p>
            {{-- Form untuk update status bisa ditambahkan di sini --}}
            {{-- <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="form-group">
                    <label for="status">Ubah Status:</label>
                    <select name="status" id="status" class="form-control">
                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="paid" {{ $order->status == 'paid' ? 'selected' : '' }}>Paid</option>
                        <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                        <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary mt-2">Update Status</button>
            </form> --}}
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            Produk dalam Pesanan
        </div>
        <div class="card-body">
            @if ($order->orderDetails->isEmpty())
                <p>Tidak ada produk dalam pesanan ini.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th>Kuantitas</th>
                                <th>Harga Satuan</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->orderDetails as $detail)
                                <tr>
                                    <td>{{ $detail->product->name ?? 'Produk Tidak Dikenal' }}</td>
                                    <td>{{ $detail->quantity }}</td>
                                    <td>Rp{{ number_format($detail->price, 2, ',', '.') }}</td>
                                    <td>Rp{{ number_format($detail->quantity * $detail->price, 2, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary mt-3">Kembali ke Daftar Pesanan</a>
</div>
@endsection