<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use Carbon\Carbon;

class Pengembalian extends Controller
{
    public function index()
    {
        // Ambil peminjaman aktif milik user yang belum dikembalikan
        $peminjaman = Peminjaman::with('buku')
            ->where('user_id', auth()->id())
            ->where('status', 'dipinjam')
            ->get();

        // Tambahkan informasi keterlambatan & denda
        $peminjaman = $peminjaman->map(function ($item) {

            $tglKembali = Carbon::parse($item->tgl_kembali);
            $today = Carbon::today();

            // Hitung hari telat (minimum 0, tidak minus)
            $lateDays = max(0, $tglKembali->diffInDays($today, false));

            $item->late_days      = $lateDays;
            $item->is_late        = $lateDays > 0;
            $item->denda          = $lateDays * 1000;
            $item->status_telat   = $item->is_late 
                                    ? "Terlambat {$item->late_days} hari — Denda: Rp " . number_format($item->denda, 0, ',', '.')
                                    : "Belum terlambat";

            return $item;
        });

        // Kumpulan data yang terlambat saja
        $terlambat = $peminjaman->filter(fn($item) => $item->is_late)->values();

        return view('user.pengembalian', compact('peminjaman', 'terlambat'));
    }
}
