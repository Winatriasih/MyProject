@extends('layouts.app')

@section('content')
<div class="container py-5" style="max-width: 800px;">
    <h2 class="text-center text-primary fw-bold mb-4">Tambah Tugas Baru</h2>

    @if($errors->any())
        <div class="alert alert-danger shadow-sm rounded-3">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow-sm rounded-4 border-0">
        <div class="card-body">
            <form action="{{ route('tugas.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label fw-semibold">Judul</label>
                    <input type="text" name="judul" class="form-control rounded-3" required placeholder="Masukkan judul tugas...">
                </div>

                <div class="mb-3">
                    <label for="kategori_id" class="form-label fw-semibold">Kategori</label>
                    <select name="kategori_id" class="form-select rounded-3" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($kategori as $kat)
                            <option value="{{ $kat->id }}">{{ $kat->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Status</label>
                    <select name="status" class="form-select rounded-3">
                        <option value="belum">Belum</option>
                        <option value="selesai">Selesai</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold">Deadline</label>
                    <input type="date" name="deadline" class="form-control rounded-3">
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('tugas.index') }}" class="btn btn-outline-secondary rounded-3 px-4">
                        Kembali
                    </a>
                    <button type="submit" class="btn btn-primary rounded-3 px-4 shadow-sm">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<!-- Poppins font + tambahan gaya -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
    body {
        background-color: #f4f8fc;
        font-family: 'Poppins', sans-serif;
        color: #2e2e2e;
    }

    label {
        font-weight: 500;
    }

    .form-control, .form-select {
        font-size: 0.95rem;
        padding: 0.6rem 0.75rem;
    }

    .btn {
        font-size: 0.9rem;
        letter-spacing: 0.5px;
    }

    .btn:hover {
        box-shadow: 0 6px 12px rgba(0,0,0,0.1);
    }
</style>
@endpush
