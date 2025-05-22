@extends('layouts.app')

@section('content')
<div class="container py-5" style="max-width: 800px;">
    <h1 class="mb-4 text-center text-primary fw-bold" style="font-weight: 700; font-size: 2.4rem;">Daftar Tugas</h1>

    @if(session('success'))
        <div class="alert alert-success text-center rounded-3 shadow-sm">{{ session('success') }}</div>
    @endif

    <div class="d-flex justify-content-end mb-4">
        <a href="{{ route('tugas.create') }}" class="btn btn-primary shadow rounded-3 px-4 py-2 fw-semibold">
            <i class="bi bi-plus-lg me-2"></i> Tambah Tugas
        </a>
    </div>

    {{-- List Tugas --}}
    <div class="list-group">
        @forelse ($tugas as $item)
        <div class="list-group-item mb-3 rounded-4 shadow-sm d-flex justify-content-between align-items-center
            {{ $item->status == 'selesai' ? 'bg-light text-muted' : 'bg-white' }}"
            style="transition: box-shadow 0.3s ease, transform 0.2s ease;">

            <div class="d-flex align-items-center" style="gap: 1rem; min-width: 0;">
                <input class="form-check-input" type="checkbox"
                    data-id="{{ $item->id }}"
                    {{ $item->status == 'selesai' ? 'checked' : '' }}
                    style="width: 20px; height: 20px; cursor: pointer;">

                <div class="text-truncate" style="min-width: 0;">
                    <strong class="{{ $item->status == 'selesai' ? 'text-decoration-line-through' : '' }}">
                        {{ $item->judul }}
                    </strong>
                    <br>
                    <small class="text-muted">{{ $item->kategori ? $item->kategori->nama : '-' }}</small>
                </div>
            </div>

            <div class="text-end" style="min-width: 170px;">
                <span class="badge rounded-pill px-3 py-2 fw-semibold
                    {{ $item->status == 'selesai' ? 'bg-success' : 'bg-warning text-dark' }}">
                    {{ ucfirst($item->status) }}
                </span>
                <div class="mt-1">
                    <small class="text-muted">
                        Deadline: {{ \Carbon\Carbon::parse($item->deadline)->translatedFormat('d M Y') }}
                    </small>
                </div>
                <div class="mt-3 d-flex justify-content-end gap-2">
                    <a href="{{ route('tugas.edit', $item->id) }}"
                       class="btn btn-outline-warning btn-sm rounded-3 d-flex align-items-center px-3">
                       <i class="bi bi-pencil-fill me-1"></i> Edit
                    </a>
                    <form action="{{ route('tugas.destroy', $item->id) }}" method="POST" class="d-inline"
                          onsubmit="return confirm('Yakin ingin menghapus tugas ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger btn-sm rounded-3 d-flex align-items-center px-3">
                            <i class="bi bi-trash-fill me-1"></i> Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="text-center text-muted fst-italic mt-5">Belum ada tugas.</div>
        @endforelse
    </div>
</div>
@endsection

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet" />
<style>
    body {
        background-color: #f9fbff;
        font-family: 'Poppins', sans-serif;
    }

    .list-group-item {
        border: none;
        padding: 1rem 1.5rem;
        cursor: default;
    }

    .list-group-item:hover {
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
        transform: translateY(-3px);
        background-color: #ffffff !important;
    }

    .form-check-input {
        margin: 0;
        cursor: pointer;
        accent-color: #0d6efd;
        transition: transform 0.2s ease;
    }

    .form-check-input:hover {
        transform: scale(1.15);
    }

    .btn-sm {
        font-size: 0.85rem;
        font-weight: 600;
    }
</style>
@endpush

@push('scripts')
<script>
    document.querySelectorAll('.form-check-input').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const tugasId = this.dataset.id;
            const isChecked = this.checked;
            // Contoh AJAX update status tugas (ganti dengan fetch/axios sesuai project)
            fetch(`/tugas/${tugasId}/toggle-status`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ status: isChecked ? 'selesai' : 'belum' })
            }).then(res => {
                if (!res.ok) throw new Error('Failed to update status');
                // Optionally update UI or reload data
                location.reload();
            }).catch(err => alert('Gagal mengubah status tugas.'));
        });
    });
</script>
@endpush
