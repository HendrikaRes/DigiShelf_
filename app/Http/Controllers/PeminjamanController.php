<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    /**
     * ADMIN – Menampilkan semua data peminjaman
     */
    public function index()
    {
        $peminjaman = Peminjaman::with(['user', 'buku'])
            ->orderBy('status', 'asc')
            ->orderBy('tgl_pinjam', 'desc')
            ->get();

        return view('admin.peminjaman', compact('peminjaman'));
    }
    public function userIndex()
{
    $sedangDipinjam = Peminjaman::with('buku')
        ->where('user_id', auth()->id())
        ->where('status', 'dipinjam')
        ->get();

    $riwayat = Peminjaman::with('buku')
        ->where('user_id', auth()->id())
        ->where('status', 'dikembalikan')
        ->orderBy('tgl_pinjam', 'desc')
        ->get();

    return view('user.peminjaman', compact('sedangDipinjam', 'riwayat'));
}



public function userShow($id)
{
    $detail = Peminjaman::with('buku')
        ->where('id', $id)
        ->where('user_id', auth()->id())
        ->firstOrFail();

    return view('user.peminjaman', compact('detail'));
}


    /**
     * USER – Meminjam buku
     */
    public function store(Request $request)
    {
        $request->validate([
            'buku_id' => 'required|exists:buku,id',
            'tgl_pinjam' => 'required|date',
            'tgl_kembali' => 'required|date|after_or_equal:tgl_pinjam',
        ]);

        $buku = Buku::findOrFail($request->buku_id);

        // Cek stok buku
        if ($buku->jumlah < 1) {
            return back()->with('error', 'Stok buku habis!');
        }

        // Kurangi stok
        $buku->decrement('jumlah');

        // Simpan peminjaman
        Peminjaman::create([
            'user_id' => auth()->id(),
            'buku_id' => $buku->id,
            'tgl_pinjam' => $request->tgl_pinjam,
            'tgl_kembali' => $request->tgl_kembali,
            'status' => 'dipinjam',
        ]);

        return back()->with('success', 'Peminjaman berhasil dilakukan!');
    }

    /**
     * ADMIN – Mengembalikan buku
     */
    public function kembalikan($id)
    {
        $pinjam = Peminjaman::findOrFail($id);

        if ($pinjam->status === 'dikembalikan') {
            return back()->with('info', 'Buku ini sudah dikembalikan.');
        }

        // Update status
        $pinjam->update([
            'status' => 'dikembalikan',
            'tgl_dikembalikan' => now(),
        ]);

        // Tambah stok buku
        $pinjam->buku->increment('jumlah');

        return back()->with('success', 'Buku berhasil dikembalikan.');
    }
}
