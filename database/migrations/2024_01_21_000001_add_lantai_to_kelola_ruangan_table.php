<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('kelola_ruangan', function (Blueprint $table) {
            if (!Schema::hasColumn('kelola_ruangan', 'lantai')) {
                $table->string('lantai')->after('nama_ruangan');
            }
        });
    }

    public function down()
    {
        Schema::table('kelola_ruangan', function (Blueprint $table) {
            if (Schema::hasColumn('kelola_ruangan', 'lantai')) {
                $table->dropColumn('lantai');
            }
        });
    }
}; 