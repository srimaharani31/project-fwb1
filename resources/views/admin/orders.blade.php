@extends('app')

@section('title', 'Admin - Orders')

@section('content')
<div class="container" style="padding: 2.5rem 0;">
    <div class="d-flex align-items-center justify-content-between mb-3">
        <h3 style="color:#2f2f2f; font-weight:800;">Orders</h3>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">Kembali</a>
    </div>

    <div class="card border-0" style="border-radius: 18px; box-shadow: 0 10px 25px rgba(0,0,0,.06);">
        <div class="card-body">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User</th>
                        <th>Total</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $o)
                        <tr>
                            <td>{{ $o->id }}</td>
                            <td>{{ optional($o->user)->name ?? $o->user_id }}</td>
                            <td>{{ $o->total_price }}</td>
                            <td>
                                <span class="badge bg-secondary">{{ $o->status }}</span>
                            </td>
                        </tr>
                    @endforeach
                    @if($orders->count() === 0)
                        <tr><td colspan="4" class="text-center text-muted">Belum ada order</td></tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

