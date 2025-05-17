<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        try {
            // Get upcoming events if events table exists
            $upcomingEvents = DB::table('events')
                ->where('tanggal_pelaksanaan', '>=', now())
                ->orderBy('tanggal_pelaksanaan', 'asc')
                ->limit(3)
                ->get();

            // Get counts for different event statuses
            $countAll = DB::table('events')->count();
            $countBerlangsung = DB::table('events')
                ->where('status', 'berlangsung')
                ->count();
            $countAkanDatang = DB::table('events')
                ->where('status', 'akan_datang')
                ->count();
            $countSelesai = DB::table('events')
                ->where('status', 'selesai')
                ->count();

            // Get events with optional status filter
            $eventsQuery = DB::table('events');
            if (request('status')) {
                $eventsQuery->where('status', request('status'));
            }
            if (request('filter_date')) {
                $eventsQuery->whereDate('tanggal_pelaksanaan', request('filter_date'));
            }
            $events = $eventsQuery->orderBy('tanggal_pelaksanaan', 'desc')->paginate(10);

            // Get counts for peminjaman_ruangan statuses
            $approvedCount = DB::table('peminjaman_ruangan')
                ->where('status', 'approved')
                ->count();
            $rejectedCount = DB::table('peminjaman_ruangan')
                ->where('status', 'rejected')
                ->count();
            $pendingCount = DB::table('peminjaman_ruangan')
                ->where('status', 'pending')
                ->count();
        } catch (\Exception $e) {
            // If there's any database error, set empty values
            $upcomingEvents = collect();
            $events = collect();
            $countAll = 0;
            $countBerlangsung = 0;
            $countAkanDatang = 0;
            $countSelesai = 0;
            $approvedCount = 0;
            $rejectedCount = 0;
            $pendingCount = 0;
        }

        return view('home', compact(
            'upcomingEvents',
            'events',
            'countAll',
            'countBerlangsung',
            'countAkanDatang',
            'countSelesai',
            'approvedCount',
            'rejectedCount',
            'pendingCount'
        ));
    }
}