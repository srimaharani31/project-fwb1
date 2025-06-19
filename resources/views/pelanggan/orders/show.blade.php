@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Detail Pesanan #PEL-{{ $order->id }}</h1>
</div>

<div class="row">
    <div class="col-lg-8 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 fw-bold text-primary">Informasi Pesanan</h6>
            </div>
            <div class="card-body">
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
                <p><strong>Status Pesanan:</strong> <span class="badge {{ $badgeClass }}">{{ ucfirst(str_replace('_', ' ', $order->status)) }}</span></p>
                <p><strong>Tanggal Pesan:</strong> {{ $order->created_at->format('d M Y, H:i') }}</p>
                <p><strong>Alamat Pengiriman:</strong> {{ $order->shipping_address ?? 'Belum ada alamat' }}</p> {{-- Pastikan kolom ini ada di database --}}
                <p><strong>Metode Pembayaran:</strong> {{ $order->payment_method ?? 'Belum ada metode pembayaran' }}</p> {{-- Pastikan kolom ini ada --}}

                <h6 class="mt-4 fw-bold">Item Pesanan:</h6>
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
                            @forelse ($order->orderItems as $item)
                                <tr>
                                    <td>{{ $item->product->name ?? 'Produk Tidak Ditemukan' }}</td>
                                    <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">Tidak ada item dalam pesanan ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3" class="text-end">Total:</th>
                                <th>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="d-flex justify-content-end mt-3">
                    <a href="{{ route('orders.index') }}" class="btn btn-secondary me-2">Kembali ke Daftar Pesanan</a>
                    {{-- Contoh tombol untuk aksi terkait status pesanan --}}
                    {{-- Anda bisa menambahkan logika kondisi di sini, misal: --}}
                    @if ($order->status == 'pending_payment')
                        <button class="btn btn-success">Konfirmasi Pembayaran</button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- <div class="col-lg-4 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 fw-bold text-primary">Berikan Ulasan</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('reviews.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="order_id" value="{{ $order->id }}">
                    <div class="mb-3">
                        <label for="product_id" class="form-label">Pilih Produk (untuk ulasan)</label>
                        <select class="form-select @error('product_id') is-invalid @enderror" id="product_id" name="product_id" required>
                            <option value="">Pilih Produk yang akan diulas</option>
                            {{-- Loop item produk dari pesanan ini yang didapatkan dari controller --}}
                            @foreach ($productsInOrder as $product)
                                <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                    {{ $product->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('product_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="rating" class="form-label">Rating</label>
                        <div>
                            <select class="form-select @error('rating') is-invalid @enderror" id="rating" name="rating" required>
                                <option value="">Pilih Rating</option>
                                <option value="5" {{ old('rating') == 5 ? 'selected' : '' }}>⭐⭐⭐⭐⭐ (5/5)</option>
                                <option value="4" {{ old('rating') == 4 ? 'selected' : '' }}>⭐⭐⭐⭐ (4/5)</option>
                                <option value="3" {{ old('rating') == 3 ? 'selected' : '' }}>⭐⭐⭐ (3/5)</option>
                                <option value="2" {{ old('rating') == 2 ? 'selected' : '' }}>⭐⭐ (2/5)</option>
                                <option value="1" {{ old('rating') == 1 ? 'selected' : '' }}>⭐ (1/5)</option>
                            </select>
                            @error('rating')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="comment" class="form-label">Komentar Anda</label>
                        <textarea class="form-control @error('comment') is-invalid @enderror" id="comment" name="comment" rows="4" placeholder="Bagaimana pengalaman Anda dengan produk ini?">{{ old('comment') }}</textarea>
                        @error('comment')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Kirim Ulasan</button>
                </form>
            </div>
        </div>
    </div> -->
</div>
@endsection