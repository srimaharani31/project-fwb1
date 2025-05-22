@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
    <div class="alert alert-primary">
        Selamat datang di dashboard, <strong>{{ Auth::user()->name }}</strong>!
    </div>

   <div class="container py-5">
        <div class="card shadow-sm">
            <div class="card-body">
                <h1 class="card-title text-primary">Admin Dashboard</h1>
                <p class="card-text">Selamat datang, <strong>{{ Auth::user()->name }}</strong>!</p>
                <hr>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">Kelola pengguna</li>
                    <li class="list-group-item">Kelola kategori & produk</li>
                    <li class="list-group-item">Laporan penjualan</li>
                </ul>
            </div>
        </div>
    </div>
@endsection
