<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PeminjamanEvent extends Model
{
    protected $table = 'peminjaman_events';
    
    protected $fillable = [
        'user_id',
        'event_id',
        'nama_pemohon',
        'instansi',
        'sosmed_instansi',
        'tema_acara',
        'waktu_loading',
        'surat_pengajuan',
        'ktp',
        'screening_file',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}

