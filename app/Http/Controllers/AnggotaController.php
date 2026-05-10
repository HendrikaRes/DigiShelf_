<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use PDF; // Pastikan package barryvdh/laravel-dompdf sudah terinstal

class AnggotaController extends Controller
{
    /**
     * Menampilkan daftar anggota.
     */
    public function index()
    {
        $users = User::all();
        return view('admin.anggota', compact('users'));
    }

    /**
     * Menyimpan anggota baru yang dibuat dari modal.
     */
  public function store(Request $request)
{
    // 1. Gunakan Validator untuk validasi
    $validator = Validator::make($request->all(), [
        'nama_lengkap' => 'required|string|max:255',
        'name' => 'required|string|max:255',
        'nis' => 'required|string|max:20|unique:users',
        'email' => 'required|string|email|max:255|unique:users',
        'alamat' => 'required|string|max:255',
        'password' => 'required|string|min:6',
        'role' => 'required|in:user,admin',
    ]);

    // 2. Cek validasi menggunakan $validator->fails()
    if ($validator->fails()) {
        return redirect()->back()
            ->withErrors($validator)
            ->withInput()
            ->with('create_modal_active', true);
    }

    // 3. Simpan data ke database
    User::create([
        'name' => $request->name,
        'nama_lengkap' => $request->nama_lengkap,
        'nis' => $request->nis,
        'email' => $request->email,
        'alamat' => $request->alamat,
        'password' => Hash::make($request->password),
        'role' => $request->role,
    ]);

    return redirect()->route('anggota.index')->with('success', 'Anggota berhasil ditambahkan.');
}

    /**
     * Memperbarui data anggota yang diedit dari modal.
     */
   public function update(Request $request, User $user)
{
    // 1️⃣ Validasi data
    $validator = Validator::make($request->all(), [
        'nama_lengkap' => 'required|string|max:255',
        'name' => 'required|string|max:255',
        'nis' => 'required|string|max:20|unique:users,nis,' . $user->id,
        'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        'alamat' => 'required|string|max:255',
        'role' => 'required|in:user,admin',
        'password' => 'nullable|string|min:6',
    ]);

    if ($validator->fails()) {
        return redirect()->back()
            ->withErrors($validator)
            ->withInput()
            ->with('edit_modal_active', true)
            ->with('edit_user_id', $user->id);
    }

    // 2️⃣ Siapkan data yang akan diupdate
    $data = [
        'name' => $request->name, // untuk kolom name
        'nama_lengkap' => $request->nama_lengkap,
        'nis' => $request->nis,
        'email' => $request->email,
        'alamat' => $request->alamat,
        'role' => $request->role,
    ];

    // 3️⃣ Update password hanya jika diisi
    if ($request->filled('password')) {
        $data['password'] = Hash::make($request->password);
    }

    // 4️⃣ Jalankan update
    $user->update($data);

    return redirect()->route('anggota.index')->with('success', 'Anggota berhasil diupdate.');
}


    /**
     * Menghapus anggota.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('anggota.index')->with('success', 'Anggota berhasil dihapus.');
    }


    public function cetak($id)
    {
        // Ambil data user
        $user = User::findOrFail($id);

        // Pastikan foto profilnya pakai path public/storage jika ada
        $foto = $user->foto_profil 
            ? public_path('storage/' . $user->foto_profil)
            : public_path('images/default-user.png'); // default gambar

        // Generate PDF dari view
        $pdf = PDF::loadView('admin.kartu', compact('user', 'foto'))
                  ->setPaper([0, 0, 283.46, 170.08]); // ukuran kartu 9x5.4 cm

        // Tampilkan di browser
        return $pdf->stream('Kartu_Anggota_' . $user->nama_lengkap . '.pdf');
    }

    // method resource yang tidak dipakai
    public function create() {}
    public function edit(User $user) {}

   
}