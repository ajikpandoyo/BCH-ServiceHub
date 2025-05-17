<?php

namespace App\Exports;

use App\Models\PendaftaranEvent;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PendaftaranEventExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $status;

    public function __construct($status = null)
    {
        $this->status = $status;
    }

    public function collection()
    {
        $query = PendaftaranEvent::with('event')->latest();
        
        if ($this->status) {
            $query->where('status', $this->status);
        }
        
        return $query->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Event',
            'Nama Pendaftar',
            'Email',
            'WhatsApp',
            'Instansi',
            'Tanggal Daftar',
            'Status'
        ];
    }

    public function map($pendaftaran): array
    {
        static $no = 0;
        $no++;
        
        return [
            $no,
            $pendaftaran->event->nama_event,
            $pendaftaran->nama_lengkap,
            $pendaftaran->email,
            $pendaftaran->whatsapp,
            $pendaftaran->instansi,
            $pendaftaran->created_at->format('d/m/Y'),
            ucfirst($pendaftaran->status)
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}