<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KunjunganVisit;

class KunjunganVerifikasiController extends Controller
{
    public function index(Request $request)
    {
        
        $query = KunjunganVisit::query()
            ->with('user') // Load relasi user
            ->select('id', 'user_id', 'nama_pemohon', 'instansi', 'tanggal_kunjungan', 
                     'jumlah_peserta', 'tujuan_kunjungan', 'status', 'created_at');
    
        // Filter berdasarkan tanggal
        if ($request->has('filter_date')) {
            $query->whereDate('tanggal_kunjungan', $request->filter_date);
        }
    
        // Filter berdasarkan status
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }
    
        $kunjungan = $query->orderBy('created_at', 'desc')->paginate(10);

        
        return view('admin.verifikasi.kunjungan.index', compact('kunjungan'));
    }

    public function updateStatus(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $kunjungan = KunjunganVisit::findOrFail($id);
            $kunjungan->status = $request->status;
            $kunjungan->save();
    
            // Update status di tabel riwayat
            DB::table('riwayat')
                ->where('pendaftaran_type', 'KunjunganVisit')
                ->where('pendaftaran_id', $id)
                ->update([
                    'status' => $request->status,
                    'updated_at' => now()
                ]);
    
            DB::commit();
            return back()->with('success', 'Status kunjungan berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}