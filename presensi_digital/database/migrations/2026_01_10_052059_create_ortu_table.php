<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Ortu (Parent/Guardian) table - extends users table
     * Note: Authentication data is stored in users table
     */
    public function up(): void
    {
        Schema::create('ortu', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('nik', 16)->unique()->nullable()->comment('Nomor Induk Kependudukan');
            $table->enum('hubungan', ['Ayah', 'Ibu', 'Wali', 'Lainnya'])->default('Ayah');
            $table->string('pekerjaan', 100)->nullable();
            $table->string('pendidikan', 50)->nullable();
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
            $table->index('nik');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ortu');
    }
};
