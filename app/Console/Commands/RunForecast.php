<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class RunForecast extends Command
{
    protected $signature = 'forecast:run';
    protected $description = 'Menjalankan forecast script Python';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $process = new Process(['python', base_path('forecast.py')]);
        $process->run();

        // Jika proses gagal
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        $this->info('Forecast berhasil dijalankan');
    }
}
