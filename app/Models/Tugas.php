<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tugas extends Model
{
    use HasFactory;

    protected $table = 'tugas';

    // Kolom yang boleh diisi (pastikan kategori_id dimasukkan, bukan deskripsi)
    protected $fillable = ['judul', 'kategori_id', 'status', 'deadline'];

    // Relasi ke model Kategori
    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }
}
