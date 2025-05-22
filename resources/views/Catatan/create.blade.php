@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4"> Tambah Catatan Baru</h2>

    {{-- Tampilkan error validasi --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('catatan.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="judul" class="form-label">Judul</label>
            <input type="text" id="judul" name="judul" class="form-control" value="{{ old('judul') }}" required>
        </div>

        <div class="mb-3">
            <label for="isi" class="form-label">Isi</label>
            <textarea id="isi" name="isi" rows="5" class="form-control" required>{{ old('isi') }}</textarea>
        </div>

        <div class="d-flex justify-content-start align-items-center">
            <button type="submit" class="btn btn-primary me-2">💾 Simpan</button>
            <a href="{{ route('catatan.index') }}" class="btn btn-outline-secondary">↩️ Batal</a>
        </div>
    </form>
</div>
@endsection
