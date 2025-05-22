@extends('layouts.app')

@section('content')
<div class="container py-5" style="max-width: 720px;">
    <h2 class="text-center text-primary fw-bold mb-4">Edit Kategori</h2>

    {{-- Tampilkan error validasi --}}
    @if ($errors->any())
        <div class="alert alert-danger shadow-sm rounded-3">
            <strong>Perhatian!</strong> Ada masalah dengan input Anda:
            <ul class="mt-2 mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body">
            <form action="{{ route('kategori.update', $kategori->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="nama" class="form-label fw-semibold">Nama Kategori</label>
                    <input type="text" name="nama" id="nama" class="form-control" value="{{ old('nama', $kategori->nama) }}" required>
                </div>

                <div class="mb-3">
                    <label for="deskripsi" class="form-label fw-semibold">Deskripsi</label>
                    <textarea name="deskripsi" id="deskripsi" class="form-control" rows="4">{{ old('deskripsi', $kategori->deskripsi) }}</textarea>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('kategori.index') }}" class="btn btn-outline-secondary rounded-3">← Kembali</a>
                    <button type="submit" class="btn btn-primary rounded-3">Perbarui</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
