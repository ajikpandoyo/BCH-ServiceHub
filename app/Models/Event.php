<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_event',
        'penyelenggara',
        'tanggal_pelaksanaan',
        'waktu',
        'lokasi_ruangan',
        'deskripsi',
        'poster',
        'status'
    ];

    protected $dates = [
        'tanggal_mulai',
        'jam_mulai',
    ];

    protected $casts = [
        'tanggal_pelaksanaan' => 'date'
    ];

    // Accessor untuk URL poster
    public function getPosterUrlAttribute()
    {
        if ($this->poster && Storage::exists($this->poster)) {
            return Storage::url($this->poster);
        }
        return asset('images/default-event.jpg');
    }

    // Scope untuk event yang akan datang
    public function scopeAkanDatang($query)
    {
        return $query->where('status', 'akan_datang');
    }

    // Scope untuk event yang sedang berlangsung
    public function scopeBerlangsung($query)
    {
        return $query->where('status', 'berlangsung');
    }

    // Scope untuk event yang sudah selesai
    public function scopeSelesai($query)
    {
        return $query->where('status', 'selesai');
    }
}