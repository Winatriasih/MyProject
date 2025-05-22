<?php

namespace App\Http\Controllers;

use App\Models\Catatan;
use Illuminate\Http\Request;

class CatatanController extends Controller
{
    // Menampilkan semua catatan
    public function index()
    {
        $catatans = Catatan::latest()->get();
        return view('catatan.index', compact('catatans'));
    }

    // Menampilkan form tambah catatan
    public function create()
    {
        return view('catatan.create');
    }

    // Menyimpan catatan baru
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|max:255|unique:catatan,judul',
            'isi' => 'required',
        ]);

        Catatan::create($request->only('judul', 'isi'));

        return redirect()->route('catatan.index')
                         ->with('success', 'Catatan berhasil ditambahkan.');
    }

    // Menampilkan form edit catatan berdasarkan judul
    public function edit($judul)
    {
        $catatan = Catatan::where('judul', $judul)->firstOrFail();
        return view('catatan.edit', compact('catatan'));
    }

    // Memperbarui catatan berdasarkan judul
    public function update(Request $request, $judul)
    {
        $request->validate([
            'isi' => 'required',
        ]);

        $catatan = Catatan::where('judul', $judul)->firstOrFail();
        $catatan->update(['isi' => $request->isi]);

        return redirect()->route('catatan.index')
                         ->with('success', 'Catatan berhasil diperbarui.');
    }

    // Menghapus catatan berdasarkan judul
    public function destroy($judul)
    {
        $catatan = Catatan::where('judul', $judul)->firstOrFail();
        $catatan->delete();

        return redirect()->route('catatan.index')
                         ->with('success', 'Catatan berhasil dihapus.');
    }
}
