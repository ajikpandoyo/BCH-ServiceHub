<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KerjasamaEvent;
use App\Exports\KerjasamaEventExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class KerjasamaEventController extends Controller
{
    public function index(Request $request)
    {
        $query = KerjasamaEvent::query();

        // Search functionality
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('nama_event', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('nama_peserta', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('email_peserta', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('instansi_peserta', 'LIKE', "%{$searchTerm}%");
            });
        }

        // Filter by status if provided
        if ($request->has('status')) {
            $status = $request->status;
            if ($status === 'approved') {
                $query->where('status', 'approved');
            } elseif ($status === 'pending') {
                $query->where('status', 'pending');
            } elseif ($status === 'rejected') {
                $query->where('status', 'rejected');
            }
        }

        $filterRuangan = $request->input('filter_ruangan');
        if (!empty($filterRuangan)) {
            $query->where('lokasi', $filterRuangan);
        }
        
         // Ambil ID ruangan yang pernah dipakai
         $usedRoomId = KerjasamaEvent::select('lokasi')->distinct()->get();


 
         // Optional: filter data berdasarkan input
         $filterRuangan = $request->input('filter_ruangan');

        // Get counts for status tabs
        $countAll = KerjasamaEvent::count();
        $countApproved = KerjasamaEvent::where('status', 'approved')->count();
        $countPending = KerjasamaEvent::where('status', 'pending')->count();
        $countRejected = KerjasamaEvent::where('status', 'rejected')->count();

        $contract = $query->latest()->paginate(10);
        
        return view('admin.kerjasama.event.index', compact(
            'contract',
            'usedRoomId',
            'filterRuangan',
            'countAll',
            'countApproved',
            'countPending',
            'countRejected'
        ));
    }

    public function approve($id)
    {
        $kerjasama = KerjasamaEvent::findOrFail($id);
        $kerjasama->status = 'approved';
        $kerjasama->save();

        return redirect()->back()->with('approved', 'Kerjasama Event berhasil disetujui');
    }

    public function reject(Request $request, $id)
    {
        $kerjasama = KerjasamaEvent::findOrFail($id);
        $kerjasama->status = 'rejected';
        $kerjasama->save();

        return redirect()->back()->with('rejected', 'Kerjasama Event berhasil ditolak');
    }


    public function create()
    {
        return view('admin.kerjasama.event.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_event' => 'required',
            'nama_lengkap' => 'required',
            'email' => 'required|email',
            'whatsapp' => 'required',
            'instansi' => 'required',
            'deskripsi_event' => 'required',
            'tanggal_pelaksanaan' => 'required|date',
            'lokasi' => 'required',
            'proposal' => 'required|file|mimes:pdf|max:2048',
        ]);

        if ($request->hasFile('proposal')) {
            $proposal = $request->file('proposal');
            $proposalPath = $proposal->store('proposals', 'public');
            $validated['proposal'] = $proposalPath;
        }

        KerjasamaEvent::create($validated);

        return redirect()->route('admin.kerjasama.event.index')
            ->with('success', 'Event berhasil ditambahkan');
    }

    public function show($id)
    {
        $event = KerjasamaEvent::findOrFail($id);
        return view('admin.kerjasama.event.show', compact('event'));
    }

    public function edit($id)
    {
        $event = KerjasamaEvent::findOrFail($id);
        return view('admin.kerjasama.event.edit', compact('event'));
    }

    public function update(Request $request, $id)
    {
        $event = KerjasamaEvent::findOrFail($id);
        
        $validated = $request->validate([
            'nama_event' => 'required',
            'nama_lengkap' => 'required',
            'email' => 'required|email',
            'whatsapp' => 'required',
            'instansi' => 'required',
            'deskripsi_event' => 'required',
            'tanggal_pelaksanaan' => 'required|date',
            'lokasi' => 'required',
            'proposal' => 'nullable|file|mimes:pdf|max:2048',
        ]);

        if ($request->hasFile('proposal')) {
            $proposal = $request->file('proposal');
            $proposalPath = $proposal->store('proposals', 'public');
            $validated['proposal'] = $proposalPath;
        }

        $event->update($validated);

        return redirect()->route('admin.kerjasama.event.index')
            ->with('success', 'Event berhasil diperbarui');
    }

    public function destroy($id)
    {
        $event = KerjasamaEvent::findOrFail($id);
        $event->delete();

        return redirect()->route('admin.kerjasama.event.index')
            ->with('success', 'Event berhasil dihapus');
    }

    public function export(Request $request)
    {
        $query = KerjasamaEvent::all();

        // Search functionality
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('nama_event', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('nama_peserta', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('email_peserta', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('instansi_peserta', 'LIKE', "%{$searchTerm}%");
            });
        }

        // Filter by status if provided
        if ($request->has('status')) {
            $status = $request->status;
            if ($status === 'approved') {
                $query->where('status', 'approved');
            } elseif ($status === 'pending') {
                $query->where('status', 'pending');
            } elseif ($status === 'rejected') {
                $query->where('status', 'rejected');
            }
        }
        return Excel::download(
            new KerjasamaEventExport($query), 
            'media-partners-' . date('Y-m-d') . '.xlsx'
        );
    }
}