<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SesiRuangan extends Model
{
    use HasFactory;

    protected $table = 'sesi_ruangan';

    protected $fillable = ['kelola_ruangan_id', 'nama_sesi', 'jam_mulai', 'jam_selesai'];

    public function ruangan()
    {
        return $this->belongsTo(KelolaRuangan::class, 'kelola_ruangan_id');
    }
}
