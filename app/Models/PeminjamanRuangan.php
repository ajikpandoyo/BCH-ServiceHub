<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PeminjamanRuangan extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'peminjaman_ruangan';
    
    protected $fillable = [
        'ruangan_id',
        'user_id',
        'nama_peminjam',
        'email_peminjam',
        'telepon_peminjam',
        'instansi_peminjam',
        'kegiatan',
        'deskripsi_kegiatan',
        'tanggal_peminjaman',
        'waktu_mulai',
        'waktu_selesai',
        'jumlah_peserta',
        'status',
        'catatan',
        'surat_peminjaman'
    ];

    protected $dates = [
        'tanggal_peminjaman',
        'waktu_mulai',
        'waktu_selesai',
        'deleted_at'
    ];

    protected $casts = [
        'tanggal_peminjaman' => 'date',
        'waktu_mulai' => 'datetime',
        'waktu_selesai' => 'datetime',
    ];

    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}