<?php

namespace Database\Seeders;

use App\Models\PendaftaranEvent;
use Illuminate\Database\Seeder;

class PendaftaranEventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $pendaftaran = [
            [   
                'event_id' => 1,
                'user_id' => 1,
                'nama_lengkap'=> 'Santi Dewi',
                'email' => 'santi@example.com',
                'whatsapp' => '081234568009',
                'instansi' => 'Forum Perempuan',
                'bukti_pembayaran' => 'payments/santi-payment.pdf',
                'status' => 'pending',
                'created_at' => '2024-12-01 08:30:00',
                'updated_at' => '2024-12-01 08:30:00'
            ],    
            [   
                'event_id' => 2,
                'user_id' => 3,
                'nama_lengkap'=> 'Budi Santoso',
                'email' => 'budi@example.com',
                'whatsapp' => '081234568009',
                'instansi' => 'Teknologi Informasi',
                'bukti_pembayaran' => 'payments/budi-payment.pdf',
                'status' => 'pending',
                'created_at' => '2024-12-01 08:30:00',
                'updated_at' => '2024-12-01 08:30:00'
            ],    
        ];
        foreach ($pendaftaran as $data) {
            PendaftaranEvent::create($data);
        }
    }
}
