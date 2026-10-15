<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Nilai (Grade/Score) table - stores student grades
     * ERD Fix: nilai belongs to siswa, mapel, and kelas
     */
    public function up(): void
    {
        Schema::create('nilai', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('siswa_id')->comment('Siswa pemilik nilai');
            $table->unsignedBigInteger('mapel_id')->comment('Mata pelajaran');
            $table->unsignedBigInteger('kelas_id')->comment('Kelas saat nilai diberikan');
            $table->string('semester', 10)->comment('Semester, e.g., "1", "2", "Ganjil", "Genap"');
            $table->decimal('nilai_tugas', 5, 2)->nullable()->comment('Nilai tugas (0-100)');
            $table->decimal('nilai_uts', 5, 2)->nullable()->comment('Nilai UTS (0-100)');
            $table->decimal('nilai_uas', 5, 2)->nullable()->comment('Nilai UAS (0-100)');
            $table->decimal('nilai_akhir', 5, 2)->nullable()->comment('Nilai akhir (rata-rata)');
            $table->string('predikat', 10)->nullable()->comment('Predikat, e.g., "A", "B", "C", "D"');
            $table->text('keterangan')->nullable();
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
            
            $table->foreign('kelas_id')
                  ->references('id')
                  ->on('kelas')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            
            // Indexes
            $table->index('siswa_id');
            $table->index('mapel_id');
            $table->index('kelas_id');
            $table->index('semester');
            
            // One grade per student per subject per semester
            $table->unique(['siswa_id', 'mapel_id', 'semester'], 'unique_nilai_per_semester');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilai');
    }
};
