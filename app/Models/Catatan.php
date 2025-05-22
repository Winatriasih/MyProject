<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Catatan extends Model
{
    use HasFactory;

    protected $table = 'catatan'; // Nama tabel disesuaikan tanpa "s"

    protected $primaryKey = 'judul'; // Gunakan 'judul' sebagai primary key
    public $incrementing = false;    // Matikan auto-increment
    protected $keyType = 'string';   // Tipe primary key adalah string

    protected $fillable = [
        'judul',
        'isi',
    ];
}
