@extends('app')

@section('title', 'Home')

@section('content')
<section class="untree_co-section">
    <div class="container">
        <div class="row mb-4">
            <div class="col-12">
                <h2 class="mb-1">Produk Terbaru</h2>
                <p class="text-muted mb-0">Tampilan home minimal agar route utama tidak error.</p>
            </div>
        </div>

        <div class="row">
            @foreach(($products ?? collect()) as $p)
                <div class="col-6 col-md-4 col-lg-3 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">{{ $p->name }}</h5>
                            <p class="card-text">Harga: {{ $p->price }}</p>
                        </div>
                    </div>
                </div>
            @endforeach

            @if(!isset($products) || ($products ?? collect())->count() === 0)
                <div class="col-12">
                    <p class="text-muted mb-0">Belum ada produk.</p>
                </div>
            @endif
        </div>
    </div>
</section>
@endsection

