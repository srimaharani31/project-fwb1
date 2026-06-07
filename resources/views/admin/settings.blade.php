@extends('app')

@section('title', 'Admin - Settings')

@section('content')
<div class="container" style="padding: 2.5rem 0;">
    <div class="d-flex align-items-center justify-content-between mb-3">
        <h3 style="color:#2f2f2f; font-weight:800;">Settings</h3>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">Kembali</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card border-0" style="border-radius: 18px; box-shadow: 0 10px 25px rgba(0,0,0,.06);">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.settings.save') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Contoh Setting</label>
                    <input type="text" class="form-control" name="dummy" placeholder="(contoh) pengaturan">
                </div>
                <button class="btn btn-secondary">Simpan</button>
            </form>
        </div>
    </div>
</div>
@endsection

