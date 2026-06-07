@extends('app')

@section('title', 'Admin - Reports')

@section('content')
<div class="container" style="padding: 2.5rem 0;">
    <div class="d-flex align-items-center justify-content-between mb-3">
        <h3 style="color:#2f2f2f; font-weight:800;">Reports</h3>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">Kembali</a>
    </div>

    <div class="card border-0" style="border-radius: 18px; box-shadow: 0 10px 25px rgba(0,0,0,.06);">
        <div class="card-body">
            <p class="text-muted mb-3">Halaman reports membutuhkan model & data report yang sesuai.</p>

            @if($reports->count() === 0)
                <div class="text-center text-muted">Belum ada data report</div>
            @else
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>User</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reports as $r)
                            <tr>
                                <td>{{ $r->id }}</td>
                                <td>{{ optional($r->user)->name ?? $r->user_id }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>
@endsection

