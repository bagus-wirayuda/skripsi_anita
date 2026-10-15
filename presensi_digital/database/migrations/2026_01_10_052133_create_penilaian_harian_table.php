<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Penilaian Harian (Daily Assessment) table - daily student assessments
     * ERD Fix: penilaian_harian belongs to siswa and mapel
     */
    public function up(): void
    {
        Schema::create('penilaian_harian', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('siswa_id')->comment('Siswa yang dinilai');
            $table->unsignedBigInteger('mapel_id')->comment('Mata pelajaran');
            $table->date('tanggal')->comment('Tanggal penilaian');
            $table->string('jenis_penilaian', 50)->comment('Jenis penilaian, e.g., "Kuis", "Tugas", "Praktik"');
            $table->decimal('nilai', 5, 2)->comment('Nilai (0-100)');
            $table->text('deskripsi')->nullable()->comment('Deskripsi penilaian');
            $table->text('catatan_guru')->nullable()->comment('Catatan dari guru');
            $table->timestamps();
            
            // Foreign key constraints
            $table->foreign('siswa_id')
                  ->references('id')
                  ->on('siswa')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            
            $table->foreign('mapel_id')
                  ->references('id')
                  ->on('mapel')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            
            // Indexes
            $table->index('siswa_id');
            $table->index('mapel_id');
            $table->index('tanggal');
            $table->index('jenis_penilaian');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penilaian_harian');
    }
};
