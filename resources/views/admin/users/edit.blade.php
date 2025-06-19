@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Edit Pengguna</h1>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 fw-bold text-primary">Form Edit Pengguna</h6>
    </div>
    <div class="card-body">
        <form action="{{ url('/admin/users/' . 1) }}" method="POST"> {{-- Ganti '1' dengan $user->id --}}
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="name" class="form-label">Nama</label>
                <input type="text" class="form-control" id="name" name="name" value="Admin Utama" required> {{-- Ganti dengan $user->name --}}
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="admin@example.com" required> {{-- Ganti dengan $user->email --}}
            </div>
            <div class="mb-3">
                <label for="role" class="form-label">Peran</label>
                <select class="form-select" id="role" name="role" required>
                    <option value="admin" selected>Admin</option> {{-- Sesuaikan dengan $user->role --}}
                    <option value="owner">Owner</option>
                    <option value="pelanggan">Pelanggan</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password (Kosongkan jika tidak diubah)</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
            </div>
            <button type="submit" class="btn btn-primary">Update Pengguna</button>
            <a href="{{ url('/admin/users') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection
