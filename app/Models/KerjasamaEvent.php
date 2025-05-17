<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KerjasamaEvent extends Model
{
    protected $table = 'kerjasama_events';

    protected $fillable = [
        'nama_event',
        'deskripsi_event',
        'tanggal_pelaksanaan',
        'lokasi',
        'proposal',
        'status',
        'catatan',
        // Peserta/User fields
        'nama_peserta',
        'email_peserta',
        'telepon_peserta',
        'instansi_peserta',
        'bukti_pembayaran',
        'user_id' // To link with registered user
    ];

    protected $casts = [
        'tanggal_pelaksanaan' => 'date'
    ];

    // Relationship with User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship with registrations
    public function registrations()
    {
        return $this->hasMany(KerjasamaEventRegistration::class, 'event_id');
    }
}