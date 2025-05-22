<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tugas;

class DashboardController extends Controller
{
    public function index()
    {
        $totalTugas = Tugas::count();
        $tugasSelesai = Tugas::where('status', 'selesai')->count();
        $tugasBelum = Tugas::where('status', 'belum')->count();

        // Tugas terbaru sebagai 'notifikasi'
        $tugasBaru = Tugas::latest()->take(5)->get();
        $jumlahNotif = $tugasBaru->count(); // bisa disesuaikan sesuai logika "notifikasi"

        return view('dashboard.index', compact(
            'totalTugas',
            'tugasSelesai',
            'tugasBelum',
            'tugasBaru',
            'jumlahNotif'
        ));
    }
}
