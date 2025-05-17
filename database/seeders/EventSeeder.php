<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class EventSeeder extends Seeder
{
    public function run()
    {
        DB::table('events')->insert([
            [
                'nama_event' => 'Tech Conference 2025',
                'penyelenggara' => 'Komunitas Developer Jogja',
                'tanggal_pelaksanaan' => '2025-05-15',
                'waktu' => '09:00 - 16:00',
                'lokasi_ruangan' => 'Auditorium UMBY',
                'deskripsi' => 'Konferensi teknologi tahunan untuk para developer di Yogyakarta.',
                'poster' => 'techconf2025.jpg',
                'status' => 'akan_datang',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama_event' => 'Workshop UI/UX Design',
                'penyelenggara' => 'DesignHub ID',
                'tanggal_pelaksanaan' => '2025-04-10',
                'waktu' => '13:00 - 17:00',
                'lokasi_ruangan' => 'Lab Komputer A',
                'deskripsi' => 'Pelatihan dasar desain antarmuka dan pengalaman pengguna.',
                'poster' => 'workshop_uiux.jpg',
                'status' => 'selesai',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama_event' => 'Pelatihan Digital Marketing',
                'penyelenggara' => 'Startup Academy',
                'tanggal_pelaksanaan' => '2025-05-05',
                'waktu' => '10:00 - 15:00',
                'lokasi_ruangan' => 'Ruang Multimedia 3',
                'deskripsi' => 'Pelatihan untuk UMKM dalam memasarkan produk secara digital.',
                'poster' => 'pelatihan_digital.jpg',
                'status' => 'berlangsung',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama_event' => 'Seminar Kewirausahaan Mahasiswa',
                'penyelenggara' => 'BEM Fakultas Ekonomi',
                'tanggal_pelaksanaan' => '2025-06-01',
                'waktu' => '08:00 - 12:00',
                'lokasi_ruangan' => 'Ruang Seminar Lt. 2',
                'deskripsi' => 'Seminar untuk mendorong mahasiswa menjadi wirausahawan.',
                'poster' => 'seminar_kewirausahaan.jpg',
                'status' => 'akan_datang',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama_event' => 'Lomba Desain Poster Nasional',
                'penyelenggara' => 'UKM Seni Rupa',
                'tanggal_pelaksanaan' => '2025-03-25',
                'waktu' => 'All Day',
                'lokasi_ruangan' => 'Galeri Seni Kampus',
                'deskripsi' => 'Kompetisi desain poster tingkat nasional untuk pelajar dan mahasiswa.',
                'poster' => 'lomba_poster.jpg',
                'status' => 'selesai',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
