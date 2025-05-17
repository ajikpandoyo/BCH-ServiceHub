<?php

namespace App\Imports;

use App\Models\PeminjamanRuangan;
use App\Models\KelolaRuangan;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class PeminjamanRuanganImport implements ToModel, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    protected $currentUserId;

    public function __construct($lastUserId)
    {
        $this->currentUserId = $lastUserId;
    }

    public function model(array $row)
    {
        
        // // Increment user_id untuk setiap baris baru
        // $this->currentUserId++;

        $userId = 1;

        // Cari ruangan berdasarkan nama dari kolom Excel 'ruangan'
        $ruangan = KelolaRuangan::where('nama_ruangan', $row['ruangan'])->first();

        // Jika ruangan tidak ditemukan, kamu bisa set null atau id default
        $ruangan_id = $ruangan ? $ruangan->id : 1; // Atau misal 1 kalau mau default

        
        $convertedData = [
            'user_id' =>  $userId,
            'nama_peminjam' => $row['nama_peminjam'],
            'email_peminjam' => $row['email'],
            'telepon_peminjam' => $row['nomor_telepon'],
            'instansi_peminjam' => $row['instansi'],
            'ruangan_id' => $ruangan_id,
            'kegiatan' => $row['kegiatan'],
            'deskripsi_kegiatan' => $row['deskripsi'],
            'tanggal_peminjaman' => is_numeric($row['tanggal_peminjaman']) 
                ? Date::excelToDateTimeObject($row['tanggal_peminjaman'])->format('Y-m-d')
                : \Carbon\Carbon::parse($row['tanggal_peminjaman'])->format('Y-m-d'),
            'waktu_mulai' => is_numeric($row['waktu_mulai']) 
                ? Date::excelToDateTimeObject($row['waktu_mulai'])->format('H:i:s')
                : \Carbon\Carbon::parse($row['waktu_mulai'])->format('H:i:s'),
            'waktu_selesai' => is_numeric($row['waktu_selesai']) 
                ? Date::excelToDateTimeObject($row['waktu_selesai'])->format('H:i:s')
                : \Carbon\Carbon::parse($row['waktu_selesai'])->format('H:i:s'),
            'jumlah_peserta' => $row['jumlah_peserta'],
            'status' => 'pending',
            'surat_peminjaman' => 'default-placeholder.pdf', 
        ];

        return new PeminjamanRuangan($convertedData);
    }
}
