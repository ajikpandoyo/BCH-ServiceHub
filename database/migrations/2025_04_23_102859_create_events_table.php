<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('nama_event');
            $table->string('penyelenggara');
            $table->date('tanggal_pelaksanaan');
            $table->string('waktu');
            $table->string('lokasi_ruangan');
            $table->text('deskripsi');
            $table->string('poster')->nullable();
            $table->enum('status', ['berlangsung', 'akan_datang', 'selesai'])->default('akan_datang');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('events');
    }
};