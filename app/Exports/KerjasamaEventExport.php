<?php

namespace App\Exports;

use App\Models\KerjasamaEvent;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class KerjasamaEventExport implements FromCollection, WithHeadings, WithMapping
{
    public function __construct($kerjasama)
    {
        $this->kerjasama = $kerjasama;
    }
    public function collection()
    {
        return KerjasamaEvent::all();
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Event',
            'Nama Peserta',
            'Email',
            'Telepon',
            'Instansi',
            'Tanggal Pelaksanaan',
            'Status',
            'Tanggal Dibuat'
        ];
    }

    public function map($kerjasama): array
    {
        static $no = 0;
        $no++;
        
        return [
            $no,
            $kerjasama->nama_event,
            $kerjasama->nama_peserta ?? '-',
            $kerjasama->email_peserta ?? '-',
            $kerjasama->telepon_peserta ?? '-',
            $kerjasama->instansi_peserta ?? '-',
            $kerjasama->tanggal_pelaksanaan,
            ucfirst($kerjasama->status),
            $kerjasama->created_at->format('d/m/Y')
        ];
    }
}