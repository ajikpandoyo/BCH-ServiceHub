<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MediaPartner;
use Illuminate\Support\Facades\DB;

class MediaPartnerSeeder extends Seeder
{
    public function run()
    {
        DB::table('media_partners')->insert([
            [
                'user_id' => 1,
                'nama_pemohon' => 'Vanisa Indriyani',
                'email' => 'vanisa@example.com',
                'nama_instansi' => 'Universitas Mercu Buana Yogyakarta',
                'instagram' => '@umb_yk',
                'website' => 'https://mercubuana-yogya.ac.id',
                'tema_acara' => 'Festival Budaya Digital',
                'kategori_subsektor' => 'Event Organizer',
                'tanggal_acara' => '2025-06-20',
                'pic_nama' => 'Rani Melati',
                'pic_whatsapp' => '081234567891',
                'surat_pengajuan' => 'surat_pengajuan1.pdf',
                'status' => 'pending',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'user_id' => 1,
                'nama_pemohon' => 'Andi Pratama',
                'email' => 'andi@example.com',
                'nama_instansi' => 'Komunitas Seni Yogyakarta',
                'instagram' => '@seni_yk',
                'website' => null,
                'tema_acara' => 'Pameran Seni Rupa Nusantara',
                'kategori_subsektor' => 'Seni Rupa',
                'tanggal_acara' => '2025-07-10',
                'pic_nama' => 'Dhea Indira',
                'pic_whatsapp' => '082345678912',
                'surat_pengajuan' => 'surat_pengajuan2.pdf',
                'status' => 'approved',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'user_id' => 1,
                'nama_pemohon' => 'Siti Nurhaliza',
                'email' => 'siti@example.com',
                'nama_instansi' => 'Media Musik Indonesia',
                'instagram' => '@musik_id',
                'website' => 'https://musikindonesia.id',
                'tema_acara' => 'Konser Musik Indie',
                'kategori_subsektor' => 'Musik',
                'tanggal_acara' => '2025-08-05',
                'pic_nama' => 'March Sevenia',
                'pic_whatsapp' => '083456789123',
                'surat_pengajuan' => 'surat_pengajuan3.pdf',
                'status' => 'rejected',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'user_id' => 1,
                'nama_pemohon' => 'Doni Setiawan',
                'email' => 'doni@example.com',
                'nama_instansi' => 'Komunitas Literasi Digital',
                'instagram' => '@literasidigital',
                'website' => 'https://literasidigital.org',
                'tema_acara' => 'Seminar Literasi Era AI',
                'kategori_subsektor' => 'Pendidikan',
                'tanggal_acara' => '2025-09-15',
                'pic_nama' => 'Indra Syahputra',
                'pic_whatsapp' => '084567891234',
                'surat_pengajuan' => 'surat_pengajuan4.pdf',
                'status' => 'pending',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'user_id' => 1,
                'nama_pemohon' => 'Lina Marlina',
                'email' => 'lina@example.com',
                'nama_instansi' => 'Startup Teknologi Kreatif',
                'instagram' => '@techcreative',
                'website' => 'https://techcreative.id',
                'tema_acara' => 'Launch Produk Inovatif',
                'kategori_subsektor' => 'Teknologi Kreatif',
                'tanggal_acara' => '2025-10-01',
                'pic_nama' => 'Reza Ananda',
                'pic_whatsapp' => '085678912345',
                'surat_pengajuan' => 'surat_pengajuan5.pdf',
                'status' => 'approved',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
