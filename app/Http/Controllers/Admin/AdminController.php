<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Ruangan;  // Add this line
use App\Models\PeminjamanRuangan;
use App\Models\KunjunganVisit;
use App\Models\MediaPartner;
use App\Models\KerjasamaEvent;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function kelola()
    {
        return view('admin.kelola.index');
    }

    public function kelolaRuangan()
    {
        return view('admin.kelola.ruangan');
    }

    public function kelolaEvent()
    {
        $events = Event::all();
        return view('admin.kelola.event', compact('events'));
    }

    public function exportEvent()
    {
        $events = Event::all();
        // Implement export logic here
    }
    
    public function index(Request $request)
    {
        // Total pengajuan bulan ini
        $currentMonth = now()->month;
        $currentYear = now()->year;
        
        $year = $request->input('year', date('Y'));
        $mode = $request->input('mode', 'monthly');
    
        $monthlyStats = $this->getStats($year, $mode);

        
        // Get total applications
        $totalPengajuan = $this->getTotalApplications();
        
        // Get applications by status
        $totalDiproses = $this->getTotalApplicationsByStatus('pending');
        $totalDisetujui = $this->getTotalApplicationsByStatus('approved');
        $totalDitolak = $this->getTotalApplicationsByStatus('rejected');
        

        // Get forecast data
        $forecastResult = $this->showForecastChart(); 
        $forecastData = $forecastResult['forecastData'];
        $range = $forecastResult['range'];
        
        //popular room
        $popularRoom = $this->ruanganTerpopuler();
        $totalPeminjaman = $popularRoom->sum('jumlah_peminjaman');


        // mediapartners list
        $query = MediaPartner::query();
        $mediapartners = $query->latest()->get();


        return view('admin.dashboard', compact(
            'monthlyStats',
            'year',
            'mode',
            'totalPengajuan',
            'totalPeminjaman',
            'totalDiproses',
            'totalDisetujui',
            'totalDitolak',
            'popularRoom',
            'forecastData',
            'range',
            'mediapartners',
        ));
    }
    
    private function getTotalApplications()
    {
        $kunjunganVisit = KunjunganVisit::count();
        $peminjamanRuangan = PeminjamanRuangan::count();
        $mediaPartner = MediaPartner::count();
        $kerjasamaEvent = KerjasamaEvent::count();
        
        $total = $kunjunganVisit + $peminjamanRuangan + $mediaPartner + $kerjasamaEvent;
        
        return [
            'total' => $total,
            'kunjungan_visit' => $kunjunganVisit,
            'peminjaman_ruangan' => $peminjamanRuangan,
            'media_partner' => $mediaPartner,
            'kerjasama_event' => $kerjasamaEvent
        ];
    }
    
    private function getTotalApplicationsByStatus($status)
    {
        $kunjunganVisit = KunjunganVisit::where('status', $status)->count();
        $peminjamanRuangan = PeminjamanRuangan::where('status', $status)->count();
        $mediaPartner = MediaPartner::where('status', $status)->count();
        $kerjasamaEvent = KerjasamaEvent::where('status', $status)->count();
        
        return $kunjunganVisit + $peminjamanRuangan + $mediaPartner + $kerjasamaEvent;
    }
    
    
    private function getStats($year, $mode = 'monthly')
    {
        $results = [];
        
        if ($mode === 'monthly') {
            $labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Des'];
            for ($i = 1; $i <= 12; $i++) {
                $results[] = [
                    'label' => $labels[$i - 1],
                    'kunjungan_visit' => KunjunganVisit::whereYear('created_at', $year)->whereMonth('created_at', $i)->count(),
                    'peminjaman_ruangan' => PeminjamanRuangan::whereYear('created_at', $year)->whereMonth('created_at', $i)->count()
                ];
            }
        } elseif ($mode === 'quarterly') {
            $labels = ['Q1', 'Q2', 'Q3', 'Q4'];
            for ($q = 0; $q < 4; $q++) {
                $startMonth = $q * 3 + 1;
                $endMonth = $startMonth + 2;

                $results[] = [
                    'label' => $labels[$q],
                    'kunjungan_visit' => KunjunganVisit::whereYear('created_at', $year)
                        ->whereBetween(DB::raw('MONTH(created_at)'), [$startMonth, $endMonth])->count(),
                    'peminjaman_ruangan' => PeminjamanRuangan::whereYear('created_at', $year)
                        ->whereBetween(DB::raw('MONTH(created_at)'), [$startMonth, $endMonth])->count()
                ];
            }
        } elseif ($mode === 'yearly') {
            $results[] = [
                'label' => (string) $year,
                'kunjungan_visit' => KunjunganVisit::whereYear('created_at', $year)->count(),
                'peminjaman_ruangan' => PeminjamanRuangan::whereYear('created_at', $year)->count()
            ];
        }

        return $results;
    }


    public function ruanganTerpopuler()
    {
        // Ambil data jumlah peminjaman per ruangan dan gabungkan dengan tabel ruangan
        $popularRoom = DB::table('peminjaman_ruangan')
            ->select('ruangan_id', DB::raw('count(*) as jumlah_peminjaman'))
            ->groupBy('ruangan_id')
            ->join('kelola_ruangan', 'peminjaman_ruangan.ruangan_id', '=', 'kelola_ruangan.id')
            ->select('kelola_ruangan.nama_ruangan', 'kelola_ruangan.lokasi', DB::raw('count(*) as jumlah_peminjaman'))
            ->groupBy('kelola_ruangan.nama_ruangan', 'kelola_ruangan.lokasi')
            ->orderByDesc('jumlah_peminjaman')
            ->get();

        return $popularRoom;
    }

    public function getChartData($range = 'monthly')
    {
        $year = now()->year;

        if ($range === 'monthly') {
            return response()->json($this->getMonthlyStatsForYear($year));
        }

        if ($range === 'quarterly') {
            $data = $this->getMonthlyStatsForYear($year);

            $quarters = [
                ['Jan', 'Feb', 'Mar'],
                ['Apr', 'May', 'Jun'],
                ['Jul', 'Aug', 'Sep'],
                ['Oct', 'Nov', 'Des'],
            ];

            $result = [];
            foreach ($quarters as $index => $months) {
                $filtered = collect($data)->whereIn('month', $months);
                $result[] = [
                    'month' => 'Q' . ($index + 1),
                    'kunjungan_visit' => $filtered->sum('kunjungan_visit'),
                    'peminjaman_ruangan' => $filtered->sum('peminjaman_ruangan'),
                ];
            }

            return response()->json($result);
        }

        if ($range === 'yearly') {
            $lastFiveYears = range($year - 4, $year);
            $result = [];

            foreach ($lastFiveYears as $y) {
                $monthly = $this->getMonthlyStatsForYear($y);
                $result[] = [
                    'month' => $y,
                    'kunjungan_visit' => collect($monthly)->sum('kunjungan_visit'),
                    'peminjaman_ruangan' => collect($monthly)->sum('peminjaman_ruangan'),
                ];
            }

            return response()->json($result);
        }

        return response()->json([]);
    }


    public function getForecastData(Request $request)
    {
        try {
            $range = (int) $periode; // ✅ pakai parameter $periode, bukan $request
    
            if (!in_array($range, [3, 6, 12])) {
                return response()->json(['error' => 'Range harus 3, 6, atau 12 bulan'], 400);
            }
    
            $startDate = Carbon::now()->subMonths($range)->startOfDay();
    
            $forecastData = DB::table('forecasting_peminjaman')
                ->whereDate('tanggal_forecasting', '>=', $startDate)
                ->orderBy('tanggal_forecasting')
                ->get();

            return response()->json($forecastData);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function showForecastChart($range = 12)
    {
        // Validasi range
        if (!in_array($range, [3, 6, 12])) {
            $range = 12;
        }

        $startDate = Carbon::now()->subMonths($range)->startOfDay();

        $forecastData = DB::table('forecasting_peminjaman')
            ->whereDate('tanggal_forecasting', '>=', $startDate)
            ->orderBy('tanggal_forecasting')
            ->get();

        return [
            'range' => $range,
            'startDate' => $startDate,
            'forecastData' => $forecastData,
        ];
    }

    private function getPercentageChangesFromLastWeek()
    {
        $now = Carbon::now();
        $currentWeekStart = $now->copy()->startOfWeek();
        $lastWeekStart = $now->copy()->subWeek()->startOfWeek();
        $lastWeekEnd = $now->copy()->subWeek()->endOfWeek();
        
        // Get total applications for current week
        $currentWeekTotal = $this->getApplicationsCountBetweenDates($currentWeekStart, $now);
        
        // Get total applications for last week
        $lastWeekTotal = $this->getApplicationsCountBetweenDates($lastWeekStart, $lastWeekEnd);
        
        // Get applications by status for current week
        $currentWeekPending = $this->getApplicationsCountBetweenDatesByStatus($currentWeekStart, $now, 'pending');
        $currentWeekApproved = $this->getApplicationsCountBetweenDatesByStatus($currentWeekStart, $now, 'approved');
        $currentWeekRejected = $this->getApplicationsCountBetweenDatesByStatus($currentWeekStart, $now, 'rejected');
        
        // Get applications by status for last week
        $lastWeekPending = $this->getApplicationsCountBetweenDatesByStatus($lastWeekStart, $lastWeekEnd, 'pending');
        $lastWeekApproved = $this->getApplicationsCountBetweenDatesByStatus($lastWeekStart, $lastWeekEnd, 'approved');
        $lastWeekRejected = $this->getApplicationsCountBetweenDatesByStatus($lastWeekStart, $lastWeekEnd, 'rejected');
        
        // Calculate percentage changes
        $totalChange = $this->calculatePercentageChange($lastWeekTotal, $currentWeekTotal);
        $pendingChange = $this->calculatePercentageChange($lastWeekPending, $currentWeekPending);
        $approvedChange = $this->calculatePercentageChange($lastWeekApproved, $currentWeekApproved);
        $rejectedChange = $this->calculatePercentageChange($lastWeekRejected, $currentWeekRejected);
        
        return [
            'total' => $totalChange,
            'pending' => $pendingChange,
            'approved' => $approvedChange,
            'rejected' => $rejectedChange
        ];
    }
    
    private function calculatePercentageChange($oldValue, $newValue)
    {
        if ($oldValue == 0) {
            return $newValue > 0 ? 100 : 0;
        }
        
        return round((($newValue - $oldValue) / $oldValue) * 100, 1);
    }
    
    private function getApplicationsCountBetweenDates($startDate, $endDate)
    {
        $kunjunganVisit = KunjunganVisit::whereBetween('created_at', [$startDate, $endDate])->count();
        $peminjamanRuangan = PeminjamanRuangan::whereBetween('created_at', [$startDate, $endDate])->count();
        $mediaPartner = MediaPartner::whereBetween('created_at', [$startDate, $endDate])->count();
        $kerjasamaEvent = KerjasamaEvent::whereBetween('created_at', [$startDate, $endDate])->count();
        
        return $kunjunganVisit + $peminjamanRuangan + $mediaPartner + $kerjasamaEvent;
    }
    
    private function getApplicationsCountBetweenDatesByStatus($startDate, $endDate, $status)
    {
        $kunjunganVisit = KunjunganVisit::whereBetween('created_at', [$startDate, $endDate])
            ->where('status', $status)->count();
        $peminjamanRuangan = PeminjamanRuangan::whereBetween('created_at', [$startDate, $endDate])
            ->where('status', $status)->count();
        $mediaPartner = MediaPartner::whereBetween('created_at', [$startDate, $endDate])
            ->where('status', $status)->count();
        $kerjasamaEvent = KerjasamaEvent::whereBetween('created_at', [$startDate, $endDate])
            ->where('status', $status)->count();
        
        return $kunjunganVisit + $peminjamanRuangan + $mediaPartner + $kerjasamaEvent;
    }
    

}