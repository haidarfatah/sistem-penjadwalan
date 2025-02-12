<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('absensi', function (Blueprint $table) {
            $table->time('jam_masuk')->nullable()->change(); // Ubah menjadi nullable
        });
    }
    
    public function down()
    {
        Schema::table('absensi', function (Blueprint $table) {
            $table->time('jam_masuk')->change(); // Balik ke pengaturan awal jika rollback
        });
    }
    
};
