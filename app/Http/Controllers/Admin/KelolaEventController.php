<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;  // Add this line
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class KelolaEventController extends Controller
{
    public function index(Request $request)
    {
        $query = Event::query();

        // Filter berdasarkan pencarian
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_event', 'LIKE', "%{$search}%")
                  ->orWhere('penyelenggara', 'LIKE', "%{$search}%");
            });
        }

        // Filter berdasarkan status
        if ($request->has('status') && in_array($request->status, ['berlangsung', 'akan_datang', 'selesai'])) {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan tanggal
        if ($request->has('filter_date')) {
            $query->whereDate('tanggal_pelaksanaan', $request->filter_date);
        }

        $events = $query->orderBy('created_at', 'desc')->paginate(10);

        // Hitung jumlah untuk badge tab
        $countAll = Event::count();
        $countBerlangsung = Event::where('status', 'berlangsung')->count();
        $countAkanDatang = Event::where('status', 'akan_datang')->count();
        $countSelesai = Event::where('status', 'selesai')->count();

        return view('admin.kelola.event.index', compact(
            'events',
            'countAll',
            'countBerlangsung',
            'countAkanDatang',
            'countSelesai'
        ));
    }

    public function create()
    {
        return view('admin.kelola.event.create');
    }
    // Di KelolaEventController.php, method store:

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_event' => 'required',
            'penyelenggara' => 'required',
            'tanggal_pelaksanaan' => 'required|date',
            'waktu' => 'required',
            'lokasi_ruangan' => 'required',
            'deskripsi' => 'nullable',
            'poster' => 'nullable|image|mimes:jpg,png',
        ]);

        // proses upload poster jika ada
        if ($request->hasFile('poster')) {
            $validated['poster'] = $request->file('poster')->store('posters', 'public');
        }

    
        $validated['status'] = 'akan_datang'; // sesuaikan dengan nilai yang diizinkan di database

        Event::create($validated);

        return redirect()->route('admin.kelola.event.index')
            ->with('added', 'Event berhasil ditambahkan!');
    }

    public function show(Event $event)
    {
        return view('admin.kelola.event.show', compact('event'));
    }

    public function edit(Event $event)
    {
        return view('admin.kelola.event.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'nama_event' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'waktu' => 'required',
            'penyelenggara' => 'required|string',
            'lokasi_ruangan' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        if ($request->hasFile('image')) {
            // Delete old image
            if ($event->image) {
                Storage::disk('public')->delete($event->image);
            }
            
            // Upload new image
            $validated['image'] = $request->file('image')->store('events', 'public');
        }

        $event->update($validated);
        return redirect()->route('admin.kelola.event.index')
            ->with('success', 'Perubahan Berhasil Disimpan');
    }

    public function destroy(Event $event)
    {
        if ($event->image) {
            Storage::disk('public')->delete($event->image);
        }
        
        $event->delete();
        return redirect()->route('admin.kelola.event.index')
            ->with('deleted', 'Data Event Berhasil Dihapus');
    }

    public function export()
    {
        $events = Event::all();

        // Filter berdasarkan pencarian
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_event', 'LIKE', "%{$search}%")
                  ->orWhere('penyelenggara', 'LIKE', "%{$search}%");
            });
        }

        // Filter berdasarkan status
        if ($request->has('status') && in_array($request->status, ['berlangsung', 'akan_datang', 'selesai'])) {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan tanggal
        if ($request->has('filter_date')) {
            $query->whereDate('tanggal_pelaksanaan', $request->filter_date);
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set headers
        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Nama Event');
        $sheet->setCellValue('C1', 'Penyelenggara');
        $sheet->setCellValue('D1', 'Tanggal');
        $sheet->setCellValue('E1', 'Waktu');
        $sheet->setCellValue('F1', 'Lokasi');
        $sheet->setCellValue('G1', 'Deskripsi');
        $sheet->setCellValue('H1', 'Status');
        

        $row = 2;
        foreach ($events as $event) {
            $sheet->setCellValue('A' . $row, $event->id);
            $sheet->setCellValue('B' . $row, $event->nama_event);
            $sheet->setCellValue('C' . $row, $event->penyelenggara);
            $sheet->setCellValue('D' . $row, $event->tanggal_pelaksanaan);
            $sheet->setCellValue('E' . $row, $event->waktu);
            $sheet->setCellValue('F' . $row, $event->lokasi_ruangan);
            $sheet->setCellValue('G' . $row, $event->deskripsi);
            $sheet->setCellValue('H' . $row, $event->status);
            $row++;
        }

        $writer = new Xlsx($spreadsheet);
        
        $filename = 'daftar_ruangan_' . date('Y-m-d') . '.xlsx';
        
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        
        $writer->save('php://output');
        exit;
        
        $filename = "events-" . date('Y-m-d') . ".csv";
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$filename}",
        ];

        $callback = function() use ($events) {
            $file = fopen('php://output', 'w');
            
            // Add headers
            fputcsv($file, [
                'ID',
                'Nama Event',
                'Tanggal',
                'Waktu',
                'Lokasi',
                'Deskripsi',
                'Status',
                'Tanggal Dibuat'
            ]);
            
            foreach ($events as $event) {
                fputcsv($file, [
                    $event->id,
                    $event->nama_event,
                    $event->tanggal,
                    $event->waktu,
                    $event->lokasi,
                    $event->deskripsi,
                    $event->status,
                    $event->created_at->format('Y-m-d H:i:s')
                ]);
            }
            
            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }
}