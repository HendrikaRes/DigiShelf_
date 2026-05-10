@extends('layouts.master')

@section('content')
<div class="container mt-4">

    <div class="card border-0 shadow-sm rounded-3 mb-4 bg-primary text-white overflow-hidden">
    <div class="position-absolute top-0 end-0 mt-n4 me-n4 d-none d-md-block" style="opacity: 0.1;">
        <i class="fas fa-exchange-alt fa-10x"></i>
    </div>
    
    <div class="card-body p-4 position-relative">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h6 class="text-uppercase mb-1" style="letter-spacing: 1px; opacity: 0.8;">LAYANAN SIRKULASI</h6>
                
                <h2 class="fw-bold mb-0">
                    <i class="fas fa-exchange-alt me-2"></i>Transaksi Pengembalian
                </h2>
                
                <p class="mt-2 mb-0 opacity-75">
                    Halo, <strong>{{ Auth::user() ? Auth::user()->name : 'Pustakawan' }}</strong>! 
Siap memproses pengembalian. Ada 
<span class="badge bg-red text-danger" style="font-size: 1.1rem; padding: 6px 12px;">
    {{ $terlambat->count() }}
</span>
 buku yang terlambat dikembalikan.

                        
                    </span> 
                    buku yang statusnya **Terlambat** hari ini.
                </p>
            </div>
            
            <div class="d-none d-md-block">
               <a href="#" data-bs-toggle="modal" data-bs-target="#modalTerlambat"
   class="btn btn-light text-danger fw-bold shadow-sm">
    <i class="fas fa-calendar-times me-1"></i> Cek Keterlambatan
</a>

                </div>
        </div>
    </div>
</div>

    @if ($peminjaman->isEmpty())
        <div class="alert alert-info">
            Anda tidak memiliki buku yang sedang dipinjam.
        </div>
    @endif

    <div class="row">
    @foreach ($peminjaman as $item)

       @php
    $due = \Carbon\Carbon::parse($item->tgl_kembali);
    $isLate = $due->isPast();
    $lateDays = $isLate ? $due->diffInDays(now()) : 0;
@endphp



        <div class="col-md-4 mb-4">
            <div class="card shadow-sm {{ $isLate ? 'border-danger' : '' }}">

                <div class="card-body text-center">

                    <img src="{{ asset('storage/' . $item->buku->gambar) }}"
                        class="img-fluid rounded mb-3"
                        style="height: 160px; object-fit: cover">

                    <h5 class="fw-bold">{{ $item->buku->judul }}</h5>

                    <p class="text-muted mb-1">
                        <i class="fa fa-calendar"></i> Tgl Pinjam:
                        <strong>{{ $item->tgl_pinjam }}</strong>
                    </p>

                    <p class="text-muted mb-3">
                        <i class="fa fa-calendar-check"></i> Tenggat:
                        <strong>{{ $item->tgl_kembali }}</strong>
                    </p>

                   @if ($isLate)
    <div class="alert alert-danger small">
        <strong>Terlambat {{ floor($lateDays) }} hari!</strong>

        Segera kembalikan buku ke petugas perpustakaan.
    </div>
@else

                        <div class="alert alert-warning small">
                            Buku ini sedang dalam status <strong>Dipinjam</strong>.<br>
                            Silakan datang ke petugas perpustakaan untuk mengembalikan.
                        </div>
                    @endif

                </div>
            </div>
        </div>

    @endforeach
</div>
<!-- Modal Cek Keterlambatan -->
<div class="modal fade" id="modalTerlambat" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">
                    <i class="fa fa-exclamation-triangle me-2"></i>
                    Daftar Buku Terlambat
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                
                @if($terlambat->isEmpty())
                    <div class="alert alert-success text-center">
                        🎉 Tidak ada buku yang terlambat! 
                    </div>
                @else
                    <ul class="list-group">
                        @foreach ($terlambat as $t)
                           <li class="list-group-item">
    <h6 class="fw-bold">{{ $t->buku->judul }}</h6>

    <p class="mb-1">
        <strong>Tanggal Pinjam:</strong> {{ $t->tgl_pinjam }}
    </p>

    <p class="mb-1">
        <strong>Tenggat Kembali:</strong> {{ $t->tgl_kembali }}
    </p>

    @php
        $hari = intval(
            \Carbon\Carbon::parse($t->tgl_kembali)->diffInDays(now())
        );
        $denda = $hari * 1000; // 1000 = denda per hari
    @endphp

    <span class="badge bg-danger mb-2">
        Terlambat {{ $hari }} hari
    </span>

    <p class="mt-2 mb-0">
        <strong>Denda:</strong> 
        <span class="text-danger fw-bold">
            Rp {{ number_format($denda, 0, ',', '.') }}
        </span>
    </p>
</li>

                        @endforeach
                    </ul>
                @endif

            </div>

        </div>
    </div>
</div>
</div>
@endsection



