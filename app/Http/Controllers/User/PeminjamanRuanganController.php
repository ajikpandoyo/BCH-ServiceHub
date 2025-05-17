<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\PeminjamanRuangan;
use App\Models\Ruangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PeminjamanRuanganController extends Controller
{
    public function create()
    {
        $ruangans = Ruangan::all();
        return view('user.peminjaman.ruangan.create', compact('ruangans'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'ruangan_id' => 'required|exists:kelola_ruangan,id',
            'nama_peminjam' => 'required|string|max:255',
            'email_peminjam' => 'required|email|max:255',
            'telepon_peminjam' => 'required|string|max:20',
            'instansi_peminjam' => 'required|string|max:255',
            'kegiatan' => 'required|string|max:255',
            'deskripsi_kegiatan' => 'required|string',
            'tanggal_peminjaman' => 'required|date',
            'waktu_mulai' => 'required',
            'waktu_selesai' => 'required',
            'jumlah_peserta' => 'required|integer|min:1',
            'surat_peminjaman' => 'required|file|mimes:pdf|max:2048',
        ]);

        // Upload surat peminjaman
        if ($request->hasFile('surat_peminjaman')) {
            $surat = $request->file('surat_peminjaman');
            $suratPath = $surat->store('surat_peminjaman', 'public');
            $validated['surat_peminjaman'] = $suratPath;
        }

        // Tambahkan user_id
        $validated['user_id'] = auth()->id();

        // Simpan data peminjaman
        PeminjamanRuangan::create($validated);

        return redirect()->route('peminjaman.ruangan.index')
            ->with('success', 'Pengajuan peminjaman ruangan berhasil dikirim. Silakan tunggu konfirmasi dari admin.');
    }

    public function index()
    {
        $peminjamans = PeminjamanRuangan::where('user_id', auth()->id())
            ->latest()
            ->paginate(10);
            
        return view('user.peminjaman.ruangan.index', compact('peminjamans'));
    }

    public function show($id)
    {
        $peminjaman = PeminjamanRuangan::where('user_id', auth()->id())
            ->findOrFail($id);
            
        return view('user.peminjaman.ruangan.show', compact('peminjaman'));
    }

    public function riwayat()
    {
        $peminjaman = PeminjamanRuangan::where('user_id', Auth::id())
            ->with('ruangan')
            ->orderBy('created_at', 'desc')
            ->get();
    
        return view('user.peminjaman.riwayat', compact('peminjaman'));
    }
}