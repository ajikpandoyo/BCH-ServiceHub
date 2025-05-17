<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('peminjaman_ruangan', function (Blueprint $table) {
            // Hapus kolom lama jika ada
            if (Schema::hasColumn('peminjaman_ruangan', 'nama_pemohon')) {
                $table->dropColumn('nama_pemohon');
            }
            if (Schema::hasColumn('peminjaman_ruangan', 'nama_acara')) {
                $table->dropColumn('nama_acara');
            }
            if (Schema::hasColumn('peminjaman_ruangan', 'tujuan')) {
                $table->dropColumn('tujuan');
            }
            if (Schema::hasColumn('peminjaman_ruangan', 'surat_pengajuan')) {
                $table->dropColumn('surat_pengajuan');
            }
            if (Schema::hasColumn('peminjaman_ruangan', 'ktp')) {
                $table->dropColumn('ktp');
            }
            if (Schema::hasColumn('peminjaman_ruangan', 'screening_file')) {
                $table->dropColumn('screening_file');
            }
            if (Schema::hasColumn('peminjaman_ruangan', 'reason')) {
                $table->dropColumn('reason');
            }


            // Tambah kolom baru jika belum ada
            if (!Schema::hasColumn('peminjaman_ruangan', 'nama_peminjam')) {
                $table->string('nama_peminjam')->after('ruangan_id');
            }
            if (!Schema::hasColumn('peminjaman_ruangan', 'email_peminjam')) {
                $table->string('email_peminjam')->after('nama_peminjam');
            }
            if (!Schema::hasColumn('peminjaman_ruangan', 'telepon_peminjam')) {
                $table->string('telepon_peminjam')->after('email_peminjam');
            }
            if (!Schema::hasColumn('peminjaman_ruangan', 'instansi_peminjam')) {
                $table->string('instansi_peminjam')->after('telepon_peminjam');
            }
            if (!Schema::hasColumn('peminjaman_ruangan', 'kegiatan')) {
                $table->string('kegiatan')->after('instansi_peminjam');
            }
            if (!Schema::hasColumn('peminjaman_ruangan', 'deskripsi_kegiatan')) {
                $table->text('deskripsi_kegiatan')->after('kegiatan');
            }
            if (!Schema::hasColumn('peminjaman_ruangan', 'jumlah_peserta')) {
                $table->integer('jumlah_peserta')->after('deskripsi_kegiatan');
            }
            if (!Schema::hasColumn('peminjaman_ruangan', 'surat_peminjaman')) {
                $table->string('surat_peminjaman')->after('jumlah_peserta');
            }
            if (!Schema::hasColumn('peminjaman_ruangan', 'rejection_reason')) {
                $table->text('rejection_reason')->nullable()->after('status');
            }
        });
    }

    public function down()
    {
        Schema::table('peminjaman_ruangan', function (Blueprint $table) {
            // Hapus kolom baru
            if (Schema::hasColumn('peminjaman_ruangan', 'nama_peminjam')) {
                $table->dropColumn('nama_peminjam');
            }
            if (Schema::hasColumn('peminjaman_ruangan', 'email_peminjam')) {
                $table->dropColumn('email_peminjam');
            }
            if (Schema::hasColumn('peminjaman_ruangan', 'telepon_peminjam')) {
                $table->dropColumn('telepon_peminjam');
            }
            if (Schema::hasColumn('peminjaman_ruangan', 'instansi_peminjam')) {
                $table->dropColumn('instansi_peminjam');
            }
            if (Schema::hasColumn('peminjaman_ruangan', 'kegiatan')) {
                $table->dropColumn('kegiatan');
            }
            if (Schema::hasColumn('peminjaman_ruangan', 'deskripsi_kegiatan')) {
                $table->dropColumn('deskripsi_kegiatan');
            }
            if (Schema::hasColumn('peminjaman_ruangan', 'jumlah_peserta')) {
                $table->dropColumn('jumlah_peserta');
            }
            if (Schema::hasColumn('peminjaman_ruangan', 'surat_peminjaman')) {
                $table->dropColumn('surat_peminjaman');
            }
            if (Schema::hasColumn('peminjaman_ruangan', 'catatan')) {
                $table->dropColumn('catatan');
            }

            // Kembalikan kolom lama
            if (!Schema::hasColumn('peminjaman_ruangan', 'nama_pemohon')) {
                $table->string('nama_pemohon');
            }
            if (!Schema::hasColumn('peminjaman_ruangan', 'nama_acara')) {
                $table->string('nama_acara');
            }
            if (!Schema::hasColumn('peminjaman_ruangan', 'tujuan')) {
                $table->text('tujuan');
            }
            if (!Schema::hasColumn('peminjaman_ruangan', 'surat_pengajuan')) {
                $table->string('surat_pengajuan');
            }
            if (!Schema::hasColumn('peminjaman_ruangan', 'ktp')) {
                $table->string('ktp');
            }
            if (!Schema::hasColumn('peminjaman_ruangan', 'screening_file')) {
                $table->string('screening_file')->nullable();
            }
            if (!Schema::hasColumn('peminjaman_ruangan', 'reason')) {
                $table->text('reason')->nullable();
            }
        });
    }
}; 