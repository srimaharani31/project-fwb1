{{-- resources/views/products/index.blade.php --}}

@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h1>Daftar Produk</h1>
        <hr>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @auth
            @if(Auth::user()->role === 'owner')
                <a href="{{ route('products.create') }}" class="btn btn-primary mb-3">Tambah Produk Baru</a>
            @endif
            {{-- Tambahkan tautan untuk melihat daftar pesanan --}}
            <!-- <a href="{{ route('orders.index') }}" class="btn btn-secondary mb-3">Lihat Pesanan Saya/Semua Pesanan</a> -->
                 @if(Auth::user()->role === 'pelanggan')
                <a href="{{ route('orders.index') }}" class="btn btn-secondary mb-3">Lihat Pesanan Saya/Semua Pesanan</a>
    @endif
        @endauth

        <div class="row">
            @forelse ($products as $product)
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}" style="height: 200px; object-fit: cover;">
                        @else
                            <img src="https://via.placeholder.com/200" class="card-img-top" alt="No Image" style="height: 200px; object-fit: cover;">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text">{{ Str::limit($product->description, 100) }}</p>
                            <p class="card-text"><strong>Harga:</strong> Rp{{ number_format($product->price, 2, ',', '.') }}</p>
                            <p class="card-text"><strong>Stok:</strong> {{ $product->stock }}</p>
                            <p class="card-text"><small class="text-muted">Dibuat oleh: {{ $product->user->name ?? 'N/A' }}</small></p>
                            <p class="card-text"><small class="text-muted">Kategori: {{ $product->category->name ?? 'Tidak ada' }}</small></p>
                            <a href="{{ route('products.show', $product->id) }}" class="btn btn-info btn-sm">Detail</a>

                            @auth
                                @if(Auth::user()->role === 'owner' && Auth::id() === $product->user_id || Auth::user()->role === 'admin')
                                    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">Hapus</button>
                                    </form>
                                @endif
                                @if(Auth::user()->role === 'pelanggan')
                                    @if($product->stock > 0)
                                        <form action="{{ route('products.buy', $product->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm">Beli Sekarang</button>
                                        </form>
                                    @else
                                        <button class="btn btn-secondary btn-sm" disabled>Stok Habis</button>
                                    @endif
                                @endif
                            @endauth
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <p>Tidak ada produk ditemukan.</p>
                </div>
            @endforelse
        </div>
        <div class="d-flex justify-content-center">
            {{ $products->links() }}
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
@endsection