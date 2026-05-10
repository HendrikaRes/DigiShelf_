@extends('layouts.master')

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    
    <style>
        /* CSS Tambahan untuk Memaksa Posisi ke Kanan */
        .dataTables_wrapper .dataTables_filter {
            float: right;
            text-align: right;
        }
        .dataTables_wrapper .dataTables_paginate {
            float: right;
            text-align: right;
        }
        /* Memberi jarak pada search box */
        .dataTables_filter input {
            margin-left: 0.5em;
            display: inline-block;
            width: auto;
        }
    </style>
@endpush

@section('content')
<div class="container-fluid pt-4 px-4">

    {{-- Alert Error Validasi Global --}}
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Gagal!</strong> Periksa inputan Anda.
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    
    {{-- Alert Sukses --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Manajemen Buku</h6>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahBukuModal">
                        <i class="fas fa-plus"></i> Tambah Buku
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Kode</th>
                                    <th>Judul</th>
                                    <th>Penulis</th>
                                    <th>Kategori</th>
                                    <th>Tahun</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($buku as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->kode_buku }}</td>
                                    <td>{{ $item->judul }}</td>
                                    <td>{{ $item->penulis }}</td>
                                    <td>{{ $item->kategori }}</td>
                                    <td>{{ $item->tahun_terbit }}</td>
                                    <td>
                                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editBukuModal-{{ $item->id }}">
                                            Edit
                                        </button>
                                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#hapusBukuModal-{{ $item->id }}">
                                            Hapus
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- AREA MODAL --}}
{{-- Catatan: Modal diletakkan di luar struktur tabel tapi tetap bisa diakses lewat ID --}}

{{-- 1. Modal Tambah Buku --}}
<div class="modal fade" id="tambahBukuModal" tabindex="-1" aria-labelledby="tambahBukuModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahBukuModalLabel">Tambah Buku</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.buku.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Kode Buku</label>
                                <input type="text" class="form-control" name="kode_buku" value="{{ $kodeBuku ?? '' }}" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="judul" class="form-label">Judul</label>
                                <input type="text" class="form-control" id="judul" name="judul" required>
                            </div>
                            <div class="mb-3">
                                <label for="penulis" class="form-label">Penulis</label>
                                <input type="text" class="form-control" id="penulis" name="penulis" required>
                            </div>
                            <div class="mb-3">
                                <label for="penerbit" class="form-label">Penerbit</label>
                                <input type="text" class="form-control" id="penerbit" name="penerbit" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="tahun_terbit" class="form-label">Tahun Terbit</label>
                                <input type="number" class="form-control" id="tahun_terbit" name="tahun_terbit" required>
                            </div>
                            <div class="mb-3">
                                <label for="jumlah" class="form-label">Jumlah</label>
                                <input type="number" class="form-control" id="jumlah" name="jumlah" required>
                            </div>
                            <div class="mb-3">
                                <label for="kategori" class="form-label">Kategori</label>
                                <select class="form-control" id="kategori" name="kategori">
                                    <option value="">-- Pilih Kategori --</option>
                                    <option value="Novel">Novel</option>
                                    <option value="Komik">Komik</option>
                                    <option value="Teknologi">Teknologi</option>
                                    <option value="Pendidikan">Pendidikan</option>
                                    <option value="Agama">Agama</option>
                                    <option value="Sejarah">Sejarah</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="gambar" class="form-label">Gambar</label>
                                <input type="file" class="form-control" id="gambar" name="gambar">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- 2. Loop Modal Edit & Hapus (Harus di luar table tag, tapi di dalam foreach data) --}}
@foreach ($buku as $item)
    <div class="modal fade" id="editBukuModal-{{ $item->id }}" tabindex="-1" aria-labelledby="editBukuModalLabel-{{ $item->id }}" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editBukuModalLabel-{{ $item->id }}">Edit Buku</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.buku.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Kode Buku</label>
                                    <input type="text" class="form-control" name="kode_buku" value="{{ $item->kode_buku }}" required>
                                </div> 
                                <div class="mb-3">
                                    <label class="form-label">Judul</label>
                                    <input type="text" class="form-control" name="judul" value="{{ $item->judul }}" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Penulis</label>
                                    <input type="text" class="form-control" name="penulis" value="{{ $item->penulis }}" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Penerbit</label>
                                    <input type="text" class="form-control" name="penerbit" value="{{ $item->penerbit }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Tahun Terbit</label>
                                    <input type="number" class="form-control" name="tahun_terbit" value="{{ $item->tahun_terbit }}" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Jumlah</label>
                                    <input type="number" class="form-control" name="jumlah" value="{{ $item->jumlah }}" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Kategori</label>
                                    <select class="form-control" name="kategori">
                                        <option value="">-- Pilih Kategori --</option>
                                        <option value="Novel" {{ $item->kategori == 'Novel' ? 'selected' : '' }}>Novel</option>
                                        <option value="Komik" {{ $item->kategori == 'Komik' ? 'selected' : '' }}>Komik</option>
                                        <option value="Teknologi" {{ $item->kategori == 'Teknologi' ? 'selected' : '' }}>Teknologi</option>
                                        <option value="Pendidikan" {{ $item->kategori == 'Pendidikan' ? 'selected' : '' }}>Pendidikan</option>
                                        <option value="Agama" {{ $item->kategori == 'Agama' ? 'selected' : '' }}>Agama</option>
                                        <option value="Sejarah" {{ $item->kategori == 'Sejarah' ? 'selected' : '' }}>Sejarah</option>
                                        <option value="Lainnya" {{ $item->kategori == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Gambar</label>
                                    <input type="file" class="form-control" name="gambar" accept="image/*">
                                    @if($item->gambar)
                                        <div class="mt-2">
                                            <img src="{{ asset('storage/' . $item->gambar) }}" alt="Gambar Buku" class="img-thumbnail" style="width: 100px;">
                                        </div>
                                    @endif
                                    <small class="text-muted">Kosongkan jika tidak ingin mengganti gambar.</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="hapusBukuModal-{{ $item->id }}" tabindex="-1" aria-labelledby="hapusBukuModalLabel-{{ $item->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="hapusBukuModalLabel-{{ $item->id }}">Hapus Buku</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus buku <strong>"{{ $item->judul }}"</strong>?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
                    <form action="{{ route('admin.buku.destroy', $item->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach

@endsection

@push('scripts')
    {{-- JS jQuery & DataTables --}}
   

    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/id.json',
                }
            });
        });
    </script>
@endpush