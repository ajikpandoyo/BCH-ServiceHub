<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KelolaRuangan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class RuanganController extends Controller
{
    public function index()
    {
        $ruangan = KelolaRuangan::all();
        return view('user.ruangan.index', [
            'ruangan' => $ruangan,
            'title' => 'Daftar Ruangan'
        ]);
    }

    public function show($id)
    {
        $ruangan = KelolaRuangan::findOrFail($id);
        return view('user.ruangan.show', [
            'ruangan' => $ruangan,
            'title' => $ruangan->nama_ruangan
        ]);
    }

    public function filterByLantai($lantai)
    {
        $ruangan = KelolaRuangan::where('lokasi', 'LIKE', '%Lantai ' . $lantai . '%')->get();
        return response()->json($ruangan);
    }

    public function search(Request $request)
    {
        $search = $request->get('search');
        
        $ruangan = KelolaRuangan::where('nama_ruangan', 'like', "%{$search}%")
            ->orWhere('lokasi', 'like', "%{$search}%")
            ->orWhere('fasilitas', 'like', "%{$search}%")
            ->get();

        return view('user.ruangan.index', [
            'ruangan' => $ruangan,
            'title' => 'Hasil Pencarian'
        ]);
    }
}