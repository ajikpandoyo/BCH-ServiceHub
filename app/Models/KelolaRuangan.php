<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KelolaRuangan extends Model
{
    use HasFactory;

    protected $table = 'kelola_ruangan';
    
    protected $fillable = [
        'nama_ruangan',
        'lantai',
        'kapasitas',
        'lokasi',
        'fasilitas',
        'jam_operasional',
        'gambar',
        'status'
    ];
    
    protected $appends = ['gambar_url'];

    public function getGambarUrlAttribute()
    {
        if ($this->gambar) {
            return asset('storage/images/ruangan/' . $this->gambar);
        }
        return null;
    }

    public function peminjaman()
    {
        return $this->hasMany(PeminjamanRuangan::class, 'ruangan_id');
    }

    public function sesi()
    {
        return $this->hasMany(SesiRuangan::class, 'kelola_ruangan_id');
    }

}