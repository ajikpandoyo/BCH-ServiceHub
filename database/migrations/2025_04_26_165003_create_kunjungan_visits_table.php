<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('kunjungan_visits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');  // Pastikan ada relasi user
            $table->string('nama_pemohon');
            $table->string('email');
            $table->string('instansi');
            $table->date('tanggal_kunjungan');
            $table->time('waktu_kunjungan');
            $table->integer('jumlah_peserta');
            $table->string('no_telepon');
            $table->text('tujuan_kunjungan');
            $table->string('proposal_path');
            $table->string('status')->default('pending');
            $table->text('rejection_reason')->nullable();
            $table->timestamp('status_updated_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('kunjungan_visits');
    }
};