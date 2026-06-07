@extends('app')

@section('title', 'Admin - Products')

@section('content')
<div class="container" style="padding: 2.5rem 0;">
    <div class="d-flex align-items-center justify-content-between mb-3">
        <h3 style="color:#2f2f2f; font-weight:800;">Produk</h3>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">Kembali</a>
    </div>

    <div class="card border-0" style="border-radius: 18px; box-shadow: 0 10px 25px rgba(0,0,0,.06);">
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Owner</th>
                        <th style="width: 120px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $p)
                        <tr>
                            <td>{{ $p->id }}</td>
                            <td>{{ $p->name }}</td>
                            <td>{{ $p->price }}</td>
                            <td>{{ $p->stock }}</td>
                            <td>{{ optional($p->owner)->name ?? $p->owner_id }}</td>
                            <td>
                                <form method="POST" action="{{ route('admin.products.delete', $p->id) }}" onsubmit="return confirm('Hapus produk ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    @if($products->count() === 0)
                        <tr><td colspan="6" class="text-center text-muted">Belum ada produk</td></tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

