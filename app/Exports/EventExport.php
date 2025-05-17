<?php

namespace App\Exports;

use App\Models\Event;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EventExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Event::select('nama_event', 'tanggal', 'waktu', 'penyelenggara', 'lokasi_ruangan', 'status')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Nama Event',
            'Tanggal',
            'Waktu',
            'Penyelenggara',
            'Lokasi Ruangan',
            'Status'
        ];
    }
}