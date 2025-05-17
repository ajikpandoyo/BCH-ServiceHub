<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('peminjaman_ruangan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('ruangan_id')->constrained('kelola_ruangan')->onDelete('cascade');
            $table->string('nama_pemohon');
            $table->string('nama_acara');
            $table->date('tanggal_peminjaman');
            $table->time('waktu_mulai');
            $table->time('waktu_selesai');
            $table->text('tujuan');
            $table->string('surat_pengajuan');
            $table->string('ktp');
            $table->string('screening_file')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('reason')->nullable(); // For rejection reason
            $table->timestamps();
            $table->softDeletes(); // Add soft deletes
        });
    }

    public function down()
    {
        Schema::dropIfExists('peminjaman_ruangan');
    }
};