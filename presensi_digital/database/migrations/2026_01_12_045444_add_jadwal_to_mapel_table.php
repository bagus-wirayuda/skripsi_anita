<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('mapel', function (Blueprint $table) {
            // Add jadwal fields
            $table->enum('hari', ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'])->nullable()->after('kode_mapel')->comment('Hari pelajaran');
            $table->time('jam_mulai')->nullable()->after('hari')->comment('Jam mulai pelajaran');
            $table->time('jam_selesai')->nullable()->after('jam_mulai')->comment('Jam selesai pelajaran');
            
            // Index for hari
            $table->index('hari');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mapel', function (Blueprint $table) {
            // Drop indexes
            $table->dropIndex(['hari']);
            
            // Drop columns
            $table->dropColumn(['hari', 'jam_mulai', 'jam_selesai']);
        });
    }
};
