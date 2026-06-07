@extends('app')

@section('title', 'Admin - Users')

@section('content')
<div class="container" style="padding: 2.5rem 0;">
    <div class="d-flex align-items-center justify-content-between mb-3">
        <h3 style="color:#2f2f2f; font-weight:800;">Daftar Users</h3>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">Kembali</a>
    </div>

    <div class="card border-0" style="border-radius: 18px; box-shadow: 0 10px 25px rgba(0,0,0,.06);">
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th style="width: 120px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $u)
                        <tr>
                            <td>{{ $u->id }}</td>
                            <td>{{ $u->name }}</td>
                            <td>{{ $u->email }}</td>
                            <td>{{ $u->role }}</td>
                            <td>
                                <form method="POST" action="{{ route('admin.users.delete', $u->id) }}" onsubmit="return confirm('Hapus user ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    @if($users->count() === 0)
                        <tr><td colspan="5" class="text-center text-muted">Belum ada user</td></tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

