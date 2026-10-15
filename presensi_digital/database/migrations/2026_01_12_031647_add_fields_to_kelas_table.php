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
        Schema::table('kelas', function (Blueprint $table) {
            // Add urutan_kelas (class order: 1-6)
            $table->integer('urutan_kelas')->nullable()->after('tingkat')->comment('Urutan kelas (1-6)');
            
            // Add rombel (section: A, B, C, etc.)
            $table->string('rombel', 10)->nullable()->after('urutan_kelas')->comment('Rombongan belajar (A, B, C, etc.)');
            
            // Add wali_kelas_id (foreign key to guru)
            $table->unsignedBigInteger('wali_kelas_id')->nullable()->after('wali_kelas')->comment('ID Wali kelas (guru)');
            
            // Add catatan (notes)
            $table->text('catatan')->nullable()->after('deskripsi')->comment('Catatan tentang kelas');
            
            // Add foreign key constraint for wali_kelas_id
            $table->foreign('wali_kelas_id')
                  ->references('id')
                  ->on('guru')
                  ->onDelete('set null')
                  ->onUpdate('cascade');
            
            // Add indexes
            $table->index('urutan_kelas');
            $table->index('rombel');
            $table->index('wali_kelas_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kelas', function (Blueprint $table) {
            // Drop foreign key first
            $table->dropForeign(['wali_kelas_id']);
            
            // Drop indexes
            $table->dropIndex(['urutan_kelas']);
            $table->dropIndex(['rombel']);
            $table->dropIndex(['wali_kelas_id']);
            
            // Drop columns
            $table->dropColumn(['urutan_kelas', 'rombel', 'wali_kelas_id', 'catatan']);
        });
    }
};
