<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ruangan extends Model
{
    protected $table = 'kelola_ruangan';
    
    protected $fillable = [
        'nama_ruangan',
        'kapasitas',
        'lokasi',
        'fasilitas',
        'jam_operasional',
        'gambar'
    ];

    // Add accessors to match the view expectations
    public function getNamaAttribute()
    {
        return $this->nama_ruangan;
    }

    public function getImageAttribute()
    {
        return $this->gambar;
    }

    public function getDeskripsiAttribute()
    {
        return $this->fasilitas;
    }
}