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

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h5 class="mb-0 font-weight-bold text-primary">Data Peminjaman Buku</h5>
        </div>

        <div class="card-body">
            <div class="table-responsive">

                <table class="table table-bordered table-striped align-middle" id="dataTable" width="100%" cellspacing="0">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>User</th>
                            <th>Buku</th>
                            <th>Tgl Pinjam</th>
                            <th>Batas Kembali</th>
                            <th>Dikembalikan</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($peminjaman as $index => $i)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $i->user->name }}</td>
                            <td>{{ $i->buku->judul }}</td>
                            <td>{{ $i->tgl_pinjam }}</td>
                            <td>{{ $i->tgl_kembali }}</td>
                            <td>{{ $i->tgl_dikembalikan ?? '-' }}</td>
                            <td>
                                @if ($i->status == 'dipinjam')
                                    <span class="badge bg-warning text-dark">Dipinjam</span>
                                @else
                                    <span class="badge bg-success">Dikembalikan</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
        </div>

    </div>

</div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

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
