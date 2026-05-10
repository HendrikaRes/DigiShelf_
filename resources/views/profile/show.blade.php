@extends('layouts.master')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-body text-center p-4">

                    <h3 class="mb-4 fw-bold">Edit Profil</h3>

                    {{-- Foto Profil Preview --}}
                    <div class="mb-4">
                        <div class="position-relative d-inline-block">
                            <img src="{{ $user->foto_profil ? asset('storage/' . $user->foto_profil) : asset('img/default-user.png') }}"
                                 alt="Foto Profil"
                                 class="rounded-circle border border-3 border-primary"
                                 style="width: 120px; height: 120px; object-fit: cover;">
                        </div>
                    </div>

                    {{-- Form --}}
                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="text-start">
                        @csrf
                        {{-- Jika pakai PUT --}}
                        {{-- @method('PUT') --}}

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" class="form-control" value="{{ $user->nama_lengkap }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Username</label>
                            <input type="text" name="name" class="form-control" value="{{ $user->name }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">NIS</label>
                            <input type="text" name="nis" class="form-control" value="{{ $user->nis }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Alamat</label>
                            <input type="text" name="alamat" class="form-control" value="{{ $user->alamat }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ $user->email }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Password (Opsional)</label>
                            <input type="password" name="password" class="form-control" placeholder="Kosongkan jika tidak ingin ubah">
                            <input type="password" name="password_confirmation" class="form-control mt-2" placeholder="Konfirmasi password">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Ganti Foto Profil</label>
                            <input type="file" name="foto_profil" class="form-control">
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('profile.show') }}" class="btn btn-secondary w-25">Batal</a>
                            <button type="submit" class="btn btn-primary w-50">Simpan Perubahan</button>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
