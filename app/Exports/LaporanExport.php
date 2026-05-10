<?php

namespace App\Exports;

use App\Models\Peminjaman;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LaporanExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $request;

    // Terima data request (filter) dari controller
    public function __construct($request)
    {
        $this->request = $request;
    }

    /**
    * Ambil data dari database sesuai filter
    */
    public function collection()
    {
        $query = Peminjaman::with(['user', 'buku', 'pengembalian']);

        // Filter Tanggal Awal
        if ($this->request->filled('tgl_awal')) {
            $query->whereDate('tgl_pinjam', '>=', $this->request->tgl_awal);
        }

        // Filter Tanggal Akhir
        if ($this->request->filled('tgl_akhir')) {
            $query->whereDate('tgl_pinjam', '<=', $this->request->tgl_akhir);
        }

        // Filter Status
        if ($this->request->filled('status')) {
            $query->where('status', $this->request->status);
        }

        return $query->orderBy('created_at', 'desc')->get();
    }

    /**
    * Judul Kolom (Header)
    */
    public function headings(): array
    {
        return [
            'No',
            'Kode Transaksi',
            'Nama Peminjam',
            'Judul Buku',
            'Tanggal Pinjam',
            'Batas Kembali',
            'Tanggal Dikembalikan',
            'Status',
            'Denda (Rp)',
        ];
    }

    /**
    * Mapping Data per Baris
    */
    public function map($item): array
    {
        // Logika Ambil Denda (Sama seperti di View)
        $denda = $item->pengembalian ? $item->pengembalian->denda : 0;

        // Logika Status Text
        $statusText = '';
        if ($item->status == 'dipinjam') {
            if (now()->gt(\Carbon\Carbon::parse($item->tgl_kembali))) {
                $statusText = 'Terlambat';
            } else {
                $statusText = 'Sedang Dipinjam';
            }
        } else {
            $statusText = 'Dikembalikan';
        }

        // static $no = 0; // Cara manual untuk nomor urut jika diperlukan, tapi Excel punya row number sendiri.

        return [
            $item->id, // Atau bisa pakai increment manual
            'TRX-' . str_pad($item->id, 4, '0', STR_PAD_LEFT),
            $item->user->nama_lengkap ?? $item->user->name,
            $item->buku->judul,
            \Carbon\Carbon::parse($item->tgl_pinjam)->format('d/m/Y'),
            \Carbon\Carbon::parse($item->tgl_kembali)->format('d/m/Y'),
            $item->tgl_dikembalikan ? \Carbon\Carbon::parse($item->tgl_dikembalikan)->format('d/m/Y') : '-',
            $statusText,
            $denda // Angka mentah agar bisa dijumlah di Excel
        ];
    }

    /**
    * Styling Header (Bold)
    */
    public function styles(Worksheet $sheet)
    {
        return [
            1    => ['font' => ['bold' => true]],
        ];
    }
}