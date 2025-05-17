<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use App\Models\KerjasamaEvent;

class KerjaSamaEventController extends Controller
{
    public function index()
    {
        $events = Event::where('status', 'akan_datang')
                      ->orderBy('tanggal_pelaksanaan', 'asc')
                      ->paginate(6);

        return view('user.kerjasama.event.index', compact('events'));
    }

    public function show($id)
    {
        $event = Event::findOrFail($id);
        return view('user.kerjasama.event.show', compact('event'));
    }

    public function register($id)
    {
        $event = Event::findOrFail($id);
        
        // Redirect ke form peminjaman event
        return redirect()->route('peminjaman.event.form', $id)
            ->with('event', $event);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_event' => 'required|string|max:255',
            'deskripsi_event' => 'required|string',
            'tanggal_pelaksanaan' => 'required|date',
            'lokasi' => 'required|string|max:255',
            'proposal' => 'required|file|mimes:pdf|max:2048',
            'nama_peserta' => 'required|string|max:255',
            'email_peserta' => 'required|email|max:255',
            'telepon_peserta' => 'required|string|max:20',
            'instansi_peserta' => 'required|string|max:255',
        ]);

        // Upload proposal
        if ($request->hasFile('proposal')) {
            $proposal = $request->file('proposal');
            $proposalPath = $proposal->store('proposals', 'public');
            $validated['proposal'] = $proposalPath;
        }

        // Tambahkan user_id jika user sudah login
        if (auth()->check()) {
            $validated['user_id'] = auth()->id();
        }

        // Simpan data ke database
        $kerjasamaEvent = KerjasamaEvent::create($validated);

        return redirect()->route('riwayat.index')
            ->with('success', 'Pendaftaran kerjasama event berhasil dikirim! Silakan pantau status pengajuan Anda di halaman riwayat.');
    }
}