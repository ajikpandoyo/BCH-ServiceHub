<?php

namespace Database\Seeders;

use App\Models\KerjasamaEvent;
use App\Models\User;
use Illuminate\Database\Seeder;

class KerjasamaEventSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();

        $events = [
            [
                'nama_event' => 'Workshop Digital Marketing',
                'deskripsi_event' => 'Workshop tentang strategi pemasaran digital untuk bisnis',
                'tanggal_pelaksanaan' => '2024-06-15',
                'lokasi' => 'Gedung Utama Lt. 3',
                'proposal' => 'proposals/workshop-dm.pdf',
                'status' => 'pending',
                'nama_peserta' => 'John Doe',
                'email_peserta' => 'john@example.com',
                'telepon_peserta' => '081234567890',
                'instansi_peserta' => 'PT Digital Solutions',
                'bukti_pembayaran' => 'payments/workshop-dm-payment.pdf',
                'user_id' => $users->random()->id
            ],
            [
                'nama_event' => 'Seminar Teknologi AI',
                'deskripsi_event' => 'Seminar membahas perkembangan AI terkini',
                'tanggal_pelaksanaan' => '2024-07-20',
                'lokasi' => 'Auditorium',
                'proposal' => 'proposals/seminar-ai.pdf',
                'status' => 'pending',
                'nama_peserta' => 'Jane Smith',
                'email_peserta' => 'jane@example.com',
                'telepon_peserta' => '081234567891',
                'instansi_peserta' => 'Tech Institute',
                'bukti_pembayaran' => 'payments/seminar-ai-payment.pdf',
                'user_id' => $users->random()->id
            ],
            [
                'nama_event' => 'Pelatihan Data Science',
                'deskripsi_event' => 'Pelatihan intensif pengolahan data dan analisis',
                'tanggal_pelaksanaan' => '2024-08-10',
                'lokasi' => 'Lab Komputer',
                'proposal' => 'proposals/pelatihan-ds.pdf',
                'status' => 'pending',
                'nama_peserta' => 'David Wilson',
                'email_peserta' => 'david@example.com',
                'telepon_peserta' => '081234567892',
                'instansi_peserta' => 'Data Analytics Corp',
                'bukti_pembayaran' => 'payments/pelatihan-ds-payment.pdf',
                'user_id' => $users->random()->id
            ]
        ];

        foreach ($events as $event) {
            KerjasamaEvent::create($event);
        }
    }
}