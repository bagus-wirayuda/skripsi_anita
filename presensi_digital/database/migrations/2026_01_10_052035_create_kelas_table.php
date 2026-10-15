<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Kelas (Class/Grade) table - stores class information
     */
    public function up(): void
    {
        Schema::create('kelas', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kelas', 50)->comment('Nama kelas, e.g., "Kelas 1A", "Kelas 2B"');
            $table->string('tingkat', 10)->comment('Tingkat kelas, e.g., "1", "2", "3", "4", "5", "6"');
            $table->string('wali_kelas', 100)->nullable()->comment('Nama wali kelas');
            $table->text('deskripsi')->nullable();
            $table->integer('kapasitas')->default(30)->comment('Maksimal jumlah siswa');
            $table->timestamps();
            
            // Indexes
            $table->index('tingkat');
            $table->unique('nama_kelas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kelas');
    }
};
