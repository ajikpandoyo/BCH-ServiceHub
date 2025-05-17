<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('kerjasama_events', function (Blueprint $table) {
            $table->id();
            // Admin Event Details
            $table->string('nama_event');
            $table->text('deskripsi_event');
            $table->date('tanggal_pelaksanaan');
            $table->string('lokasi');
            $table->string('proposal');
            $table->text('rejection_reason')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');

            // Tambahan kolom peserta dan user
            $table->string('nama_peserta')->nullable();
            $table->string('email_peserta')->nullable();
            $table->string('telepon_peserta')->nullable();
            $table->string('instansi_peserta')->nullable();
            $table->string('bukti_pembayaran')->nullable();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('kerjasama_events');
    }
};
