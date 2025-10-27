<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ruangan; // ✅ model yang benar
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class RuanganController extends Controller
{
    public function index(Request $request)
    {
        $query = Ruangan::query();

        if ($request->filled('search')) {
            $keyword = '%' . $request->search . '%';
            $query
                ->where('nama_ruangan', 'like', $keyword)
                ->orWhere('lokasi', 'like', $keyword)
                ->orWhere('fasilitas', 'like', $keyword);
        }

        $ruangan = $query->latest()->get();

        return view('user.ruangan.index', compact('ruangan'));
    }

    public function show($id)
    {
        $ruangan = Ruangan::findOrFail($id); // ✅ ganti KelolaRuangan jadi Ruangan
        return view('user.ruangan.show', [
            'ruangan' => $ruangan,
            'title' => $ruangan->nama_ruangan
        ]);
    }

    public function filterByLantai($lantai)
    {
        $ruangan = Ruangan::where('lokasi', 'LIKE', '%Lantai ' . $lantai . '%')->get(); // ✅ juga diganti
        return response()->json($ruangan);
    }

    public function search(Request $request)
    {
        $search = $request->get('search');
        
        $ruangan = Ruangan::where('nama_ruangan', 'like', "%{$search}%")
            ->orWhere('lokasi', 'like', "%{$search}%")
            ->orWhere('fasilitas', 'like', "%{$search}%")
            ->get();

        return view('user.ruangan.index', [
            'ruangan' => $ruangan,
            'title' => 'Hasil Pencarian'
        ]);
    }
}
