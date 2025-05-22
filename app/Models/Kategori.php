<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'kategori'; // sesuai migrasi kamu

    protected $fillable = ['nama', 'deskripsi']; // tambahkan 'deskripsi' supaya bisa diisi mass assignment

    public function tugas()
    {
        return $this->hasMany(Tugas::class);
    }
}
