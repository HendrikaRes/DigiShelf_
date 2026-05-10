@extends('layouts.master')

@section('content')
<div class="container-fluid pt-4 px-4">

    {{-- Alert Success --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Card --}}
    <div class="card shadow border-0">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="fa fa-exchange-alt me-2"></i> Pengembalian Buku</h5>
        </div>

        <div class="card-body">
            <table class="table table-bordered table-striped align-middle" id="pengembalianTable">
                <thead class="table-light">
                    <tr>
                        <th width="5%">No</th>
                        <th>User</th>
                        <th>Buku</th>
                        <th>Tgl Pinjam</th>
                        <th>Batas Kembali</th>
                        <th width="12%">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($data as $item)
                    @php
                          $deadline = Carbon\Carbon::parse($item->tgl_kembali);
    $today = Carbon\Carbon::today();

                        $isLate = $today->gt($deadline);
                        $hariTelat = $isLate ? $deadline->diffInDays($today) : 0;
                        $denda = $hariTelat * 1000;
                    @endphp


                    <tr class="{{ $isLate ? 'table-danger' : '' }}">
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->user->name }}</td>
                        <td>{{ $item->buku->judul }}</td>
                        <td>{{ $item->tgl_pinjam }}</td>
                        <td>
                            {{ $item->tgl_kembali }}
                            @if($isLate)
                                <span class="badge bg-danger ms-2">Terlambat</span>
                            @endif
                        </td>
                        <td>
                            <button class="btn btn-success btn-sm w-100"
                                data-bs-toggle="modal"
                                data-bs-target="#modalKembali{{ $item->id }}">
                                Kembalikan
                            </button>
                        </td>
                    </tr>

                    {{-- Modal --}}
                    <div class="modal fade" id="modalKembali{{ $item->id }}" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">

                                <div class="modal-header bg-light">
                                    <h5 class="modal-title"><i class="fa fa-check-circle me-1"></i>Konfirmasi Pengembalian</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <div class="modal-body">
                                    <p><strong>Buku:</strong> {{ $item->buku->judul }}</p>
                                    <p><strong>Peminjam:</strong> {{ $item->user->name }}</p>
                                    
                                    <p><strong>Status:</strong>
                                        @if($isLate)
                                            <span class="badge bg-danger">
                                                Terlambat {{ $hariTelat }} hari — Denda: Rp {{ number_format($denda,0,',','.') }}
                                            </span>
                                        @else
                                            <span class="badge bg-success">Tidak Terlambat</span>
                                        @endif
                                    </p>

                                </div>

                                <div class="modal-footer">
                                    <form action="{{ route('admin.pengembalian.proses', $item->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa fa-check me-1"></i> Proses
                                        </button>
                                    </form>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                </div>

                            </div>
                        </div>
                    </div>
                    @endforeach
                </tbody>

            </table>
        </div>
    </div>
</div>
@endsection


@push('styles')
<style>
    #pengembalianTable_wrapper .dataTables_filter {
        float: right;
        margin-bottom: 8px;
    }

    #pengembalianTable_wrapper .dataTables_paginate {
        float: right;
        margin-top: 8px;
    }
</style>
@endpush

@push('scripts')
<script>
    $(document).ready(function () {
        $('#pengembalianTable').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.13.4/i18n/id.json"
            }
        });
    });
</script>
@endpush
