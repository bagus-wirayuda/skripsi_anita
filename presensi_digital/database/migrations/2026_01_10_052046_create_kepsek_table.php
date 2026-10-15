<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Kepsek (Kepala Sekolah/Principal) table - extends users table
     * Note: Authentication data is stored in users table
     */
    public function up(): void
    {
        Schema::create('kepsek', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('nip', 20)->unique()->nullable()->comment('Nomor Induk Pegawai');
            $table->string('pangkat', 50)->nullable()->comment('Pangkat golongan');
            $table->string('no_hp', 20)->nullable();
            $table->text('alamat')->nullable();
            $table->timestamps();
            
            // Foreign key constraint
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            
            // Indexes
            $table->index('user_id');
            $table->index('nip');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kepsek');
    }
};
