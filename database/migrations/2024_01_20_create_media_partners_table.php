<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('media_partners', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            // Data Pemohon
            $table->string('nama_pemohon');
            $table->string('email');
            
            // Data Instansi
            $table->string('nama_instansi');
            $table->string('instagram');
            $table->string('website')->nullable();
            
            // Data Acara
            $table->string('tema_acara');
            $table->string('kategori_subsektor');
            $table->date('tanggal_acara');
            
            // Kontak PIC
            $table->string('pic_nama');
            $table->string('pic_whatsapp');
            
            // Berkas
            $table->string('surat_pengajuan');
            
            // Status
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('keterangan')->nullable(); // Tambahkan kolom keterangan
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('media_partners');
    }
};