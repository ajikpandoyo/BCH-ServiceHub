<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class KunjunganVisitController extends Controller
{
    public function create()
    {
        return view('user.kunjungan.visit.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pemohon' => 'required|string',
            'email' => 'required|email',
            'instansi' => 'required|string',
            'tanggal_kunjungan' => 'required|date',
            'waktu_kunjungan' => 'required',
            'jumlah_peserta' => 'required|integer',
            'telepon' => 'required|string',
            'tujuan' => 'required|string',
            'proposal' => 'required|file|mimes:pdf|max:2048'
        ]);
    
        try {
            DB::beginTransaction();
    
            // Handle file upload
            $proposalPath = $request->file('proposal')->store('public/proposals');
    
            // Insert into kunjungan_visits table
            $kunjungan = DB::table('kunjungan_visits')->insertGetId([
                'user_id' => auth()->id(), // Tambahkan user_id
                'nama_pemohon' => $request->nama_pemohon,
                'email' => $request->email,
                'instansi' => $request->instansi,
                'tanggal_kunjungan' => $request->tanggal_kunjungan,
                'waktu_kunjungan' => $request->waktu_kunjungan,
                'jumlah_peserta' => $request->jumlah_peserta,
                'no_telepon' => $request->telepon,
                'tujuan_kunjungan' => $request->tujuan,
                'proposal_path' => $proposalPath,
                'status' => 'pending',
                'created_at' => now(),
                'updated_at' => now()
            ]);
    
            // Tambahkan ke tabel riwayat
            DB::table('riwayat')->insert([
                'user_id' => auth()->id(),
                'pendaftaran_type' => 'KunjunganVisit',
                'pendaftaran_id' => $kunjungan,
                'jenis_aktivitas' => 'Kunjungan Visit',
                'nama_kegiatan' => $request->tujuan,
                'tanggal' => $request->tanggal_kunjungan,
                'status' => 'pending',
                'created_at' => now(),
                'updated_at' => now()
            ]);
    
            DB::commit();
    
            return redirect()->route('riwayat.index')->with('success', 'Pengajuan kunjungan visit berhasil! Silakan cek status di halaman riwayat.');
    
        } catch (\Exception $e) {
            DB::rollback();
            Storage::delete($proposalPath); // Hapus file jika gagal
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }
}