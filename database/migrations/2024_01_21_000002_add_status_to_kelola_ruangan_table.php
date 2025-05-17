<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('kelola_ruangan', function (Blueprint $table) {
            if (!Schema::hasColumn('kelola_ruangan', 'status')) {
                $table->string('status')->default('Tersedia');
            }
        });
    }

    public function down()
    {
        Schema::table('kelola_ruangan', function (Blueprint $table) {
            if (Schema::hasColumn('kelola_ruangan', 'status')) {
                $table->dropColumn('status');
            }
        });
    }
}; 