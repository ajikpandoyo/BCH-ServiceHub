<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\PeminjamanEvent;

class PeminjamanEventController extends Controller
{
    public function form($id)
    {
        $event = DB::table('events')->find($id);
        
        if (!$event) {
            return redirect()->route('kerjasama.event.index')
                ->with('error', 'Event tidak ditemukan');
        }

        return view('user.peminjaman.event.form', compact('event'));
    }

    public function store(Request $request)
    {
        // Add validation
        $validated = $request->validate([
            'nama_lengkap' => 'required',
            'alamat' => 'required',
            'whatsapp' => 'required',
            'instagram' => 'required',
            'sumber_informasi' => 'required',
            'bukti_follow' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'alasan' => 'required',
            'kategori' => 'required',
            'persetujuan' => 'required',
            'event_id' => 'required|exists:events,id'
        ]);
    
        // Get authenticated user ID
        $user_id = auth()->id();
        
        if (!$user_id) {
            return redirect()->back()
                ->with('error', 'Anda harus login terlebih dahulu')
                ->withInput();
        }
    
        // Handle file upload
        if ($request->hasFile('bukti_follow')) {
            $file = $request->file('bukti_follow');
            $filename = $file->storeAs('screening', $file->hashName(), 'public');
            $validated['bukti_follow'] = $filename;
        }
    
        // Add user_id to validated data
        $validated['user_id'] = $user_id;
    
        // Create the registration
        PendaftaranEvent::create($validated);
    
        return redirect()->route('riwayat.index')
            ->with('success', 'Pendaftaran event berhasil! Silakan pantau status pendaftaran Anda di halaman riwayat.');
    }

    public function detail($id)
    {
        $peminjaman = DB::table('pendaftaran_events')  // Changed variable name from $pendaftaran to $peminjaman
            ->select(
                'pendaftaran_events.*',
                'events.nama_event',
                'events.tanggal_pelaksanaan as tanggal',
                'events.waktu',
                'events.lokasi_ruangan',
                'users.name as user_name',
                'pendaftaran_events.alasan as tema_acara',
                'pendaftaran_events.created_at as waktu_loading',
                DB::raw("'pending' as status")
            )
            ->join('events', 'pendaftaran_events.event_id', '=', 'events.id')
            ->join('users', 'pendaftaran_events.user_id', '=', 'users.id')
            ->where('pendaftaran_events.id', $id)
            ->first();

        return view('user.peminjaman.event.detail', compact('peminjaman'));
    }
}