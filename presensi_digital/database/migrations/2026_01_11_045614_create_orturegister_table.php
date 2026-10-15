<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * OrtuRegister table - stores pending parent registrations
     * Data will be moved to ortu table after admin approval
     */
    public function up(): void
    {
        Schema::create('orturegister', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Nama lengkap orangtua/wali');
            $table->string('email')->unique()->comment('Email untuk login (akan digunakan saat approval)');
            $table->string('nik', 16)->unique()->nullable()->comment('Nomor Induk Kependudukan');
            $table->enum('hubungan', ['Ayah', 'Ibu', 'Wali', 'Lainnya'])->default('Ayah');
            $table->string('pekerjaan', 100)->nullable();
            $table->string('pendidikan', 50)->nullable();
            $table->string('no_hp', 20)->nullable();
            $table->text('alamat')->nullable();
            $table->timestamps();
            
            // Indexes
            $table->index('email');
            $table->index('nik');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orturegister');
    }
};
