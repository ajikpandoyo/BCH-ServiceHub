<?php

namespace App\Exports;

use App\Models\MediaPartner;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class MediaPartnerExport implements FromCollection, WithHeadings, WithMapping
{
    protected $mediaPartners;

    public function __construct($mediaPartners)
    {
        $this->mediaPartners = $mediaPartners;
    }

    public function collection()
    {
        return $this->mediaPartners;
    }

    public function headings(): array
    {
        return [
            'Nama Pemohon',
            'Nama Event',
            'Penyelenggara',
            'Tanggal Event',
            'Status',
            'Tanggal Pengajuan'
        ];
    }

    public function map($mediaPartner): array
    {
        return [
            $mediaPartner->nama_pemohon,
            $mediaPartner->tema_acara,
            $mediaPartner->nama_instansi,
            $mediaPartner->tanggal_acara,
            $mediaPartner->status,
            $mediaPartner->created_at->format('d/m/Y')
        ];
    }
}