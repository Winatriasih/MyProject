@extends('layouts.app')

@section('content')
<div class="container py-5" style="max-width: 960px;">
    <div class="text-center mb-5">
        <h2 class="fw-bold text-primary" style="font-size: 2.5rem; letter-spacing: 0.03em;">Daftar Kategori Tugas</h2>
        <p class="text-muted fs-5">Kelola dan sesuaikan kategori untuk mengatur produktivitas Anda.</p>
    </div>

    {{-- Flash Message --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow rounded-3 d-flex align-items-center gap-2" role="alert">
            <i class="bi bi-check-circle-fill fs-4"></i>
            <div class="flex-grow-1">{{ session('success') }}</div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
        </div>
    @endif

    {{-- Tombol Tambah --}}
    <div class="d-flex justify-content-end mb-4">
        <a href="{{ route('kategori.create') }}"
           class="btn btn-primary rounded-pill shadow-sm d-flex align-items-center gap-2 px-4 py-2 fs-5 fw-semibold">
            <i class="bi bi-plus-circle-fill fs-4"></i> Tambah Kategori
        </a>
    </div>

    {{-- List Kategori --}}
    @forelse ($kategoris as $kategori)
    <div class="kategori-card p-4 mb-4 shadow rounded-4 position-relative animate-fade d-flex justify-content-between align-items-center">
        <div>
            <h5 class="fw-semibold text-dark mb-2 d-flex align-items-center gap-2" style="font-size: 1.35rem;">
                <i class="bi bi-folder2-open-fill text-primary fs-3"></i> {{ $kategori->nama }}
            </h5>
            <p class="mb-0 text-secondary fst-italic" style="font-size: 1rem;">
                {{ $kategori->deskripsi ?: 'Tidak ada deskripsi.' }}
            </p>
        </div>
        <div class="d-flex gap-3 align-items-center">
            <a href="{{ route('kategori.edit', $kategori->id) }}"
               class="btn btn-outline-warning btn-lg rounded-circle d-flex justify-content-center align-items-center action-btn"
               title="Edit">
                <i class="bi bi-pencil-fill fs-5"></i>
            </a>
            <form action="{{ route('kategori.destroy', $kategori->id) }}" method="POST"
                  onsubmit="return confirm('Hapus kategori ini?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-outline-danger btn-lg rounded-circle d-flex justify-content-center align-items-center action-btn"
                        title="Hapus">
                    <i class="bi bi-trash-fill fs-5"></i>
                </button>
            </form>
        </div>
    </div>
    @empty
    <div class="alert alert-info shadow rounded-3 d-flex align-items-center gap-2 fs-5 justify-content-center" style="height: 150px;">
        <i class="bi bi-info-circle-fill fs-3"></i> Belum ada kategori yang tersedia.
    </div>
    @endforelse
</div>
@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<style>
    body {
        background-color: #f9fafb;
        font-family: 'Poppins', sans-serif;
    }

    .kategori-card {
        background: #ffffff;
        border-radius: 1.25rem;
        box-shadow: 0 8px 20px rgb(0 0 0 / 0.08);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        cursor: default;
        user-select: none;
    }

    .kategori-card:hover {
        box-shadow: 0 15px 35px rgb(0 0 0 / 0.12);
        transform: translateY(-6px) scale(1.02);
    }

    .action-btn {
        width: 52px;
        height: 52px;
        transition: background-color 0.3s ease, color 0.3s ease, transform 0.25s ease;
        border-width: 2px;
    }

    .action-btn:hover {
        transform: scale(1.15);
        color: #fff !important;
    }

    .btn-outline-warning:hover {
        background-color: #ffc107 !important;
        border-color: #ffc107 !important;
    }

    .btn-outline-danger:hover {
        background-color: #dc3545 !important;
        border-color: #dc3545 !important;
    }

    .animate-fade {
        animation: fadeInUp 0.6s ease both;
    }

    @keyframes fadeInUp {
        0% {
            opacity: 0;
            transform: translateY(24px);
        }
        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }

    h5 {
        letter-spacing: 0.02em;
    }

    .alert-info {
        font-style: italic;
        color: #3b82f6;
        background-color: #dbeafe;
    }

    /* Responsive tweaks */
    @media (max-width: 576px) {
        .kategori-card {
            flex-direction: column;
            gap: 1.25rem;
        }

        .d-flex.gap-3.align-items-center {
            justify-content: flex-start;
            gap: 1rem;
        }

        .action-btn {
            width: 48px;
            height: 48px;
        }
    }
</style>
@endpush
