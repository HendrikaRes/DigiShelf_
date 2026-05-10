@extends('layouts.master')

@section('content')
<div class="container-fluid px-4 mt-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-secondary">👋 Halo, {{ auth()->user()->name }}</h3>
            <p class="text-muted mb-0">Selamat datang di perpustakaan digital Anda.</p>
        </div>
        <span class="text-muted d-none d-md-block">{{ now()->translatedFormat('l, d F Y') }}</span>
    </div>

    <div class="row g-4 mb-5">
        
        <div class="col-md-6 col-xl-4">
            <div class="card bg-info text-white h-100 shadow-sm border-0">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-1" style="opacity: 0.8;">Sedang Dipinjam</h6>
                            <h2 class="display-6 fw-bold mb-0">{{ $jumlahPinjamanAktif }} <span class="fs-6 fw-normal">Buku</span></h2>
                        </div>
                        <i class="fas fa-book-reader fa-2x opacity-50"></i>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between small border-0" style="background: rgba(0,0,0,0.1)">
                    <span class="text-white opacity-75">Pastikan kembalikan tepat waktu</span>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-4">
            <div class="card bg-success text-white h-100 shadow-sm border-0">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-1" style="opacity: 0.8;">Total Riwayat Pinjam</h6>
                            <h2 class="display-6 fw-bold mb-0">{{ $riwayatPinjam->count() }} <span class="fs-6 fw-normal">Kali</span></h2>
                        </div>
                        <i class="fas fa-history fa-2x opacity-50"></i>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between small border-0" style="background: rgba(0,0,0,0.1)">
                    <span class="text-white opacity-75">Terima kasih sudah membaca!</span>
                </div>
            </div>
        </div>
        
        <div class="col-md-12 col-xl-4">
            <div class="card bg-white border-0 shadow-sm h-100">
                <div class="card-body d-flex flex-column justify-content-center align-items-center text-center">
                    <h6 class="text-muted mb-3">Ingin meminjam buku baru?</h6>
                    <a href="{{ route('user.buku.index') }}" class="btn btn-outline-primary w-100">
                        <i class="fas fa-search me-2"></i>Cari Buku Sekarang
                    </a>
                </div>
            </div>
        </div>

    </div>

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-white py-3">
            <h6 class="m-0 font-weight-bold text-primary">📚 Riwayat Peminjaman Anda</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Judul Buku</th>
                            <th>Tanggal Pinjam</th>
                            <th>Tanggal Kembali</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($riwayatPinjam as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="fw-bold">{{ $item->buku->judul ?? 'Buku Tidak Ditemukan' }}</td>
                            
                            <td>{{ \Carbon\Carbon::parse($item->tgl_pinjam)->translatedFormat('d M Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->tgl_kembali)->translatedFormat('d M Y') }}</td>
                            
                            <td>
                                @if($item->status == 'dipinjam')
                                    <span class="badge bg-warning text-dark">
                                        <i class="fas fa-clock me-1"></i> Sedang Dipinjam
                                    </span>
                                @elseif($item->status == 'kembali' || $item->status == 'dikembalikan')
                                    <span class="badge bg-success">
                                        <i class="fas fa-check-circle me-1"></i> Selesai
                                    </span>
                                @else
                                    <span class="badge bg-secondary">{{ ucfirst($item->status) }}</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="fas fa-book-open fa-3x mb-3 opacity-25"></i>
                                <p>Belum ada riwayat peminjaman.</p>
                                <a href="#" class="btn btn-sm btn-primary">Pinjam Buku Pertama Anda</a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection