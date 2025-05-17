<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PendaftaranEvent extends Model
{
    protected $fillable = [
        'event_id',
        'user_id',
        'nama_lengkap',
        'email',
        'whatsapp',
        'instansi',
        'bukti_pembayaran',
        'status'
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}