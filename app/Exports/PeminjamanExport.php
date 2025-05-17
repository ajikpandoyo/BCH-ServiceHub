<?php

namespace App\Exports;

use App\Models\Peminjaman;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class PeminjamanExport implements FromCollection, WithHeadings,FromView
{
    public function collection()
    {
        return Peminjaman::select('nama_peminjam', 'ruangan', 'tanggal_peminjaman', 'waktu_mulai', 'waktu_selesai', 'keperluan', 'status')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Nama Peminjam',
            'Ruangan',
            'Tanggal Peminjaman',
            'Waktu Mulai',
            'Waktu Selesai',
            'Keperluan',
            'Status'
        ];
    }
}