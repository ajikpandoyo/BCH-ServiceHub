<?php

namespace App\Http\Controllers;

use App\Models\SesiRuangan;
use App\Models\KelolaRuangan;
use Illuminate\Http\Request;

class SesiRuanganController extends Controller
{
    public function create($ruanganId)
    {
        $ruangan = KelolaRuangan::findOrFail($ruanganId);
        return view('sesi.create', compact('ruangan'));
    }

    public function store(Request $request, $ruanganId)
    {
        $request->validate([
            'nama_sesi' => 'required|string',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
        ]);

        SesiRuangan::create([
            'kelola_ruangan_id' => $ruanganId,
            'nama_sesi' => $request->nama_sesi,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
        ]);

        return redirect()->route('ruangan.show', $ruanganId)->with('success', 'Sesi berhasil ditambahkan');
    }
}

