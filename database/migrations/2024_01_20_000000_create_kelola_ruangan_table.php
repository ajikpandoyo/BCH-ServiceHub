<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('kelola_ruangan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_ruangan');
            $table->integer('kapasitas');
            $table->string('lokasi');
            $table->text('fasilitas');
            $table->string('jam_operasional');
            $table->string('gambar')->nullable(); // Tambah field gambar
            $table->integer('lantai')->default(1);
            $table->string('status')->default('Tersedia');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('kelola_ruangan');
    }
};