<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;

class BukuAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $buku = Buku::all();

         $kodeBuku = $this->generateKodeBuku();
     return view('admin.bukuadmin', compact('buku', 'kodeBuku'));
    
    }
    


    /**
     * Show the form for creating a new resource.
     */

   
   public function store(Request $request)
{
    $request->validate([
        'kode_buku' => 'required|unique:buku,kode_buku',
        'judul' => 'required|string|max:255',
        'penulis' => 'required|string|max:255',
        'penerbit' => 'required|string|max:255',
        'tahun_terbit' => 'required|digits:4|integer',
        'jumlah' => 'required|integer|min:1',
        'kategori' => 'nullable|string|max:255',
        'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    $data = $request->only([
        'kode_buku', 'judul', 'penulis', 'penerbit', 'tahun_terbit', 'jumlah', 'kategori'
    ]);

    // Upload gambar
    if ($request->hasFile('gambar')) {
        $data['gambar'] = $request->file('gambar')->store('gambar_buku', 'public');
    } else {
        $data['gambar'] = 'gambar_buku/default.jpg';
    }

    Buku::create($data);

    return redirect()->route('admin.buku.index')->with('success', 'Buku berhasil ditambahkan.');
}
private function generateKodeBuku()
{
    // Ambil kode terakhir
    $lastBook = \App\Models\Buku::orderBy('id', 'desc')->first();

    if (!$lastBook) {
        return 'BK001';
    }

    // Ambil angka terakhir setelah "BK"
    $lastNumber = (int) substr($lastBook->kode_buku, 2);

    // Increment
    $newNumber = $lastNumber + 1;

    // Format 3 digit: 001, 002, 003
    return 'BK' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
}


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
         $buku = Buku::findOrFail($id);
   return view('admin.buku.edit', compact('buku'));


    }

    /**
     * Update the specified resource in storage.
     */
   public function update(Request $request, string $id)
{
    $buku = Buku::findOrFail($id);

    $request->validate([
        'kode_buku' => 'required|unique:buku,kode_buku,' . $buku->id,
        'judul' => 'required|string|max:255',
        'penulis' => 'required|string|max:255',
        'penerbit' => 'required|string|max:255',
        'tahun_terbit' => 'required|digits:4|integer',
        'jumlah' => 'required|integer|min:1',
        'kategori' => 'nullable|string|max:255',
        'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    $data = $request->only([
        'kode_buku', 'judul', 'penulis', 'penerbit', 'tahun_terbit', 'jumlah', 'kategori'
    ]);

    // Cek jika ada upload gambar baru
    if ($request->hasFile('gambar')) {

        // Hapus gambar lama jika bukan default
        if ($buku->gambar && $buku->gambar !== 'default.jpg') {
            \Storage::disk('public')->delete($buku->gambar);
        }

        // Upload gambar baru
        $data['gambar'] = $request->file('gambar')->store('gambar_buku', 'public');
    } else {
        // Tetap pakai gambar lama
        $data['gambar'] = $buku->gambar;
    }

    $buku->update($data);

    return redirect()->route('admin.buku.index')->with('success', 'Buku berhasil diperbarui.');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
{
    $buku = Buku::findOrFail($id);

    // Hapus gambar dari penyimpanan jika bukan 'default.jpg'
    if ($buku->gambar && $buku->gambar !== 'default.jpg') {
        \Storage::disk('public')->delete($buku->gambar);
    }

    // Hapus data buku dari database
    $buku->delete();

    // Redirect dengan pesan sukses
    return redirect()->route('admin.buku.index')->with('success', 'Buku berhasil dihapus.');

}
}
