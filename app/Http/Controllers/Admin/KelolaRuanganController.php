<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KelolaRuangan;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Http\Response;

class KelolaRuanganController extends Controller
{
    public function index(Request $request)
    {
        $query = KelolaRuangan::query();
    
        // Filter berdasarkan pencarian
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_ruangan', 'LIKE', "%{$search}%")
                  ->orWhere('lokasi', 'LIKE', "%{$search}%")
                  ->orWhere('fasilitas', 'LIKE', "%{$search}%");
            });
        }
    
        // Filter berdasarkan lantai
        if ($request->has('lantai')) {
            $query->where('lokasi', 'LIKE', "%Lantai " . substr($request->lantai, -1) . "%");
        }
    
        $ruangans = $query->orderBy('id', 'asc')->paginate(10);
        
        // Get counts for each floor
        $countAll = KelolaRuangan::count();
        $countLantai1 = KelolaRuangan::where('lokasi', 'like', '%Lantai 1%')->count();
        $countLantai2 = KelolaRuangan::where('lokasi', 'like', '%Lantai 2%')->count();
        $countLantai3 = KelolaRuangan::where('lokasi', 'like', '%Lantai 3%')->count();
        $countLantai4 = KelolaRuangan::where('lokasi', 'like', '%Lantai 4%')->count();
        $countLantai5 = KelolaRuangan::where('lokasi', 'like', '%Lantai 5%')->count();
    
        
    
        return view('admin.kelola.ruangan.index', compact(
            'ruangans',
            'countAll',
            'countLantai1',
            'countLantai2',
            'countLantai3',
            'countLantai4',
            'countLantai5'
        ));
    }

    public function create()
    {
        return view('admin.kelola.ruangan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_ruangan' => 'required|string|max:255',
            'kapasitas' => 'required|integer',
            'lokasi' => 'required|string',
            'fasilitas' => 'required|string',
            'jam_operasional' => 'required|string',
            'gambar' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);
    
        if ($request->hasFile('gambar')) {
            $gambar = $request->file('gambar');
            $nama_gambar = time() . '.' . $gambar->getClientOriginalExtension();
            $gambar->storeAs('public/images/ruangan', $nama_gambar);
            $validated['gambar'] = $nama_gambar;
        }

        // Simpan sesi
        if ($request->has('sesi')) {
            foreach ($request->sesi as $sesi) {
                if (!empty($sesi['nama_sesi']) && !empty($sesi['jam_mulai']) && !empty($sesi['jam_selesai'])) {
                    SesiRuangan::create([
                        'kelola_ruangan_id' => $ruangan->id,
                        'nama_sesi' => $sesi['nama_sesi'],
                        'jam_mulai' => $sesi['jam_mulai'],
                        'jam_selesai' => $sesi['jam_selesai'],
                    ]);
                }
            }
        }

        // Ekstrak nomor lantai dari lokasi
        preg_match('/Lantai (\d+)/', $request->lokasi, $matches);
        $lantai = $matches[1] ?? 1; // Default ke lantai 1 jika tidak ditemukan
    
        // Tambahkan field yang diperlukan
        $validated['lantai'] = $lantai;
        $validated['status'] = 'Tersedia'; // Set default status
    
        KelolaRuangan::create($validated);
    
        return redirect()->route('admin.kelola.ruangan.index')->with('added', 'Ruangan berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_ruangan' => 'required|string|max:255',
            'kapasitas' => 'required|integer',
            'lokasi' => 'required|string',
            'fasilitas' => 'required|string',
            'jam_operasional' => 'required|string',
        ]);

        $ruangan = KelolaRuangan::findOrFail($id);
        $ruangan->update($validated);

        return redirect()->route('admin.kelola.ruangan.index')
            ->with('success', 'Ruangan berhasil diperbarui')
            ->with('showNotification', true);
    }

    public function destroy($id)
    {
        try {
            $ruangan = KelolaRuangan::findOrFail($id);
            
            // Check for existing peminjaman
            if ($ruangan->peminjaman()->exists()) {
                return back()->with('error', 'Ruangan tidak dapat dihapus karena masih memiliki peminjaman terkait.');
            }

            $ruangan->delete();
            return redirect()->route('admin.kelola.ruangan.index')
                ->with('deleted', 'Ruangan berhasil dihapus.');
                
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat menghapus ruangan.');
        }
    }

    // Remove the separate search method since we've integrated it into index
    public function search(Request $request)
    {
        return $this->index($request);
    }

    public function filterByLantai($lantai)
    {
        $ruangan = KelolaRuangan::where('lokasi', $lantai)->get();
        return response()->json($ruangan);
    }

    public function show($id)
    {
        $ruangan = KelolaRuangan::findOrFail($id);
        $peminjaman = PeminjamanRuangan::where('ruangan_id', $id)->get();  // Add this line
        return view('admin.kelola.ruangan.show', compact('ruangan', 'peminjaman'));  // Update this line
    }

    public function edit($id)
    {
        $ruangan = KelolaRuangan::findOrFail($id)->load('sesi');
        return view('admin.kelola.ruangan.edit', compact('ruangan'));
    }

    public function export()
    {
        $ruangans = KelolaRuangan::all();

        // Filter berdasarkan pencarian
        if ($request->has('search')) {
            $search = $request->search;
            $ruangans->where(function($q) use ($search) {
                $q->where('nama_ruangan', 'LIKE', "%{$search}%")
                  ->orWhere('lokasi', 'LIKE', "%{$search}%")
                  ->orWhere('fasilitas', 'LIKE', "%{$search}%");
            });
        }
    
        // Filter berdasarkan lantai
        if ($request->has('lantai')) {
            $ruangans->where('lokasi', 'LIKE', "%Lantai " . substr($request->lantai, -1) . "%");
        }
        
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set headers
        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'NAMA RUANGAN');
        $sheet->setCellValue('C1', 'KAPASITAS');
        $sheet->setCellValue('D1', 'LOKASI');
        $sheet->setCellValue('E1', 'LANTAI');
        $sheet->setCellValue('F1', 'FASILITAS');
        $sheet->setCellValue('G1', 'JAM OPERASIONAL');
        $sheet->setCellValue('H1', 'STATUS');

        $row = 2;
        foreach ($ruangans as $ruangan) {
            $sheet->setCellValue('A' . $row, $ruangan->id);
            $sheet->setCellValue('B' . $row, $ruangan->nama_ruangan);
            $sheet->setCellValue('C' . $row, $ruangan->kapasitas);
            $sheet->setCellValue('D' . $row, $ruangan->lokasi);
            $sheet->setCellValue('E' . $row, $ruangan->lantai);
            $sheet->setCellValue('F' . $row, $ruangan->fasilitas);
            $sheet->setCellValue('G' . $row, $ruangan->jam_operasional);
            $sheet->setCellValue('H' . $row, $ruangan->status);
            $row++;
        }

        $writer = new Xlsx($spreadsheet);
        
        $filename = 'daftar_ruangan_' . date('Y-m-d') . '.xlsx';
        
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        
        $writer->save('php://output');
        exit;
    }
}