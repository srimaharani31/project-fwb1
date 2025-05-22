
@extends('layouts.app')

@section('title', 'Dashboard Pelanggang')

@section('content')
    <div class="alert alert-primary">
        Selamat datang di dashboard, <strong>{{ Auth::user()->name }}</strong>!
    </div>

   <div class="container py-5">
        <div class="card shadow-sm">
            <div class="card-body">
                <h1 class="card-title text-purple">Dashboard Pelanggan</h1>
                <p class="card-text">Hai, <strong>{{ Auth::user()->name }}</strong>!</p>
                <hr>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">Jelajahi produk thrift</li>
                    <li class="list-group-item">Lacak pesanan kamu</li>
                    <li class="list-group-item">Kelola akun</li>
                </ul>
            </div>
        </div>
    </div>
@endsection
