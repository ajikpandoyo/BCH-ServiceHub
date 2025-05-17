<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Daftar perintah yang dapat dijalankan oleh Artisan.
     *
     * @var array
     */
    protected $commands = [
        // Daftarkan command di sini, misalnya:
        \App\Console\Commands\RunForecast::class,
    ];

    /**
     * Menentukan jadwal tugas Artisan.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // Menjadwalkan perintah, misalnya menjalankan forecast setiap hari
        $schedule->command('run:forecast')->daily();
    }

    /**
     * Definisikan semua perintah Artisan.
     *
     * @return void
     */
    protected function commands()
    {
        // Memuat semua command di dalam folder 'app/Console/Commands'
        $this->load(__DIR__.'/Commands');

        // Memuat route console
        require base_path('routes/console.php');
    }
}


