<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KunjunganVisit;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB; 
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx; 

class VerifikasiKunjunganController extends Controller
{
    public function index(Request $request)
    {
            $query = KunjunganVisit::query();
           // Search functionality
            if ($request->has('search')) {
                $searchTerm = $request->search;
                $query->where(function($q) use ($searchTerm) {
                    $q->where('nama_pemohon', 'like', "%{$searchTerm}%")
                    ->orWhere('instansi', 'like', "%{$searchTerm}%")
                    ->orWhere('email', 'like', "%{$searchTerm}%");
                });
            }


            // Status filter
            if ($request->has('status')) {
                $query->where('status', $request->status);
            }

            // Filter berdasarkan tanggal
            if ($request->has('filter_date')) {
                $query->whereDate('tanggal_kunjungan', $request->filter_date);
            }
    
            $kunjungan = $query->latest()->paginate(10);
            
            // Count for each status
            $countAll = KunjunganVisit::count();
            $countPending = KunjunganVisit::where('status', 'pending')->count();
            $countApproved = KunjunganVisit::where('status', 'approved')->count();
            $countRejected =KunjunganVisit::where('status', 'rejected')->count();
    
            return view('admin.verifikasi.kunjungan.index', compact(
                'kunjungan',
                'countAll',
                'countPending',
                'countApproved',
                'countRejected'
            ));
    }

    public function approve($id)
    {
        $kunjungan = KunjunganVisit::findOrFail($id);
        $kunjungan->status = 'approved';
        $kunjungan->save();

        return redirect()->back()->with('approved', 'Pengajuan kunjungan visit berhasil disetujui');
    }
    public function reject(Request $request, $id)
    {
        $kunjungan = KunjunganVisit::findOrFail($id);
        $kunjungan->status = 'rejected';
        $kunjungan->rejection_reason= $request->rejection_reason;
        $kunjungan->save();

        return redirect()->back()->with('rejected', 'Pengajuan kunjungan visit berhasil ditolak');
    }
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:disetujui,ditolak',
            'rejection_reason' => 'required_if:status,ditolak'
        ]);

        DB::beginTransaction();
        try {
            $kunjungan = KunjunganVisit::findOrFail($id);
            $kunjungan->status = $request->status;
            $kunjungan->rejection_reason = $request->rejection_reason;
            $kunjungan->status_updated_at = now();
            $kunjungan->save();

            // Update riwayat
            $kunjungan->riwayat()->update([
                'status' => $request->status,
                'keterangan' => $request->rejection_reason,
                'updated_at' => now()
            ]);

            DB::commit();
            return back()->with('success', 'Status kunjungan berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }


    public function export(Request $request)
    {
        
        $kunjungans =KunjunganVisit::all();

        // Search functionality
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('nama_pemohon', 'like', "%{$searchTerm}%")
                ->orWhere('instansi', 'like', "%{$searchTerm}%")
                ->orWhere('email', 'like', "%{$searchTerm}%");
            });
        }


        // Status filter
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan tanggal
        if ($request->has('filter_date')) {
            $query->whereDate('tanggal_kunjungan', $request->filter_date);
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set headers
        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Nama Pemohon');
        $sheet->setCellValue('C1', 'Email');
        $sheet->setCellValue('D1', 'Instansi');
        $sheet->setCellValue('E1', 'Tanggal Kunjungan');
        $sheet->setCellValue('F1', 'Waktu Kunjungan');
        $sheet->setCellValue('G1', 'Jumlah Peserta');
        $sheet->setCellValue('H1', 'No Telepon');
        $sheet->setCellValue('I1', 'Tujuan Kunjungan');
        $sheet->setCellValue('J1', 'Tanggal Pengajuan');
        $sheet->setCellValue('K1', 'Status');

        $row = 2;
        foreach ($kunjungans as $kunjungan) {
            $sheet->setCellValue('A' . $row, $kunjungan->id);
            $sheet->setCellValue('B' . $row, $kunjungan->nama_pemohon);
            $sheet->setCellValue('C' . $row, $kunjungan->email);
            $sheet->setCellValue('D' . $row, $kunjungan->instansi);
            $sheet->setCellValue('E' . $row, $kunjungan->tanggal_kunjungan);
            $sheet->setCellValue('F' . $row, $kunjungan->waktu_kunjungan);
            $sheet->setCellValue('G' . $row, $kunjungan->jumlah_peserta);
            $sheet->setCellValue('H' . $row, $kunjungan->no_telepon);
            $sheet->setCellValue('I' . $row, $kunjungan->tujuan_kunjungan);
            $sheet->setCellValue('J' . $row, $kunjungan->tanggal_pengajuan);
            $sheet->setCellValue('K' . $row, $kunjungan->status);
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

    public function show($id)
    {
        $kunjungan = KunjunganVisit::findOrFail($id);
        return view('admin.verifikasi.kunjungan.show', compact('kunjungan'));
    }
}