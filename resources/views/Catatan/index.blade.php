@extends('layouts.app')

@section('content')
<div class="container py-5" style="max-width: 900px;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-primary mb-0" style="letter-spacing: 0.03em;">Catatan</h2>
        <a href="{{ route('catatan.create') }}"
           class="btn btn-lg btn-primary rounded-pill d-flex align-items-center gap-2 px-4">
            <i class="bi bi-plus-circle-fill fs-5"></i> Tambah Catatan
        </a>
    </div>

    {{-- Pesan sukses --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm rounded-3 d-flex align-items-center gap-2" role="alert">
            <i class="bi bi-check-circle-fill fs-4"></i>
            <div class="flex-grow-1">{{ session('success') }}</div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
        </div>
    @endif

    {{-- Tabel catatan --}}
    <div class="table-responsive shadow-sm rounded-3">
        <table class="table table-striped table-hover align-middle mb-0">
            <thead class="table-primary text-primary">
                <tr>
                    <th style="width: 60px;">No</th>
                    <th>Judul</th>
                    <th>Isi</th>
                    <th style="width: 150px;" class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($catatans as $index => $catatan)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td class="fw-semibold">{{ $catatan->judul }}</td>
                        <td>{{ Str::limit($catatan->isi, 70, '...') }}</td>
                        <td class="text-center">
                            <a href="{{ route('catatan.edit', $catatan->judul) }}"
                               class="btn btn-sm btn-warning rounded-pill px-3 me-1"
                               title="Edit">
                                <i class="bi bi-pencil-fill"></i> Edit
                            </a>
                            <form action="{{ route('catatan.destroy', $catatan->judul) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Yakin ingin menghapus catatan ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="btn btn-sm btn-danger rounded-pill px-3"
                                        title="Hapus">
                                    <i class="bi bi-trash-fill"></i> Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted fst-italic py-4">Belum ada catatan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
<style>
    body {
        background-color: #f9fafb;
        font-family: 'Poppins', sans-serif;
    }

    h2 {
        font-weight: 700;
        letter-spacing: 0.03em;
    }

    .table-primary {
        background-color: #cfe2ff;
        color: #084298;
    }

    .table-striped > tbody > tr:nth-of-type(odd) {
        background-color: #f8f9fa;
    }

    .btn-sm {
        font-weight: 600;
        transition: transform 0.2s ease;
    }

    .btn-sm:hover {
        transform: scale(1.05);
    }

    .alert {
        font-size: 1rem;
    }

    .table-responsive {
        background-color: white;
        border-radius: 0.5rem;
    }
</style>
@endpush
