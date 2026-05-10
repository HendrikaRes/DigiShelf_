@extends('layouts.master')

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    
    <style>
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

    {{-- Inisialisasi variabel total denda --}}
    @php $totalDendaGlobal = 0; @endphp

    <div class="d-flex align-items-center justify-content-between mb-4">
        <h4 class="mb-0 text-gray-800">Laporan Perpustakaan</h4>
    </div>

    {{-- CARD FILTER DATA --}}
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Filter Laporan</h6>
        </div>
        <div class="card-body">
            {{-- Form Filter mengarah ke route admin.laporan.index --}}
            <form action="{{ route('laporan.index') }}" method="GET">
                <div class="row align-items-end">
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Tanggal Awal</label>
                        <input type="date" class="form-control" name="tgl_awal" value="{{ request('tgl_awal') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Tanggal Akhir</label>
                        <input type="date" class="form-control" name="tgl_akhir" value="{{ request('tgl_akhir') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Status</label>
                        <select name="status" class="form-select">
                            <option value="">Semua Status</option>
                            <option value="dipinjam" {{ request('status') == 'dipinjam' ? 'selected' : '' }}>Sedang Dipinjam</option>
                            <option value="dikembalikan" {{ request('status') == 'dikembalikan' ? 'selected' : '' }}>Sudah Dikembalikan</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-filter me-1"></i> Filter
                            </button>
                            {{-- Tombol Cetak (Placeholder) --}}
                           <a href="{{ route('laporan.export', request()->query()) }}" class="btn btn-success w-100" target="_blank">
    <i class="fas fa-file-excel me-1"></i> Export Excel
</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- CARD TABEL DATA --}}
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Hasil Laporan Transaksi</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle" id="tableLaporan" width="100%" cellspacing="0">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>ID Transaksi</th>
                            <th>Peminjam</th>
                            <th>Buku</th>
                            <th>Tgl Pinjam</th>
                            <th>Batas Kembali</th>
                            <th>Tgl Dikembalikan</th>
                            <th>Status</th>
                            <th>Denda</th>
                        </tr>
                    </thead>
                    <tbody>
    @forelse($laporan as $item)
        {{-- BAGIAN INI DIGANTI: Ambil langsung dari database, jangan hitung manual --}}
        @php
            // Ambil data denda dari relasi pengembalian
            // Jika ada data pengembalian, ambil dendanya. Jika tidak, 0.
            $denda = $item->pengembalian ? $item->pengembalian->denda : 0;
            
            // Tambahkan ke total global untuk footer
            $totalDendaGlobal += $denda;
        @endphp

        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>TRX-{{ str_pad($item->id, 4, '0', STR_PAD_LEFT) }}</td>
            
            {{-- Peminjam --}}
            <td>
                {{ $item->user->nama_lengkap ?? ($item->user->name ?? 'User Terhapus') }}
            </td>
            
            {{-- Buku --}}
            <td>{{ $item->buku->judul ?? 'Buku Terhapus' }}</td>
            
            {{-- Tanggal --}}
            <td>{{ \Carbon\Carbon::parse($item->tgl_pinjam)->format('d/m/Y') }}</td>
            <td>{{ \Carbon\Carbon::parse($item->tgl_kembali)->format('d/m/Y') }}</td>
            
            {{-- Tgl Dikembalikan --}}
            <td>
                @if($item->tgl_dikembalikan)
                    {{ \Carbon\Carbon::parse($item->tgl_dikembalikan)->format('d/m/Y') }}
                @else
                    -
                @endif
            </td>

            {{-- Status --}}
            <td>
                @if ($item->status == 'dipinjam')
                    @if(now()->gt(\Carbon\Carbon::parse($item->tgl_kembali)))
                        <span class="badge bg-danger">Terlambat</span>
                    @else
                        <span class="badge bg-warning text-dark">Dipinjam</span>
                    @endif
                @else
                    <span class="badge bg-success">Dikembalikan</span>
                @endif
            </td>

            {{-- Denda (Tampil dari Database) --}}
            <td class="text-end">
                @if($denda > 0)
                    <span class="text-danger fw-bold">Rp {{ number_format($denda, 0, ',', '.') }}</span>
                @else
                    -
                @endif
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="9" class="text-center">Tidak ada data transaksi ditemukan sesuai filter.</td>
        </tr>
    @endforelse
</tbody>
                    <tfoot>
                        <tr class="fw-bold bg-light">
                            <td colspan="8" class="text-end">Total Denda (Terbayar & Potensi):</td>
                            <td class="text-end">Rp {{ number_format($totalDendaGlobal, 0, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
    {{-- Scripts DataTables --}}
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#tableLaporan').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/id.json',
                },
                // Mematikan sorting pada kolom No dan Denda agar tampilan tetap rapi
                columnDefs: [
                    { orderable: false, targets: [0, 8] }
                ]
            });
        });
    </script>
@endpush