<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\MediaPartner;
use Illuminate\Http\Request;

class MediaPartnerController extends Controller
{
    public function create()
    {
        $categories = [
            'Film & Animasi',
            'Aplikasi & Game Developer',
            'Arsitektur',
            'Desain Interior',
            'Desain Komunikasi Visual',
            'Fashion',
            'Kerajinan',
            'Kuliner',
            'Musik',
            'Penerbitan',
            'Periklanan',
            'Seni Pertunjukan',
            'Seni Rupa',
            'Televisi & Radio'
        ];

        return view('user.mediapartner.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pemohon' => 'required',
            'email' => 'required|email',
            'instansi' => 'required',
            'instagram' => 'required',
            'website' => 'nullable|url',
            'tema_acara' => 'required',
            'kategori' => 'required',
            'tanggal_acara' => 'required|date',
            'pic_nama' => 'required',
            'pic_whatsapp' => 'required',
            'surat_pengajuan' => 'required|file|mimes:pdf|max:5120',
        ]);
    
        // Handle file upload
        $suratPath = $request->file('surat_pengajuan')->store('media-partner/surat', 'public');
    
        // Create media partner entry
        $mediaPartner = MediaPartner::create([
            'user_id' => auth()->id(),
            'nama_pemohon' => $request->nama_pemohon,
            'email' => $request->email,
            'nama_instansi' => $request->instansi,
            'instagram' => $request->instagram,
            'website' => $request->website,
            'tema_acara' => $request->tema_acara,
            'kategori_subsektor' => $request->kategori,
            'tanggal_acara' => $request->tanggal_acara,
            'pic_nama' => $request->pic_nama,
            'pic_whatsapp' => $request->pic_whatsapp,
            'surat_pengajuan' => $suratPath,
            'status' => 'pending'
        ]);
    
        // Create riwayat entry
        \DB::table('riwayat')->insert([
            'user_id' => auth()->id(),
            'pendaftaran_id' => $mediaPartner->id,
            'jenis' => 'mediapartner',
            'status' => 'pending',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    
        return redirect()->route('riwayat.index')
            ->with('success', [
                'title' => 'Pengajuan Berhasil!',
                'message' => 'Data Media Partner Anda telah berhasil disimpan.'
            ]);
    }
}