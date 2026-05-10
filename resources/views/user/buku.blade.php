@extends('layouts.master')

@section('content')
<div class="container mt-4">
<div class="card border-0 shadow-sm rounded-3 mb-4 bg-primary text-white overflow-hidden">
    <div class="position-absolute top-0 end-0 mt-n4 me-n4 d-none d-md-block" style="opacity: 0.1;">
        <i class="fas fa-book fa-10x"></i>
    </div>
    
    <div class="card-body p-4 position-relative">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h6 class="text-uppercase mb-1" style="letter-spacing: 1px; opacity: 0.8;">Manajemen Pustaka</h6>
                <h2 class="fw-bold mb-0">
                    <i class="fas fa-layer-group me-2"></i>Data Buku
                </h2>
                <p class="mt-2 mb-0 opacity-75">
                   Halo, <strong>{{ Auth::user() ? Auth::user()->name : 'Anggota' }}</strong>! Temukan buku favoritmu dari total 
                    <span class="badge bg-white text-primary rounded-pill px-3">
                        {{ $buku->count() }}
                    </span> 
                    judul yang tersedia di perpustakaan.
                </p>
            </div>

        </div>
    </div>
</div>
<div class="container-fluid pt-4 px-4"> 
    

    {{-- ===== Tabel Buku (dengan DataTables) ===== --}}
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table id="tabelBuku" class="table table-bordered table-striped align-middle">
                    <thead class="table-light">
                        <tr class="text-center">
                            <th>No</th>
                            <th>Sampul</th>
                            <th>Judul</th>
                            <th>Penulis</th>
                            <th>Penerbit</th>
                            <th>Tahun</th>
                            <th>Kategori</th>
                            <th>Jumlah</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($buku as $index => $item)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td class="text-center">
                                    @if($item->gambar)
                                        <img src="{{ asset('storage/' . $item->gambar) }}" 
                                             alt="Sampul {{ $item->judul }}" 
                                             class="img-thumbnail" 
                                             style="width: 60px; height: 90px; object-fit: cover;">
                                    @else
                                        <div class="bg-light text-secondary d-flex align-items-center justify-content-center rounded" 
                                             style="width: 60px; height: 90px;">
                                            <i class="fas fa-book"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>{{ $item->judul }}</td>
                                <td>{{ $item->penulis }}</td>
                                <td>{{ $item->penerbit ?? 'Tidak Diketahui' }}</td>
                                <td class="text-center">{{ $item->tahun_terbit }}</td>
                                <td class="text-center">
                                    {{ $item->kategori ?? '-' }}
                                </td>
                                <td class="text-center">
                                    @if ($item->jumlah > 0)
                                        <span class="badge bg-success">{{ $item->jumlah }}</span>
                                    @else
                                        <span class="badge bg-danger">Habis</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if ($item->jumlah > 0)
                                        <a href="#" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalPinjam{{ $item->id }}">
                                            <i class="fas fa-handshake me-1"></i> Pinjam
                                        </a>
                                    @else
                                        <button class="btn btn-sm btn-secondary" disabled>
                                            <i class="fas fa-ban me-1"></i> Stok Habis
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4 text-muted">
                                    <i class="fas fa-box-open fa-2x mb-3 d-block text-info"></i>
                                    Belum ada data buku yang tersedia.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

{{-- ===== Modal Peminjaman ===== --}}
@foreach ($buku as $item)
<div class="modal fade" id="modalPinjam{{ $item->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">
                    Pinjam Buku: <strong>{{ $item->judul }}</strong>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('user.peminjaman.store') }}" method="POST">
    @csrf

                <div class="modal-body">

    <input type="hidden" name="buku_id" value="{{ $item->id }}">
    <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">

    {{-- 🔥 Preview Buku --}}
    <div class="d-flex align-items-center mb-3">
        @if($item->gambar)
            <img src="{{ asset('storage/' . $item->gambar) }}" 
                alt="Sampul {{ $item->judul }}"
                class="img-thumbnail me-3"
                style="width: 70px; height: 100px; object-fit: cover;">
        @else
            <div class="bg-light text-secondary d-flex align-items-center justify-content-center rounded me-3" 
                style="width: 70px; height: 100px;">
                <i class="fas fa-book"></i>
            </div>
        @endif

        <div>
            <h6 class="mb-1">{{ $item->judul }}</h6>
            <small class="text-muted">{{ $item->penulis }}</small><br>
            <small class="text-muted">Kategori: {{ $item->kategori ?? '-' }}</small>
        </div>
    </div>

    {{-- Input Tanggal --}}
    <div class="mb-3">
        <label class="form-label">Tanggal Pinjam</label>
        <input type="date" name="tgl_pinjam" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Tanggal Kembali</label>
        <input type="date" name="tgl_kembali" class="form-control" required>
    </div>

</div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-check me-1"></i> Proses Pinjam
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>
@endforeach


{{-- ===== CSS & JS DataTables ===== --}}
@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
   <style>
    /* 1. Pengaturan untuk Search (Filter) */
    /* Menargetkan elemen Search/Filter dari DataTables dan memaksanya rata kanan */
    div.dataTables_wrapper div.dataTables_filter {
        text-align: right !important;
    }

    /* 2. Pengaturan untuk Pagination */
    /* Memastikan kontrol Pagination juga rata kanan */
    div.dataTables_wrapper div.dataTables_paginate {
        text-align: right !important;
    }

    /* 3. Pengaturan Rapi Jarak Antar Elemen */
    /* Memastikan elemen Length (dropdown entries) dan Search berada di tengah vertikal */
    div.dataTables_wrapper .row {
        align-items: center;
    }
    
    /* OPSIONAL: Memastikan Kolom Kanan (tempat Search berada) pada grid Bootstrap benar-benar rata kanan.
       Ini adalah penargetan yang sangat spesifik untuk mengatasi konflik. */
    .dataTables_wrapper .row .col-md-6:nth-child(2) {
        text-align: right !important;
    }
</style>
@endpush

@push('scripts')
    

    <script>
    $(document).ready(function() {
        var table = $('#tabelBuku').DataTable({
            pageLength: 10,
            lengthMenu: [5, 10, 25, 50],
            dom:
                "<'row mb-3'<'col-md-6'l><'col-md-6'f>>" +
                "<'row'<'col-12'tr>>" +
                "<'row mt-3'<'col-md-6'i><'col-md-6'p>>",
        });

        // 🔥 Filter kategori
        $('#filterKategori').on('change', function () {
            table.column(7).search(this.value).draw(); 
            // Kolom kategori adalah index ke-7 (mulai dari 0)
        });
    });
</script>

@endpush
@endsection
