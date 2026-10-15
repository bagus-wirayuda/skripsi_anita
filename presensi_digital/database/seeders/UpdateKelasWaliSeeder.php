<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UpdateKelasWaliSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * Updates wali_kelas_id in kelas table after guru is created
     */
    public function run(): void
    {
        $guru = DB::table('guru')->orderBy('id')->get();
        $kelas = DB::table('kelas')->orderBy('id')->get();

        if ($guru->isEmpty() || $kelas->isEmpty()) {
            return;
        }

        // Update wali_kelas_id for each kelas
        foreach ($kelas as $index => $kelasItem) {
            $guruIndex = $index % count($guru);
            $guruId = $guru[$guruIndex]->id;
            
            DB::table('kelas')
                ->where('id', $kelasItem->id)
                ->update(['wali_kelas_id' => $guruId]);
        }
    }
}


