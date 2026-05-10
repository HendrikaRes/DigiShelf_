<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Buku;

class BukuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         Buku::insert([
            [
                'kode_buku' => 'BK001',
                'judul' => 'Laravel Untuk Pemula',
                'penulis' => 'Andi Prasetyo',
                'penerbit' => 'Informatika',
                'tahun_terbit' => '2021',
                'kategori' => 'Pemrograman',
                'jumlah' => 10,
                'gambar' => 'default.jpg',
            ],
            [
                'kode_buku' => 'BK002',
                'judul' => 'Mahir PHP 8',
                'penulis' => 'Budi Santoso',
                'penerbit' => 'Gramedia',
                'tahun_terbit' => '2022',
                'kategori' => 'Pemrograman',
                'jumlah' => 7,
                'gambar' => 'default.jpg',
            ],
            [
                'kode_buku' => 'BK003',
                'judul' => 'Mastering MySQL',
                'penulis' => 'Citra Lestari',
                'penerbit' => 'Elex Media',
                'tahun_terbit' => '2020',
                'kategori' => 'Pemrograman',
                'jumlah' => 5,
                'gambar' => 'default.jpg',
            ],
        ]);
    }
}
