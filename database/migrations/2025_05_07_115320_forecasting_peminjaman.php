<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('forecasting_peminjaman', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_forecasting');
            $table->integer('jumlah_peminjaman');
            $table->string('bulan');
            $table->integer('tahun');
            $table->float('nilai_forecast')->nullable();
            $table->float('error_rate')->nullable();
            $table->string('metode_forecast')->nullable();
            $table->text('catatan')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('forecasting_peminjaman');
    }
};