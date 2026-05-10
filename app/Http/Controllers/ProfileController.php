<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;


class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        return view('profile.show', compact('user'));
    }

    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

   public function update(Request $request)
{
    $user = Auth::user();

    // Validasi input
    $request->validate([
        'nama_lengkap' => 'required|string|max:255',
        'name' => 'required|string|max:255',
        'nis' => 'required|string|max:20|unique:users,nis,' . $user->id,
        'alamat' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        'password' => 'nullable|string|min:6|confirmed',
        'foto_profil' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    // Simpan perubahan data umum
    $user->update([
        'nama_lengkap' => $request->nama_lengkap,
        'name' => $request->name,
        'nis' => $request->nis,
        'alamat' => $request->alamat,
        'email' => $request->email,
        'password' => $request->filled('password') ? Hash::make($request->password) : $user->password,
    ]);

    // 🔄 Update foto profil
    if ($request->hasFile('foto_profil')) {

        // Hapus foto lama jika ada
        if ($user->foto_profil && Storage::disk('public')->exists($user->foto_profil)) {
            Storage::disk('public')->delete($user->foto_profil);
        }

        // Simpan foto baru
        $path = $request->file('foto_profil')->store('foto_profil', 'public');

        // Update kolom di database
        $user->update(['foto_profil' => $path]);
    }

    return redirect()->route('profile.show')->with('success', 'Profil berhasil diperbarui!');
}


    public function destroy()
    {
        $user = Auth::user();
        $user->delete();

        Auth::logout();

        return redirect('/')->with('success', 'Akun berhasil dihapus.');
    }
}
