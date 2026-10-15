<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Mapel (Subject/Mata Pelajaran) table
     * ERD Fix: mapel belongs to guru (teacher) and kelas (class)
     */
    public function up(): void
    {
        Schema::create('mapel', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('guru_id')->comment('Guru pengajar');
            $table->unsignedBigInteger('kelas_id')->comment('Kelas yang diajar');
            $table->string('nama_mapel', 100)->comment('Nama mata pelajaran');
            $table->string('kode_mapel', 20)->unique()->comment('Kode mata pelajaran');
            $table->integer('jam_per_minggu')->default(2)->comment('Jumlah jam pelajaran per minggu');
            $table->text('deskripsi')->nullable();
            $table->timestamps();
            
            // Foreign key constraints
            $table->foreign('guru_id')
                  ->references('id')
                  ->on('guru')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            
            $table->foreign('kelas_id')
                  ->references('id')
                  ->on('kelas')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            
            // Indexes
            $table->index('guru_id');
            $table->index('kelas_id');
            $table->index('kode_mapel');
            
            // Unique constraint: one teacher can teach one subject per class
            $table->unique(['guru_id', 'kelas_id', 'kode_mapel']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mapel');
    }
};
