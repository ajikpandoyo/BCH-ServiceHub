<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PeminjamanRuangan;
use Illuminate\Http\Request;

class PeminjamanRuanganController extends Controller
{
    public function index(Request $request)
    {
        $query = PeminjamanRuangan::with(['ruangan', 'user']);

        // Search functionality
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('nama_peminjam', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('email_peminjam', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('instansi_peminjam', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('kegiatan', 'LIKE', "%{$searchTerm}%");
            });
        }

        // Filter berdasarkan status
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $peminjamans = $query->latest()->paginate(10);
        return view('admin.peminjaman.ruangan.index', compact('peminjamans'));
    }

    public function show($id)
    {
        $peminjaman = PeminjamanRuangan::with(['ruangan', 'user'])->findOrFail($id);
        return view('admin.peminjaman.ruangan.show', compact('peminjaman'));
    }

    public function update(Request $request, $id)
    {
        $peminjaman = PeminjamanRuangan::findOrFail($id);
        
        $validated = $request->validate([
            'status' => 'required|in:pending,approved,rejected',
            'catatan' => 'nullable|string',
        ]);

        $peminjaman->update($validated);

        return redirect()->route('admin.peminjaman.ruangan.index')
            ->with('success', 'Status peminjaman berhasil diperbarui');
    }

    public function destroy($id)
    {
        $peminjaman = PeminjamanRuangan::findOrFail($id);
        $peminjaman->delete();

        return redirect()->route('admin.peminjaman.ruangan.index')
            ->with('success', 'Data peminjaman berhasil dihapus');
    }
} 