@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Ulasan Produk Saya</h1>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 fw-bold text-primary">Daftar Ulasan Produk Anda</h6>
    </div>
    <div class="card-body">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>ID Ulasan</th>
                        <th>Produk</th>
                        <th>Pelanggan</th>
                        <th>Rating</th>
                        <th>Ulasan</th>
                        <th>Balasan Anda</th> {{-- Kolom baru untuk balasan owner --}}
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($reviews as $review)
                        <tr>
                            <td>#{{ $review->id }}</td>
                            <td>{{ $review->product->name ?? 'Produk Tidak Ditemukan' }}</td>
                            <td>{{ $review->user->name ?? 'Pelanggan Tidak Ditemukan' }}</td>
                            <td class="text-warning">
                                @for ($i = 0; $i < $review->rating; $i++)
                                    <i class="fas fa-star"></i>
                                @endfor
                                @for ($i = $review->rating; $i < 5; $i++)
                                    <i class="far fa-star"></i> {{-- Bintang kosong untuk rating kurang dari 5 --}}
                                @endfor
                                ({{ $review->rating }}/5)
                            </td>
                            <td>{{ $review->comment }}</td>
                            <td>
                                @if ($review->reply)
                                    <p class="text-success small">Sudah dibalas: {{ $review->reply }}</p>
                                    <span class="text-muted small">({{ $review->replied_at->format('d M Y, H:i') }})</span>
                                @else
                                    <span class="text-muted small">Belum dibalas</span>
                                @endif
                            </td>
                            <td>{{ $review->created_at->format('d M Y, H:i') }}</td>
                            <td>
                                @if (!$review->reply)
                                    {{-- Tombol Balas akan membuka modal dan mengisi review_id --}}
                                    <button class="btn btn-sm btn-info btn-reply"
                                            data-bs-toggle="modal"
                                            data-bs-target="#replyModal"
                                            data-review-id="{{ $review->id }}">
                                        <i class="fas fa-reply"></i> Balas
                                    </button>
                                @else
                                    {{-- Jika sudah dibalas, bisa tampilkan tombol edit balasan --}}
                                    <button class="btn btn-sm btn-secondary btn-reply"
                                            data-bs-toggle="modal"
                                            data-bs-target="#replyModal"
                                            data-review-id="{{ $review->id }}"
                                            data-reply-message="{{ $review->reply }}">
                                        <i class="fas fa-edit"></i> Edit Balasan
                                    </button>
                                @endif
                                <form action="{{ route('owner.reviews.destroy', $review->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus ulasan ini?')">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">Tidak ada ulasan untuk produk Anda.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="replyModal" tabindex="-1" aria-labelledby="replyModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="replyModalLabel">Balas Ulasan</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="replyForm" method="POST">
                    @csrf
                    {{-- @method('PUT') // Gunakan PUT jika ingin update balasan --}}
                    <input type="hidden" id="reviewId" name="review_id">
                    <div class="mb-3">
                        <label for="replyMessage" class="form-label">Pesan Balasan</label>
                        <textarea class="form-control" id="replyMessage" name="reply_message" rows="4" placeholder="Ketik balasan Anda di sini..." required></textarea>
                        <div class="invalid-feedback">
                            Silakan masukkan balasan Anda.
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" form="replyForm" class="btn btn-primary">Kirim Balasan</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    var replyModal = document.getElementById('replyModal');
    replyModal.addEventListener('show.bs.modal', function (event) {
        // Button yang memicu modal
        var button = event.relatedTarget
        // Ambil informasi dari atribut data-*
        var reviewId = button.getAttribute('data-review-id')
        var replyMessage = button.getAttribute('data-reply-message') // Mengambil balasan yang sudah ada

        // Perbarui aksi form di modal
        var form = replyModal.querySelector('#replyForm')
        form.action = `/owner/reviews/${reviewId}/reply` // Update aksi form untuk rute yang benar

        // Perbarui input hidden dengan review_id
        var modalReviewIdInput = replyModal.querySelector('#reviewId')
        modalReviewIdInput.value = reviewId

        // Isi textarea balasan jika sudah ada balasan sebelumnya
        var modalReplyMessageTextarea = replyModal.querySelector('#replyMessage')
        if (replyMessage) {
            modalReplyMessageTextarea.value = replyMessage
        } else {
            modalReplyMessageTextarea.value = '' // Kosongkan jika belum ada balasan
        }
    })
});
</script>
@endpush