<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('sesi_ruangan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kelola_ruangan_id')
                  ->constrained('kelola_ruangan')
                  ->onDelete('cascade');
            $table->string('nama_sesi');
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->timestamps();
        });
        
    }

    public function down()
    {
        Schema::dropIfExists('sesi_ruangan');
    }
};
