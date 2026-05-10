@extends('layouts.master')

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    
    <style>
        /* CSS Tambahan agar Search Box & Pagination rata kanan */
        .dataTables_wrapper .dataTables_filter {
            float: right;
            text-align: right;
        }
        .dataTables_wrapper .dataTables_paginate {
            float: right;
            text-align: right;
        }
        .dataTables_filter input {
            margin-left: 0.5em;
            display: inline-block;
            width: auto;
        }
    </style>
@endpush

@section('content')
<div class="container-fluid pt-4 px-4">
    
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="bg-light text-center rounded p-4 shadow-sm">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h6 class="mb-0">Daftar Anggota</h6>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
                <i class="fas fa-plus me-1"></i> Tambah Anggota
            </button>
        </div>
        
        <div class="table-responsive">
            {{-- Tambahkan ID="tableAnggota" agar terdeteksi DataTables --}}
            <table class="table text-start align-middle table-bordered table-hover mb-0" id="tableAnggota">
                <thead>
                    <tr class="text-dark">
                        <th>#</th>
                        <th>Nama Lengkap</th>
                        <th>NIS</th>
                        <th>Email</th>
                        <th>Alamat</th>
                        <th>Role</th>
                        <th>Tanggal Dibuat</th>
                        <th width="20%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $user->nama_lengkap }}</td>
                        <td>{{ $user->nis}}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->alamat }}</td>
                        <td>
                            <span class="badge {{ $user->role == 'admin' ? 'bg-danger' : 'bg-primary' }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td>{{ $user->created_at->format('d/m/Y') }}</td>
                        <td>
                            <div class="d-flex gap-1 justify-content-center">
                                <button type="button" class="btn btn-sm btn-info edit-btn text-white" data-bs-toggle="modal" data-bs-target="#editModal"
                                data-id="{{ $user->id }}"
                                data-nama_lengkap="{{ $user->nama_lengkap }}"
                                data-name="{{ $user->name }}"
                                data-nis="{{ $user->nis }}"
                                data-email="{{ $user->email }}"
                                data-alamat="{{ $user->alamat }}"
                                data-role="{{ $user->role }}">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
    
                                <a href="{{ route('anggota.cetak', $user->id) }}" target="_blank" class="btn btn-sm btn-success">
                                    <i class="fas fa-print"></i>
                                </a>
    
                                <form action="{{ route('anggota.destroy', $user->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModalLabel">Tambah Anggota Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('anggota.store') }}" method="POST">
                @csrf
                <div class="modal-body text-start">
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" name="nama_lengkap" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Panggilan</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nomor Induk Siswa</label>
                        <input type="text" class="form-control" name="nis" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alamat</label>
                        <input type="text" class="form-control" name="alamat" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Role</label>
                        <select name="role" class="form-select" required>
                            <option value="user">User</option>
                            <option value="admin">Admin</option>
                        </select>
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

<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Anggota</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body text-start">
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" id="edit_nama_lengkap" name="nama_lengkap" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Panggilan</label>
                        <input type="text" class="form-control" id="edit_name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nomor Induk Siswa</label>
                        <input type="text" class="form-control" id="edit_nis" name="nis" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" id="edit_email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alamat</label>
                        <input type="text" class="form-control" id="edit_alamat" name="alamat" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password (Kosongkan jika tidak diubah)</label>
                        <input type="password" class="form-control" id="edit_password" name="password">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Role</label>
                        <select name="role" id="edit_role" class="form-select" required>
                            <option value="user">User</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    {{-- Library jQuery & DataTables --}}
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

    {{-- Script Inisialisasi DataTables --}}
    <script>
        $(document).ready(function() {
            $('#tableAnggota').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/id.json',
                },
                columnDefs: [
                    { orderable: false, targets: 7 } // Matikan sorting di kolom Aksi (index 7)
                ]
            });
        });
    </script>

    {{-- Script Modal Edit --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const editModal = document.getElementById('editModal');
            
            // Event listener untuk saat modal ditampilkan
            editModal.addEventListener('show.bs.modal', function (event) {
                // Tombol yang memicu modal
                const button = event.relatedTarget;

                // Ambil data dari atribut data-*
                const id = button.getAttribute('data-id');
                const nama = button.getAttribute('data-nama_lengkap');
                const name = button.getAttribute('data-name');
                const nis = button.getAttribute('data-nis');
                const email = button.getAttribute('data-email');
                const role = button.getAttribute('data-role');
                const alamat = button.getAttribute('data-alamat');

                // Isi form dalam modal
                const form = document.getElementById('editForm');
                form.action = `/anggota/${id}`; // Pastikan route ini sesuai dengan route resource Anda
                document.getElementById('edit_nama_lengkap').value = nama;
                document.getElementById('edit_name').value = name;
                document.getElementById('edit_nis').value = nis;
                document.getElementById('edit_email').value = email;
                document.getElementById('edit_role').value = role;
                document.getElementById('edit_alamat').value = alamat;
                // Kosongkan password field setiap kali modal dibuka
                document.getElementById('edit_password').value = ''; 
            });
        });
    </script>

    {{-- Script untuk auto-show Create Modal jika ada error validasi --}}
    @if(session('create_modal_active'))
        <script>
            var createModal = new bootstrap.Modal(document.getElementById('createModal'));
            createModal.show();
        </script>
    @endif
@endpush