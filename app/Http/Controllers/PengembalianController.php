<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Pengembalian;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PengembalianController extends Controller
{
    public function index()
    {
        $data = Peminjaman::where('status', 'dipinjam')->get();
        return view('admin.pengembalian', compact('data'));
    }

      public function proses($id)
{
    $peminjaman = Peminjaman::findOrFail($id);

    $today = Carbon::today();

    // Hitung denda
    $tglKembali = Carbon::parse($peminjaman->tgl_kembali);
    $lateDays = max(0, $tglKembali->diffInDays($today));
    $denda = $lateDays * 1000;

    // Simpan ke tabel pengembalian
    Pengembalian::create([
        'peminjaman_id'   => $peminjaman->id,
        'tgl_dikembalikan' => $today,
        'denda'            => $denda
    ]);

    // Update tabel peminjaman
    $peminjaman->update([
        'tgl_dikembalikan' => $today,
        'status'           => 'dikembalikan'
    ]);

    // 🟢 Tambahkan jumlah buku kembali
    $buku = $peminjaman->buku;
    $buku->increment('jumlah', 1);

    return redirect()->back()->with('success', 'Buku berhasil dikembalikan!');
}

}
