<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KunjunganVisit extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_pengunjung',
        'instansi',
        'tanggal_kunjungan',
        'jumlah_pengunjung',
        'tujuan_kunjungan',
        'proposal',
        'status'
    ];

    public function riwayat()
    {
        return $this->morphOne(Riwayat::class, 'pendaftaran');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}