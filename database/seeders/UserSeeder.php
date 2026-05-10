<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Jalankan seeder.
     */
    public function run(): void
    {
        // Admin / User contoh 1
        User::create([
            'name' => 'admin',
            'nama_lengkap' => 'Administrator Sistem',
            'nis' => 'admin',
            'alamat' => 'Jl. Merdeka No. 1',
            'role' => 'admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin123'), // password default
        ]);

        // User contoh 2
        User::create([
            'name' => 'usertest',
            'nama_lengkap' => 'User Test',
            'nis' => '111',
            'alamat' => 'Kudus, Jawa Tengah',
            'role' => 'user',
            'email' => 'user@gmail.com',
            'password' => Hash::make('user123'),
        ]);

        User::create([
            'name' => 'developer',
            'nama_lengkap' => 'Developer Sistem',
            'nis' => '123',
            'alamat' => 'Kudus, Jawa Tengah',
            'role' => 'user',
            'email' => 'dev@gmail.com',
            'password' => Hash::make('dev123'),
        ]);
    }
}
