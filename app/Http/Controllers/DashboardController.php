<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Peminjaman;
use App\Models\Buku;
use App\Exports\LaporanExport; // <--- Import ini
use Maatwebsite\Excel\Facades\Excel; // <--- Import ini

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // ---- Dashboard untuk ADMIN ----
        if ($user->role === 'admin') {
            $totalUser = User::count();
            $totalBuku = Buku::count();
            $totalPeminjaman = Peminjaman::count();
            $totalDipinjam = Peminjaman::where('status', 'dipinjam')->count();

            // TAMBAHAN: Ambil 5 data peminjaman terakhir untuk ditampilkan di dashboard
            // Pastikan model Peminjaman punya relasi 'user' dan 'buku'
            $peminjamanTerbaru = Peminjaman::with(['user', 'buku'])
                                    ->latest()
                                    ->take(5)
                                    ->get();

            return view('admin.dashboard', compact(
                'totalUser',
                'totalBuku',
                'totalPeminjaman',
                'totalDipinjam',
                'peminjamanTerbaru' // Kirim variabel ini ke view
            ));
        }

        // ---- Dashboard untuk USER ----
        if ($user->role === 'user') {
            $riwayatPinjam = Peminjaman::where('user_id', $user->id)->latest()->get();
            $jumlahPinjamanAktif = Peminjaman::where('user_id', $user->id)->where('status', 'dipinjam')->count();

            return view('user.dashboard', compact(
                'riwayatPinjam',
                'jumlahPinjamanAktif'
            ));
        }

        abort(403, 'Unauthorized access');
    }

    public function laporan(Request $request)
    {
        // 1. Tambahkan 'pengembalian' ke dalam with() agar datanya ikut terambil
        $query = Peminjaman::with(['user', 'buku', 'pengembalian']);

        // Filter Tanggal Awal
        if ($request->filled('tgl_awal')) {
            $query->whereDate('tgl_pinjam', '>=', $request->tgl_awal);
        }

        // Filter Tanggal Akhir
        if ($request->filled('tgl_akhir')) {
            $query->whereDate('tgl_pinjam', '<=', $request->tgl_akhir);
        }

        // Filter Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Ambil data
        $laporan = $query->orderBy('created_at', 'desc')->get();

        // Pastikan nama view sesuai dengan struktur folder Anda

        return view('laporan', compact('laporan'));
    }

    public function exportExcel(Request $request)
    {
        // Nama file dengan timestamp agar unik
        $namaFile = 'laporan_perpustakaan_' . date('Y-m-d_H-i-s') . '.xlsx';
        
        // Download Excel dengan mengirimkan $request (filter) ke class Export
        return Excel::download(new LaporanExport($request), $namaFile);
    }
}