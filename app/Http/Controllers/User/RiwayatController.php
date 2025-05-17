<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Riwayat;
use App\Models\PeminjamanRuangan;
use App\Models\KerjasamaEvent;
use App\Models\MediaPartner;
use Illuminate\Http\Request;

class RiwayatController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        $riwayatRuangan = PeminjamanRuangan::where('user_id', $userId)->get()->map(function($item) {
            $item->jenis = 'ruangan';
            $item->nama = $item->nama_peminjam;
            $item->status = $item->status ?? 'pending';
            return $item;
        });
        $riwayatEvent = KerjasamaEvent::where('user_id', $userId)->get()->map(function($item) {
            $item->jenis = 'event';
            $item->nama = $item->nama_peserta;
            $item->status = $item->status ?? 'pending';
            return $item;
        });
        $riwayatMediaPartner = MediaPartner::where('user_id', $userId)->get()->map(function($item) {
            $item->jenis = 'mediapartner';
            $item->nama = $item->nama_pemohon;
            $item->status = $item->status ?? 'pending';
            return $item;
        });

        $riwayat = $riwayatRuangan
            ->merge($riwayatEvent)
            ->merge($riwayatMediaPartner)
            ->sortByDesc('created_at')
            ->values();

        // For debugging
        \Log::info('Riwayat data:', ['data' => $riwayat->toArray()]);
    
        return view('user.riwayat.index', compact('riwayat'));
    }

    public function show($id)
    {
        $riwayat = Riwayat::findOrFail($id);
        
        return view('user.riwayat.show', compact('riwayat'));
    }
}