<?php

namespace App\Exports;

use App\Models\KelolaRuangan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RuanganExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return KelolaRuangan::select(
            'id',
            'nama_ruangan',
            'kapasitas',
            'lokasi',
            'fasilitas',
            'jam_operasional',
            'created_at',
            'updated_at'
        )->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nama Ruangan',
            'Kapasitas',
            'Lokasi',
            'Fasilitas',
            'Jam Operasional',
            'Tanggal Dibuat',
            'Tanggal Diupdate'
        ];
    }
}