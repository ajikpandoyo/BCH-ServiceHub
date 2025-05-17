<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PendaftaranEvent;
use App\Models\Riwayat;
use App\Models\Event;
use Illuminate\Http\Request;
use App\Exports\PendaftaranEventExport;
use Maatwebsite\Excel\Facades\Excel;

class PendaftaranEventController extends Controller
{
    public function index(Request $request)
    {
        $query = PendaftaranEvent::with(['event', 'user']);

        // Search functionality
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('nama_lengkap', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('email', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('instansi', 'LIKE', "%{$searchTerm}%");
            });
        }

        // Filter berdasarkan status
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $pendaftaran= $query->latest()->paginate(10);

        // Ambil ID event yang pernah dipakai
        $usedEventIds = PendaftaranEvent::distinct()->pluck('event_id');

        // Ambil data event lengkap dari tabel kelola_ruangan
        $eventList = Event::whereIn('id', $usedEventIds)->get();

         // Optional: filter data berdasarkan input
         $filterEvent = $request->input('filter_event');

        return view('admin.pendaftaran.event.index', compact('pendaftaran', 'eventList', 'filterEvent'));
    }


    public function show($id)
    {
        $pendaftaran = PendaftaranEvent::with(['event', 'user'])->findOrFail($id);
        return view('admin.pendaftaran.event.show', compact('pendaftaran'));
    }

    public function update(Request $request, $id)
    {
        $pendaftaran = PendaftaranEvent::findOrFail($id);
        $pendaftaran->status = $request->status;
        $pendaftaran->save();

        return back()->with('success', 'Status pendaftaran berhasil diperbarui');
    }

    public function export(Request $request)
    {
        $status = $request->query('status');
        $filename = 'pendaftaran-event-' . ($status ?? 'semua') . '-' . date('Y-m-d') . '.xlsx';
        
        return Excel::download(new PendaftaranEventExport($status), $filename);
    }
}