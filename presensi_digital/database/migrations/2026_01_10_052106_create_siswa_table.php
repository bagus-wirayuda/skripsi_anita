<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Siswa (Student) table
     * Note: Siswa tidak memiliki user_id karena siswa tidak login (yang login adalah orang tuanya)
     * Email dan no_hp siswa menggunakan data dari orang tua
     */
    public function up(): void
    {
        Schema::create('siswa', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kelas_id')->nullable()->comment('Kelas saat ini');
            $table->unsignedBigInteger('ortu_id')->nullable()->comment('Orang tua/wali siswa');
            $table->string('nama_siswa', 255)->comment('Nama lengkap siswa');
            $table->string('nis', 20)->unique()->nullable()->comment('Nomor Induk Siswa');
            $table->string('nisn', 10)->unique()->nullable()->comment('Nomor Induk Siswa Nasional');
            $table->date('tanggal_lahir')->nullable();
            $table->string('tempat_lahir', 100)->nullable();
            $table->enum('jenis_kelamin', ['L', 'P'])->nullable();
            $table->text('alamat')->nullable();
            $table->string('qr_code', 255)->unique()->nullable()->comment('QR code untuk presensi');
            $table->timestamps();
            
            // Foreign key constraints
            $table->foreign('kelas_id')
                  ->references('id')
                  ->on('kelas')
                  ->onDelete('set null')
                  ->onUpdate('cascade');
            
            $table->foreign('ortu_id')
                  ->references('id')
                  ->on('ortu')
                  ->onDelete('set null')
                  ->onUpdate('cascade');
            
            // Indexes
            $table->index('kelas_id');
            $table->index('ortu_id');
            $table->index('nis');
            $table->index('nisn');
            $table->index('qr_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siswa');
    }
};
