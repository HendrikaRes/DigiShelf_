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
                <h6 class="text-uppercase mb-1" style="letter-spacing: 1px; opacity: 0.8;">Perpus Digital</h6>
                <h2 class="fw-bold mb-0">
                    <i class="fas fa-book-reader me-2"></i>Peminjaman Saya
                </h2>
                <p class="mt-2 mb-0 opacity-75">
                    Halo, <strong>{{ Auth::user() ? Auth::user()->name : 'Guest' }}</strong>! Kamu sedang meminjam <span class="badge bg-white text-primary rounded-pill px-3">{{ $sedangDipinjam->count() }}</span> saat ini.
                </p>
            </div>
            
            <div class="d-none d-md-block">
                <a href="{{ route('user.buku.index') }}" class="btn btn-light text-primary fw-bold shadow-sm">
                    <i class="fas fa-plus me-1"></i> Pinjam Buku Baru
                </a>
            </div>
        </div>
    </div>
</div>
    <div class="d-flex align-items-center mb-3">
        <h5 class="m-0 me-2">Sedang Dipinjam</h5>
        <span class="badge bg-primary rounded-pill">{{ $sedangDipinjam->count() }}</span>
    </div>

    <div class="row g-4 mb-5">
        @forelse ($sedangDipinjam as $item)
            <div class="col-md-4 col-lg-3">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-img-top text-center p-3 bg-light">
                        <img src="{{ asset('storage/' . $item->buku->gambar) }}" 
                             class="img-fluid rounded shadow-sm"
                             style="height: 200px; object-fit: cover; width: 100%; max-width: 150px;"
                             alt="{{ $item->buku->judul }}">
                    </div>

                    <div class="card-body d-flex flex-column">
                        <h6 class="card-title fw-bold text-truncate" title="{{ $item->buku->judul }}">
                            {{ $item->buku->judul }}
                        </h6>
                        <p class="text-muted small mb-2">{{ $item->buku->penulis }}</p>
                        
                        <div class="mt-auto">
                            <span class="badge bg-warning text-dark mb-3">Sedang Dipinjam</span>
                            <button class="btn btn-outline-primary btn-sm w-100" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#detailPinjam{{ $item->id }}">
                                <i class="bi bi-eye"></i> Detail
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="detailPinjam{{ $item->id }}" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Detail Peminjaman</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body text-center">
                            <img src="{{ asset('storage/' . $item->buku->gambar) }}" 
                                 class="img-fluid rounded mb-3 shadow"
                                 style="max-height: 250px;">
                            
                            <h5 class="fw-bold">{{ $item->buku->judul }}</h5>
                            <p class="text-muted mb-4">{{ $item->buku->penulis }}</p>

                            <div class="row text-start bg-light p-3 rounded mx-1">
                                <div class="col-6">
                                    <small class="text-muted d-block">Tanggal Pinjam</small>
                                    <strong>{{ $item->tgl_pinjam }}</strong>
                                </div>
                                <div class="col-6">
                                    <small class="text-muted d-block">Wajib Kembali</small>
                                    <strong class="text-danger">{{ $item->tgl_kembali ?? '-' }}</strong>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-center">
                             <span class="badge bg-warning text-dark px-3 py-2">Status: Sedang Dipinjam</span>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="alert alert-info text-center py-4" role="alert">
                    <i class="bi bi-info-circle me-2"></i> Anda tidak sedang meminjam buku apa pun.
                </div>
            </div>
        @endforelse
    </div>


    <div class="d-flex justify-content-between align-items-center mb-3 border-bottom pb-2">
        <h5 class="m-0">Riwayat Peminjaman</h5>
    </div>

    <div class="list-group shadow-sm">
        @forelse ($riwayat as $item)
            <div class="list-group-item list-group-item-action p-3 border-start-0 border-end-0">
                <div class="row align-items-center">
                    <div class="col-md-6 mb-2 mb-md-0">
                        <h6 class="mb-1 fw-bold">{{ $item->buku->judul }}</h6>
                        <small class="text-muted"><i class="bi bi-person"></i> {{ $item->buku->penulis }}</small>
                    </div>

                    <div class="col-md-4 mb-2 mb-md-0">
                        <small class="d-block text-muted">Pinjam: {{ $item->tgl_pinjam }}</small>
                        <small class="d-block text-muted">Kembali: {{ $item->tgl_kembali }}</small>
                    </div>

                    <div class="col-md-2 text-md-end d-flex flex-column align-items-md-end align-items-start gap-2">
                        <span class="badge bg-success rounded-pill">Selesai</span>
                        <button class="btn btn-sm btn-light border" 
                                data-bs-toggle="modal" 
                                data-bs-target="#riwayatModal{{ $item->id }}">
                            Detail
                        </button>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="riwayatModal{{ $item->id }}" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Detail Riwayat</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="d-flex align-items-start">
                                <img src="{{ asset('storage/' . $item->buku->gambar) }}" 
                                     class="rounded me-3" 
                                     style="width: 80px; height: 120px; object-fit: cover;">
                                <div>
                                    <h5 class="mb-1">{{ $item->buku->judul }}</h5>
                                    <p class="text-muted mb-2">{{ $item->buku->penulis }}</p>
                                    <span class="badge bg-success">Dikembalikan</span>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-6">
                                    <small class="text-muted">Tanggal Pinjam</small>
                                    <p class="fw-bold">{{ $item->tgl_pinjam }}</p>
                                </div>
                                <div class="col-6">
                                    <small class="text-muted">Tanggal Kembali</small>
                                    <p class="fw-bold">{{ $item->tgl_kembali }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center py-5 text-muted border rounded bg-white">
                <p class="mb-0">Belum ada riwayat peminjaman.</p>
            </div>
        @endforelse
    </div>

</div>
@endsection