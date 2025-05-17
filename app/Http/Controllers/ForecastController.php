<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ForecastController extends Controller
{
/*************  ✨ Windsurf Command ⭐  *************/
    /**
     * Get forecast data for a given range (3, 6, or 12 months)
     * 
     * @param Request $request

/*******  bca350d7-47e8-43f7-aa48-dffd6a633e39  *******/    public function getForecastData(Request $request, $periode = 12)
    {
        try {
            // Pastikan range (periode) sesuai dengan nilai yang valid: 3, 6, atau 12 bulan
            $range = (int) $periode; 

            // Validasi nilai range agar hanya 3, 6, atau 12
            if (!in_array($range, [3, 6, 12])) {
                return response()->json(['error' => 'Range harus 3, 6, atau 12 bulan'], 400);
            }

            // Hitung tanggal mulai berdasarkan range bulan ke belakang
            $startDate = Carbon::now()->subMonths($range)->startOfDay();

            // Ambil data forecast dari database dengan filter tanggal
            $data = DB::table('forecasting_peminjaman')
                ->whereDate('tanggal_forecasting', '>=', $startDate)
                ->orderBy('tanggal_forecasting')
                ->get();

            return response()->json($data);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function showForecastChart(Request $request)
    {
        // Ambil nilai range dari query parameter (opsi: 3, 6, 12), default 12 bulan
        $range = (int) $request->query('range', 12);

        if (!in_array($range, [3, 6, 12])) {
            $range = 12; // Jika nilai range tidak valid, set default ke 12 bulan
        }

        // Hitung tanggal mulai berdasarkan range bulan ke belakang
        $startDate = Carbon::now()->subMonths($range)->startOfDay();

        // Ambil data forecasting dari database
        $data = DB::table('forecasting_peminjaman')
            ->whereDate('tanggal_forecasting', '>=', $startDate)
            ->orderBy('tanggal_forecasting')
            ->get();

        // Kirim data ke view
        return view('admin.dashboard', [
            'forecastData' => $data,
            'range' => $range
        ]);
    }
}

