@extends('app')

@section('title', 'Dashboard Admin')

@section('content')
<section class="hero" style="padding: 3.5rem 0 2rem 0;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="text-white" style="margin-bottom: 10px;">Dashboard Admin</h1>
                <p class="text-white" style="opacity: .7; margin-bottom: 0;">Kelola produk, kategori, pesanan, dan data user.</p>
            </div>
            <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                <a href="/logout" class="btn btn-white-outline">Logout</a>
            </div>
        </div>
    </div>
</section>

<section class="product-section" style="padding: 2.5rem 0 4rem 0;">
    <div class="container">
        @if (session('success'))
            <div class="alert alert-success" role="alert">{{ session('success') }}</div>
        @endif

        <div class="row g-4">
            <div class="col-md-6 col-lg-3">
href="{{ route('admin.users') }}"
                    <div class="card" style="border: 0; border-radius: 18px; background: #ffffff; box-shadow: 0 10px 25px rgba(0,0,0,.06);">
                        <div class="card-body">
                            <h5 style="font-weight: 800; color:#2f2f2f;">Users</h5>
                            <p class="mb-0" style="color:#6a6a6a;">Kelola owner & pelanggan</p>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-6 col-lg-3">
<a href="{{ route('admin.categories') }}" class="product-item" style="text-decoration:none;">
                    <div class="card" style="border: 0; border-radius: 18px; background: #ffffff; box-shadow: 0 10px 25px rgba(0,0,0,.06);">
                        <div class="card-body">
                            <h5 style="font-weight: 800; color:#2f2f2f;">Categories</h5>
                            <p class="mb-0" style="color:#6a6a6a;">Atur kategori produk</p>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-6 col-lg-3">
<a href="{{ route('admin.products') }}" class="product-item" style="text-decoration:none;">
                    <div class="card" style="border: 0; border-radius: 18px; background: #ffffff; box-shadow: 0 10px 25px rgba(0,0,0,.06);">
                        <div class="card-body">
                            <h5 style="font-weight: 800; color:#2f2f2f;">Products</h5>
                            <p class="mb-0" style="color:#6a6a6a;">Tambah & ubah produk</p>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-6 col-lg-3">
<a href="{{ route('admin.orders') }}" class="product-item" style="text-decoration:none;">
                    <div class="card" style="border: 0; border-radius: 18px; background: #ffffff; box-shadow: 0 10px 25px rgba(0,0,0,.06);">
                        <div class="card-body">
                            <h5 style="font-weight: 800; color:#2f2f2f;">Orders</h5>
                            <p class="mb-0" style="color:#6a6a6a;">Lihat pesanan masuk</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-12">
                <div class="card" style="border: 0; border-radius: 18px; background: #dce5e4;">
                    <div class="card-body p-4">
                        <h5 style="font-weight: 800; color:#2f2f2f;">Tips</h5>
                        <p class="mb-0" style="color:#6a6a6a;">
                            Karena route resource lain saat ini sudah dimatikan di `routes/web.php`, tombol di atas mungkin belum mengarah ke halaman list.
                            Untuk tampilan yang lebih lengkap, aktifkan route resource admin sesuai controller yang tersedia.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
