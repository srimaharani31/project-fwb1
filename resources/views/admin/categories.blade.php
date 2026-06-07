@extends('app')

@section('title', 'Admin - Categories')

@section('content')
<div class="container" style="padding: 2.5rem 0;">
    <div class="d-flex align-items-center justify-content-between mb-3">
        <h3 style="color:#2f2f2f; font-weight:800;">Kategori Produk</h3>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">Kembali</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row g-4">
        <div class="col-lg-5">
            <div class="card border-0" style="border-radius: 18px; box-shadow: 0 10px 25px rgba(0,0,0,.06);">
                <div class="card-body">
                    <h5 style="font-weight:800; color:#2f2f2f;">Tambah kategori</h5>
                    <form method="POST" action="{{ route('admin.categories.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Nama</label>
                            <input type="text" name="name" class="form-control" required maxlength="255">
                        </div>
                        <button class="btn btn-secondary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="card border-0" style="border-radius: 18px; box-shadow: 0 10px 25px rgba(0,0,0,.06);">
                <div class="card-body">
                    <h5 style="font-weight:800; color:#2f2f2f;">Daftar kategori</h5>

                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama</th>
                                <th style="width: 120px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categories as $c)
                                <tr>
                                    <td>{{ $c->id }}</td>
                                    <td>{{ $c->name }}</td>
                                    <td>
                                        <form method="POST" action="{{ route('admin.categories.delete', $c->id) }}" onsubmit="return confirm('Hapus kategori ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            @if($categories->count() === 0)
                                <tr><td colspan="3" class="text-center text-muted">Belum ada kategori</td></tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

