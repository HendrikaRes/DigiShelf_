<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Pengembalian;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BukuUserController;
use App\Http\Controllers\BukuAdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PengembalianController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;


Route::get('/', function () {
    return view('auth.login');
});

// Route Auth yang sudah ada
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/anggota', [AnggotaController::class, 'index'])->name('anggota.index')->middleware('auth');
// Rute untuk menampilkan form tambah anggota
Route::get('/anggota/create', [AnggotaController::class, 'create'])->name('anggota.create');

// Rute untuk menyimpan data anggota baru
Route::post('/anggota', [AnggotaController::class, 'store'])->name('anggota.store');

// Rute untuk menampilkan form edit
Route::get('/anggota/{user}/edit', [AnggotaController::class, 'edit'])->name('anggota.edit');

// Rute untuk menyimpan perubahan data anggota
Route::put('/anggota/{user}', [AnggotaController::class, 'update'])->name('anggota.update');

Route::delete('/anggota/{user}', [AnggotaController::class, 'destroy'])->name('anggota.destroy');

Route::get('/anggota/{id}/cetak', [App\Http\Controllers\AnggotaController::class, 'cetak'])->name('anggota.cetak');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile/delete', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Routes untuk Admin
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Manajemen buku
        Route::get('/buku', [BukuAdminController::class, 'index'])->name('buku.index');
        Route::post('/buku', [BukuAdminController::class, 'store'])->name('buku.store');
        Route::put('/buku/{id}', [BukuAdminController::class, 'update'])->name('buku.update');
        Route::delete('/buku/{id}', [BukuAdminController::class, 'destroy'])->name('buku.destroy');

        // 🔥 Admin melihat semua peminjaman
        Route::get('/peminjaman', [PeminjamanController::class, 'index'])
            ->name('peminjaman.index');

        // 🔥 Admin memproses pengembalian
        Route::post('/peminjaman/kembalikan/{id}', [PeminjamanController::class, 'kembalikan'])
            ->name('peminjaman.kembalikan');

          Route::get('/pengembalian', [PengembalianController::class, 'index'])
            ->name('pengembalian.index');

              Route::post('/pengembalian/proses/{id}', [PengembalianController::class, 'proses'])->name('pengembalian.proses');
        
    });


// Routes untuk User
Route::middleware(['auth', 'user'])
    ->prefix('user')
    ->name('user.')
    ->group(function () {

        // Daftar buku user
        Route::get('/buku', [BukuUserController::class, 'index'])->name('buku.index');
        Route::get('/buku/{id}', [BukuUserController::class, 'show'])->name('buku.show');

        // User meminjam buku
        Route::post('/peminjaman/store', [PeminjamanController::class, 'store'])
            ->name('peminjaman.store');

        // Daftar peminjaman user
        Route::get('/peminjaman', [PeminjamanController::class, 'userIndex'])
            ->name('peminjaman.index');

        // Detail satu peminjaman
        Route::get('/peminjaman/{id}', [PeminjamanController::class, 'userShow'])
            ->name('peminjaman.show');

        // 🔥 Halaman pengembalian (informasi saja)
        Route::get('/pengembalian', [Pengembalian::class, 'index'])
            ->name('pengembalian.index');
    });






Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard')->middleware(['auth', 'admin']);
Route::get('/user/dashboard', [DashboardController::class, 'index'])->name('user.dashboard')->middleware(['auth', 'user']);

Route::get('/laporan', [DashboardController::class, 'laporan'])->name('laporan.index');
Route::get('/laporan/export', [DashboardController::class, 'exportExcel'])->name('laporan.export');





