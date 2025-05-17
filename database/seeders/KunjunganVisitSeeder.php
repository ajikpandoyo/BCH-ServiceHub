<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class KunjunganVisitSeeder extends Seeder
{
    public function run()
    {
        $users = \App\Models\User::pluck('id')->take(5); // Ambil 5 user pertama

        foreach ($users as $index => $userId) {
            DB::table('kunjungan_visits')->insert([
                'user_id' => $userId,
                'nama_pemohon' => 'Pemohon ' . ($index + 1),
                'email' => 'pemohon' . ($index + 1) . '@example.com',
                'instansi' => 'Instansi ' . Str::random(5),
                'tanggal_kunjungan' => Carbon::now()->addDays(rand(1, 30))->format('Y-m-d'),
                'waktu_kunjungan' => Carbon::now()->setTime(rand(8, 15), 0)->format('H:i:s'),
                'jumlah_peserta' => rand(5, 30),
                'no_telepon' => '08' . rand(1000000000, 9999999999),
                'tujuan_kunjungan' => 'Kunjungan untuk studi banding dan kerjasama.',
                'proposal_path' => 'proposal/contoh_proposal_' . ($index + 1) . '.pdf',
                'status' => 'pending',
                'rejection_reason' => null,
                'status_updated_at' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
