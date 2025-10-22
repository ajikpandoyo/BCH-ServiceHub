<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\PendaftaranEvent;
use App\Models\Riwayat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class PendaftaranEventController extends Controller
{
    public function index()
    {
        $events = Event::where('status', 'akan_datang')
                      ->orderBy('tanggal_pelaksanaan', 'asc')
                      ->paginate(9);
        
        return view('user.pendaftaran.event.index', compact('events'));
    }

    public function cari(Request $request)
    {
        $query = Event::where('status', 'akan_datang');

        if ($request->filled('search')) {
            $query->where('nama_event', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal_pelaksanaan', $request->tanggal);
        }

        $events = $query->orderBy('tanggal_pelaksanaan', 'asc')->paginate(9);

        return view('user.pendaftaran.event.index', compact('events'));
    }

    public function form($id)
    {
        $event = Event::findOrFail($id);
        return view('user.pendaftaran.event.form', compact('event'));
    }

    public function show($id)
    {
        $event = Event::findOrFail($id);
        return view('user.pendaftaran.event.show', compact('event'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'event_id' => 'required|exists:events,id',
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|email',
            'no_telepon' => 'required|string',
            'instansi' => 'required|string|max:255',
        ]);
    
        // Cek apakah user sudah mendaftar di event ini
        $sudahDaftar = PendaftaranEvent::where('user_id', auth()->id())
            ->where('event_id', $validated['event_id'])
            ->exists();

        if ($sudahDaftar) {
            return redirect()->route('riwayat.index')
                ->with('warning', 'Anda sudah terdaftar di event ini. Silakan cek status pendaftaran Anda di halaman riwayat.');
        }
    
        $pendaftaran = PendaftaranEvent::create([
            'event_id' => $validated['event_id'],
            'user_id' => auth()->id(),
            'nama_lengkap' => $validated['nama_lengkap'],
            'email' => $validated['email'],
            'no_telepon' => $validated['no_telepon'],
            'instansi' => $validated['instansi'],
            'status' => 'pending'
        ]);
    
        return redirect()->route('riwayat.index')
            ->with('success', 'Pendaftaran event berhasil! Silakan pantau status pendaftaran Anda di halaman riwayat.');
    }
}