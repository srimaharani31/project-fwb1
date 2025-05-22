@extends('layouts.app')

@section('title', 'Dashboard Owner')

@section('content')
    <div class="alert alert-primary">
        Selamat datang di dashboard, <strong>{{ Auth::user()->name }}</strong>!
    </div>

   <div class="container py-5">
        <div class="card shadow-sm">
            <div class="card-body">
                <h1 class="card-title text-success">Owner Dashboard</h1>
                <p class="card-text">Halo, <strong>{{ Auth::user()->name }}</strong>!</p>
                <hr>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">Kelola produk kamu</li>
                    <li class="list-group-item">Stok & pesanan</li>
                    <li class="list-group-item">Performa penjualan</li>
                </ul>
            </div>
        </div>
    </div>
@endsection
