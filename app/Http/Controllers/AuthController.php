<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

   public function register(Request $request)
{
    try {
        $request->validate([
            'name' => 'required|string|max:255',
            'nama_lengkap' => 'required|string|max:255',
            'nis' => 'required|string|max:20|unique:users,nis',
            'alamat' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'foto_profil' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // 🖼️ Upload foto jika ada
        $fotoProfilPath = null;
        if ($request->hasFile('foto_profil')) {
            $file = $request->file('foto_profil');

            if ($file->isValid()) {
                // Simpan ke storage/app/public/foto_profil
                $fotoProfilPath = $file->store('foto_profil', 'public');
            } else {
                return back()->with('error', 'File foto tidak valid.');
            }
        }

        // 🧩 Simpan user ke database
        $user = User::create([
            'name' => $request->name,
            'nama_lengkap' => $request->nama_lengkap,
            'nis' => $request->nis,
            'alamat' => $request->alamat,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'foto_profil' => $fotoProfilPath,
        ]);

        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login.');

    } catch (\Exception $e) {
        return redirect()->back()
            ->withInput()
            ->with('error', 'Registrasi gagal! '.$e->getMessage());
    }
}


   public function login(Request $request)
{
    // Validasi input form login
    $credentials = $request->validate([
        'nis' => 'required|string|max:50',
        'password' => 'required|string',
    ]);

    // Coba autentikasi berdasarkan NIS dan password
    if (Auth::attempt(['nis' => $credentials['nis'], 'password' => $credentials['password']])) {
        $request->session()->regenerate();

       // Cek role setelah login
$user = Auth::user();

if ($user->role === 'admin') {
    return redirect()->route('admin.dashboard')->with('success', 'Login berhasil sebagai admin!');
} else {
    return redirect()->route('user.dashboard')->with('success', 'Login berhasil!');
}
    }

    // Jika gagal login
    return back()->withErrors([
        'nis' => 'NIS atau password salah.',
    ])->onlyInput('nis');
}
    public function logout(Request $request)
{
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    
    return redirect()->route('login');
}

}
