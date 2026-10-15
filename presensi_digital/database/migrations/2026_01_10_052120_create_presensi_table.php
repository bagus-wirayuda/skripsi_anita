<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Presensi (Attendance) table - QR-based attendance records
     * ERD Fix: presensi belongs to siswa, guru, mapel, and ortu (for verification)
     */
    public function up(): void
    {
        Schema::create('presensi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('siswa_id')->comment('Siswa yang melakukan presensi');
            $table->unsignedBigInteger('guru_id')->nullable()->comment('Guru yang memverifikasi');
            $table->unsignedBigInteger('mapel_id')->nullable()->comment('Mata pelajaran');
            $table->unsignedBigInteger('ortu_id')->nullable()->comment('Orang tua yang melakukan presensi (jika via ortu)');
            $table->date('tanggal')->comment('Tanggal presensi');
            $table->time('waktu_masuk')->nullable()->comment('Waktu masuk/scan QR');
            $table->time('waktu_keluar')->nullable()->comment('Waktu keluar');
            $table->enum('status', ['hadir', 'izin', 'sakit', 'alpha', 'terlambat'])->default('hadir');
            $table->string('qr_data', 255)->nullable()->comment('Data QR code yang di-scan');
            $table->text('keterangan')->nullable()->comment('Keterangan tambahan');
            $table->string('lokasi', 255)->nullable()->comment('Lokasi presensi (GPS/alamat)');
            $table->timestamps();
            
            // Foreign key constraints
            $table->foreign('siswa_id')
                  ->references('id')
                  ->on('siswa')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            
            $table->foreign('guru_id')
                  ->references('id')
                  ->on('guru')
                  ->onDelete('set null')
                  ->onUpdate('cascade');
            
            $table->foreign('mapel_id')
                  ->references('id')
                  ->on('mapel')
                  ->onDelete('set null')
                  ->onUpdate('cascade');
            
            $table->foreign('ortu_id')
                  ->references('id')
                  ->on('ortu')
                  ->onDelete('set null')
                  ->onUpdate('cascade');
            
            // Indexes
            $table->index('siswa_id');
            $table->index('guru_id');
            $table->index('mapel_id');
            $table->index('ortu_id');
            $table->index('tanggal');
            $table->index('status');
            
            // Prevent duplicate attendance on same day for same student and subject
            $table->unique(['siswa_id', 'mapel_id', 'tanggal'], 'unique_presensi_per_day');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('presensi');
    }
};
