<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MediaPartner extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama_pemohon',
        'email',
        'nama_instansi',
        'instagram',
        'website',
        'tema_acara',
        'kategori_subsektor',
        'tanggal_acara',
        'pic_nama',
        'pic_whatsapp',
        'surat_pengajuan',
        'status'
    ];

    protected $dates = [
        'tanggal_acara'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}