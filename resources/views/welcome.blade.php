@extends('layouts.app')

@section('title', 'Beranda | Toko Thrift Shop')

@section('content')
<div class="container py-5 text-center">
    <div class="row align-items-center">
        <div class="col-md-6 mb-4">
            <h1 class="display-4 fw-bold">Selamat Datang di <span class="text-primary">Toko Thrift Shop</span></h1>
            <p class="lead mt-3">
                Temukan berbagai macam pakaian bekas berkualitas dan hemat di kantong. Yuk mulai belanja sekarang!
            </p>
          
        </div>
        <div class="col-md-6">
            <img src="https://source.unsplash.com/600x400/?thrift,clothes" alt="Thrift Shop" class="img-fluid rounded shadow">
        </div>
    </div>
</div>

<div class="bg-light py-5">
    <div class="container text-center">
        <h2 class="fw-bold mb-4">Kenapa Belanja di Sini?</h2>
        <div class="row justify-content-center">
            <div class="col-md-3 mb-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <h5 class="card-title">Harga Terjangkau</h5>
                        <p class="card-text">Produk thrift dengan kualitas terbaik dan harga ramah dompet.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <h5 class="card-title">Pilihan Beragam</h5>
                        <p class="card-text">Berbagai kategori dan model fashion tersedia untuk kamu pilih.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <h5 class="card-title">Belanja Mudah</h5>
                        <p class="card-text">Tinggal klik, bayar, dan tunggu produk sampai di rumahmu.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
