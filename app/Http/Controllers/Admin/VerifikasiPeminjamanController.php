<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PeminjamanRuangan;  
use App\Models\KelolaRuangan;
use App\Imports\PeminjamanRuanganImport;  
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Maatwebsite\Excel\Facades\Excel;

class VerifikasiPeminjamanController extends Controller
{
    public function index(Request $request)
    {
        $query = PeminjamanRuangan::with(['user', 'ruangan']);

        // Search functionality
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('nama_peminjam', 'like', "%{$searchTerm}%")
                  ->orWhere('kegiatan', 'like', "%{$searchTerm}%")
                  ->orWhere('email_peminjam', 'like', "%{$searchTerm}%")
                  ->orWhereHas('ruangan', function($q) use ($searchTerm) {
                      $q->where('nama_ruangan', 'like', "%{$searchTerm}%");
                  });
            });
        }

        // Status filter
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        // Filter ruangan
        if ($request->filled('filter_ruangan')) {
            $query->where('ruangan_id', $request->filter_ruangan);
        }

        $peminjaman = $query->latest()->paginate(10);

        // // Ambil ID ruangan yang pernah dipakai
        // $usedRoomIds = PeminjamanRuangan::distinct()->pluck('ruangan_id');

        // Ambil data ruangan lengkap dari tabel kelola_ruangan
        // $ruanganList = KelolaRuangan::whereIn('id', $usedRoomIds)->get();
        $ruanganList = KelolaRuangan::all();

        // Optional: filter data berdasarkan input
        $filterRuangan = $request->input('filter_ruangan');
        
        // Count for each status
        $countAll = PeminjamanRuangan::count();
        $countPending = PeminjamanRuangan::where('status', 'pending')->count();
        $countApproved = PeminjamanRuangan::where('status', 'approved')->count();
        $countRejected = PeminjamanRuangan::where('status', 'rejected')->count();

        return view('admin.verifikasi.peminjaman.index', compact(
            'peminjaman',
            'ruanganList',
            'filterRuangan',
            'countAll',
            'countPending',
            'countApproved',
            'countRejected'
        ));
    }

    public function show($id)
    {
        $peminjaman = PeminjamanRuangan::with(['user', 'ruangan'])->findOrFail($id);
        return view('admin.verifikasi.peminjaman.show', compact('peminjaman'));
    }

    

    public function create()
    {
        return view('admin.verifikasi.peminjaman.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'ruangan_id' => 'required|exists:kelola_ruangan,id',
            'nama_peminjam' => 'required|string|max:255',
            'telepon_peminjam' => 'required|string|max:20',
            'instansi_peminjam' => 'required|string|max:255',
            'kegiatan' => 'required|string|max:255',
            'deskripsi_kegiatan' => 'required|string',
            'tanggal_peminjaman' => 'required|date',
            'waktu_mulai' => 'required',
            'waktu_selesai' => 'required',
            'jumlah_peserta' => 'required|integer|min:1',
            'surat_peminjaman' => 'required|file|mimes:pdf|max:2048',
        ]);
    
        if ($request->hasFile('surat_peminjaman')) {
            $surat = $request->file('surat_peminjaman');
            $suratPath = $surat->store('surat_peminjaman', 'public');
            $validated['surat_peminjaman'] = $suratPath;
        }

        // Ekstrak nomor lantai dari lokasi
        preg_match('/Lantai (\d+)/', $request->lokasi, $matches);
        $lantai = $matches[1] ?? 1; // Default ke lantai 1 jika tidak ditemukan
    
        // Tambahkan field yang diperlukan
        $validated['lantai'] = $lantai;
    
        PeminjamanRuangan::create($validated);
    
        return redirect()->route('admin.verifikasi.peminjaman.index')->with('success', 'Ruangan berhasil ditambahkan');
    }

    public function approve($id)
    {
        $peminjaman = PeminjamanRuangan::findOrFail($id);
        $peminjaman->status = 'approved';
        $peminjaman->save();

        return redirect()->back()->with('approved', 'Peminjaman ruangan berhasil disetujui');
    }

    public function reject(Request $request, $id)
    {
        $peminjaman = PeminjamanRuangan::findOrFail($id);
        $peminjaman->status = 'rejected';
        $peminjaman->rejection_reason = $request->rejection_reason;
        $peminjaman->save();

        return redirect()->back()->with('rejected', 'Peminjaman ruangan berhasil ditolak');
    }

    public function downloadDokumen($id, $type)
    {
        $peminjaman = PeminjamanRuangan::findOrFail($id);
        
        $file = match($type) {
            'surat' => $peminjaman->surat_pengajuan,
            'ktp' => $peminjaman->ktp,
            'screening' => $peminjaman->screening_file,
            default => abort(404)
        };
    
        // Add debug logging
        \Log::info('Attempting to download file:', [
            'type' => $type,
            'file_path' => $file,
            'exists' => Storage::disk('public')->exists($file)
        ]);
    
        if (!$file || !Storage::disk('public')->exists($file)) {
            abort(404, 'File tidak ditemukan');
        }
    
        return Storage::disk('public')->download($file);
    }

    public function download($id)
    {
        $peminjaman = Peminjaman::findOrFail($id); // Sesuaikan dengan model kamu

        // Misal: file proposal disimpan di storage/app/proposals/
        $path = storage_path('app/proposals/' . $peminjaman->proposal_file);

        if (!file_exists($path)) {
            abort(404, 'File not found.');
        }

        return response()->download($path);
    }

    public function showImportForm()
    {
        return view('admin.verifikasi.peminjaman.import');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);
    
        $path = $request->file('file')->store('uploads', 'public');
         // Ambil user_id terakhir yang ada di tabel peminjaman_ruangan
         $lastUserId = \DB::table('peminjaman_ruangan')->max('user_id') ?? 0;

        try {
            Excel::import(new PeminjamanRuanganImport($lastUserId), $request->file('file'));
        } catch (\Exception $e) {
            \Log::error('Gagal import: ' . $e->getMessage());
            return back()->with('error', 'Import gagal: ' . $e->getMessage());
        }
    
        return redirect()->route('admin.verifikasi.peminjaman.index')->with('import', 'Data berhasil diimport');
    }

    public function storeBulk(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xls,xlsx,csv',
        ]);

        $file = $request->file('file');

        $data = Excel::toArray([], $file);

        foreach ($data[0] as $index => $row) {
            if ($index == 0) continue; // Skip header

            PeminjamanRuangan::create([
                'ruangan_id'         => $row[0],
                'user_id'            => $row[1],
                'nama_peminjam'      => $row[2],
                'email_peminjam'     => $row[3],
                'telepon_peminjam'   => $row[4],
                'instansi_peminjam'  => $row[5],
                'kegiatan'           => $row[6],
                'deskripsi_kegiatan' => $row[7],
                'tanggal_peminjaman' => $row[8],
                'waktu_mulai'        => $row[9],
                'waktu_selesai'      => $row[10],
                'jumlah_peserta'     => $row[11],
                'status'             => 'pending',
            ]);
        }

        return redirect()->route('admin.verifikasi.peminjaman.index')->with('success', 'Data berhasil diupload!');
    }

    public function export(Request $request)
    {
        $query = PeminjamanRuangan::with(['ruangan']);
        
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('nama_peminjam', 'like', "%{$searchTerm}%")
                  ->orWhere('kegiatan', 'like', "%{$searchTerm}%")
                  ->orWhere('email_peminjam', 'like', "%{$searchTerm}%")
                  ->orWhereHas('ruangan', function($q) use ($searchTerm) {
                      $q->where('nama_ruangan', 'like', "%{$searchTerm}%");
                  });
            });
        }
        // Status filter
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        // Filter ruangan
        if ($request->filled('filter_ruangan')) {
            $query->where('ruangan_id', $request->filter_ruangan);
        }

        $peminjamans = $query->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set headers
        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Nama Peminjam');
        $sheet->setCellValue('C1', 'Email');
        $sheet->setCellValue('D1', 'Telepon');
        $sheet->setCellValue('E1', 'Instansi');
        $sheet->setCellValue('F1', 'Ruangan');
        $sheet->setCellValue('G1', 'Kegiatan');
        $sheet->setCellValue('H1', 'Tanggal Peminjaman');
        $sheet->setCellValue('I1', 'Waktu Mulai');
        $sheet->setCellValue('J1', 'Waktu Selesai');
        $sheet->setCellValue('K1', 'STATUS');

        $row = 2;
        foreach ($peminjamans as $peminjaman) {
            $sheet->setCellValue('A' . $row, $peminjaman->id);
            $sheet->setCellValue('B' . $row, $peminjaman->nama_peminjam);
            $sheet->setCellValue('C' . $row, $peminjaman->email_peminjam);
            $sheet->setCellValue('D' . $row, $peminjaman->telepon_peminjam);
            $sheet->setCellValue('E' . $row, $peminjaman->instansi_peminjam);
            $sheet->setCellValue('F' . $row, $peminjaman->ruangan->nama_ruangan ?? '-');
            $sheet->setCellValue('G' . $row, $peminjaman->kegiatan);
            $sheet->setCellValue('H' . $row, $peminjaman->tanggal_peminjaman);
            $sheet->setCellValue('I' . $row, $peminjaman->waktu_mulai);
            $sheet->setCellValue('J' . $row, $peminjaman->waktu_selesai);
            $sheet->setCellValue('K' . $row, $peminjaman->status);
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