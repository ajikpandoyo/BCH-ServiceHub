<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MediaPartner;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\MediaPartnerExport;
use Illuminate\Support\Facades\DB;

class MediaPartnerVerifikasiController extends Controller
{
    public function index(Request $request)
    {
        $query = MediaPartner::query();

        // Search functionality
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('nama_pemohon', 'like', "%{$searchTerm}%")
                ->orWhere('nama_instansi', 'like', "%{$searchTerm}%")
                ->orWhere('tema_acara', 'like', "%{$searchTerm}%");
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

       

        // Get counts for status tabs
        $countAll = MediaPartner::count();
        $countApproved = MediaPartner::where('status', 'approved')->count();
        $countPending = MediaPartner::where('status', 'pending')->count();
        $countRejected = MediaPartner::where('status', 'rejected')->count();

        $mediapartners = $query->latest()->paginate(10);

        return view('admin.verifikasi.mediapartner.index', compact(
            'mediapartners',
            'countAll',
            'countApproved',
            'countPending',
            'countRejected'
        ));
    }

    public function show($id)
    {
        $mediapartner = MediaPartner::findOrFail($id);
        return view('admin.verifikasi.mediapartner.show', compact('mediapartner'));
    }

    public function approve($id)
    {
       
        $mediapartner = MediaPartner::findOrFail($id);
        
        
        DB::transaction(function () use ($mediapartner) {
            // Update media partner status
            $mediapartner->status = 'approved';
            $mediapartner->save();

            // Update riwayat status
            DB::table('riwayat')
                ->where('pendaftaran_id', $mediapartner->id)
                ->where('jenis', 'mediapartner')
                ->update([
                    'status' => 'approved',
                    'updated_at' => now()
                ]);
        });

        return redirect()->back()->with('approved', 'Media partner berhasil disetujui');

    }

    public function reject(Request $request, $id)
    {
        $mediapartner = MediaPartner::findOrFail($id);
        
        DB::transaction(function () use ($mediapartner, $request) {
            // Update media partner status
            $mediapartner->status = 'rejected';
            $mediapartner->keterangan = $request->reason; // Changed from keterangan to reason
            $mediapartner->save();
    
            // Update riwayat status
            DB::table('riwayat')
                ->where('pendaftaran_id', $mediapartner->id)
                ->where('jenis', 'mediapartner')
                ->update([
                    'status' => 'rejected',
                    'keterangan' => $request->rejection_reason, // Add rejection reason to riwayat
                    'updated_at' => now()
                ]);
        });
    
        return redirect()->back()->with('rejected', 'Media Partner berhasil ditolak');

    }

    public function export()
    {
        $query = MediaPartner::query();

        // Apply status filter if present
        if (request()->has('status')) {
            $status = request()->status;
            if (in_array($status, ['approved', 'pending', 'rejected'])) {
                $query->where('status', $status);
            }
        }

        // Apply search filter if present
        if (request()->has('search')) {
            $search = request()->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_pemohon', 'like', "%{$search}%")
                  ->orWhere('tema_acara', 'like', "%{$search}%")
                  ->orWhere('nama_instansi', 'like', "%{$search}%");
            });
        }

        $mediaPartners = $query->latest()->get();
        
        return Excel::download(
            new MediaPartnerExport($mediaPartners), 
            'media-partners-' . date('Y-m-d') . '.xlsx'
        );
    }
}