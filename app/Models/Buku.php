<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
     protected $table = 'buku'; // opsional, default-nya pakai 'bukus', jadi ini memperjelas

    protected $fillable = [
        'kode_buku',
        'judul',
        'penulis',
        'penerbit',
        'tahun_terbit',
        'kategori',
        'jumlah',
        'gambar',
    ];
}
