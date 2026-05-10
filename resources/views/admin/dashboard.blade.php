@extends('layouts.master')

@section('content')
<div class="container-fluid px-4 mt-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-secondary">📊 Dashboard Admin</h3>
        <span class="text-muted">{{ now()->translatedFormat('l, d F Y') }}</span>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card bg-primary text-white mb-4 h-100 shadow-sm border-0">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-1" style="font-size: 0.75rem; opacity: 0.8;">Total Anggota</h6>
                            <h2 class="display-6 fw-bold mb-0">{{ $totalUser }}</h2>
                        </div>
                        <i class="fas fa-users fa-2x opacity-50"></i>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between small border-0" style="background: rgba(0,0,0,0.1)">
                    <a class="text-white stretched-link text-decoration-none" href="#">Lihat Detail</a>
                    <div class="text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card bg-success text-white mb-4 h-100 shadow-sm border-0">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-1" style="font-size: 0.75rem; opacity: 0.8;">Total Koleksi Buku</h6>
                            <h2 class="display-6 fw-bold mb-0">{{ $totalBuku }}</h2>
                        </div>
                        <i class="fas fa-book fa-2x opacity-50"></i>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between small border-0" style="background: rgba(0,0,0,0.1)">
                    <a class="text-white stretched-link text-decoration-none" href="#">Lihat Detail</a>
                    <div class="text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card bg-warning text-dark mb-4 h-100 shadow-sm border-0">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-1" style="font-size: 0.75rem; opacity: 0.8;">Total Transaksi</h6>
                            <h2 class="display-6 fw-bold mb-0">{{ $totalPeminjaman }}</h2>
                        </div>
                        <i class="fas fa-history fa-2x opacity-50"></i>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between small border-0" style="background: rgba(0,0,0,0.1)">
                    <a class="text-dark stretched-link text-decoration-none" href="#">Lihat Riwayat</a>
                    <div class="text-dark"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card bg-danger text-white mb-4 h-100 shadow-sm border-0">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-1" style="font-size: 0.75rem; opacity: 0.8;">Sedang Dipinjam</h6>
                            <h2 class="display-6 fw-bold mb-0">{{ $totalDipinjam }}</h2>
                        </div>
                        <i class="fas fa-hand-holding fa-2x opacity-50"></i>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between small border-0" style="background: rgba(0,0,0,0.1)">
                    <a class="text-white stretched-link text-decoration-none" href="#">Lihat Data</a>
                    <div class="text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow-sm mb-4">
                <div class="card-header py-3 bg-white">
                    <h6 class="m-0 font-weight-bold text-primary">🚀 Aktivitas Peminjaman Terakhir</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Peminjam</th>
                                    <th>Buku</th>
                                    <th>Tanggal Pinjam</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($peminjamanTerbaru as $item)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="bg-light rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 35px; height: 35px;">
                                                {{ substr($item->user->name ?? 'U', 0, 1) }}
                                            </div>
                                            <div>
                                                <span class="fw-bold text-dark">{{ $item->user->name ?? 'User Terhapus' }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $item->buku->judul ?? 'Buku Terhapus' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->tgl_pinjam)->format('d M Y') }}</td>
                                    <td>
                                        @if($item->status == 'dipinjam')
                                            <span class="badge bg-warning text-dark">Dipinjam</span>
                                        @elseif($item->status == 'kembali')
                                            <span class="badge bg-success">Dikembalikan</span>
                                        @else
                                            <span class="badge bg-secondary">{{ $item->status }}</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">Belum ada aktivitas peminjaman.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection