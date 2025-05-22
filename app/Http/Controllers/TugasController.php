<?php

namespace App\Http\Controllers;

use App\Models\Tugas;
use App\Models\Kategori;
use Illuminate\Http\Request;

class TugasController extends Controller
{
    /**
     * Menampilkan semua data tugas dengan fitur pencarian.
     */
    public function index(Request $request)
    {
        $query = Tugas::with('kategori'); // eager load kategori

        if ($request->has('search') && $request->search != '') {
            $query->where('judul', 'like', '%' . $request->search . '%');
        }

        $tugas = $query->latest()->get();

        return view('tugas.index', compact('tugas'));
    }

    /**
     * Menampilkan form untuk membuat tugas baru.
     */
    public function create()
    {
        $kategori = Kategori::all(); // ambil semua kategori
        return view('tugas.create', compact('kategori'));
    }

    /**
     * Menyimpan data tugas baru ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategori,id',
            'status' => 'required|in:belum,selesai',
            'deadline' => 'nullable|date',
        ]);

        Tugas::create($validated);

        return redirect()->route('tugas.index')->with('success', 'Tugas berhasil ditambahkan');
    }

    /**
     * Menampilkan detail tugas tertentu (opsional).
     */
    public function show(Tugas $tugas)
    {
        return view('tugas.show', compact('tugas'));
    }

    /**
     * Menampilkan form edit untuk tugas tertentu.
     */
    public function edit(Tugas $tugas)
    {
        $kategori = Kategori::all(); // untuk dropdown
        return view('tugas.edit', compact('tugas', 'kategori'));
    }

    /**
     * Memperbarui data tugas tertentu.
     */
    public function update(Request $request, Tugas $tugas)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategori,id',
            'status' => 'required|in:belum,selesai',
            'deadline' => 'nullable|date',
        ]);

        $tugas->update($validated);

        return redirect()->route('tugas.index')->with('success', 'Tugas berhasil diperbarui');
    }

    /**
     * Menghapus tugas dari database.
     */
    public function destroy(Tugas $tugas)
    {
        $tugas->delete();
        return redirect()->route('tugas.index')->with('success', 'Tugas berhasil dihapus');
    }

    /**
     * Menampilkan tugas berdasarkan kategori.
     */
    public function byKategori($id)
    {
        $tugas = Tugas::where('kategori_id', $id)->with('kategori')->get();
        return view('tugas.index', compact('tugas'));
    }
}
