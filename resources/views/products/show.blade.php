@extends('layouts.app')

@section('content')

    <div class="container mt-5">
        <h1>Detail Produk: {{ $product->name }}</h1>
        <hr>
        <a href="{{ route('products.index') }}" class="btn btn-secondary mb-3">Kembali ke Daftar Produk</a>

        <div class="card">
            <div class="row g-0">
                <div class="col-md-4">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" class="img-fluid rounded-start" alt="{{ $product->name }}">
                    @else
                        <img src="https://via.placeholder.com/400" class="img-fluid rounded-start" alt="No Image">
                    @endif
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text">{{ $product->description ?? 'Tidak ada deskripsi.' }}</p>
                        <p class="card-text"><strong>Harga:</strong> Rp{{ number_format($product->price, 2, ',', '.') }}</p>
                        <p class="card-text"><strong>Stok:</strong> {{ $product->stock }}</p>
                        <p class="card-text"><strong>Kategori:</strong> {{ $product->category->name ?? 'Tidak ada' }}</p>
                        <p class="card-text"><small class="text-muted">Dibuat oleh: {{ $product->user->name ?? 'N/A' }} pada {{ $product->created_at->format('d M Y H:i') }}</small></p>

                        @auth
                            @if(Auth::user()->role === 'owner' && Auth::id() === $product->user_id || Auth::user()->role === 'admin')
                                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning">Edit Produk</a>
                                <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">Hapus Produk</button>
                                </form>
                            @endif
                            @if(Auth::user()->role === 'pelanggan')
                                <button class="btn btn-success">Tambahkan ke Keranjang</button>
                                {{-- Atau form untuk langsung beli --}}
                            @endif
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
@endsection