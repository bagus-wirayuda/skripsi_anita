<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NilaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * Creates nilai data for semester 1 and 2
     */
    public function run(): void
    {
        $siswa = DB::table('siswa')->get();
        $mapel = DB::table('mapel')->get();

        $semester = ['1', '2'];
        $nilai = [];

        foreach ($siswa as $siswaItem) {
            // Get mapel for this siswa's class
            $mapelKelas = $mapel->where('kelas_id', $siswaItem->kelas_id);
            
            foreach ($semester as $sem) {
                foreach ($mapelKelas as $mapelItem) {
                    // Generate nilai dengan variasi yang realistis
                    $nilaiTugas = $this->generateNilai(60, 100);
                    $nilaiUts = $this->generateNilai(50, 95);
                    $nilaiUas = $this->generateNilai(55, 100);
                    
                    // Hitung nilai akhir (rata-rata)
                    $nilaiAkhir = round(($nilaiTugas + $nilaiUts + $nilaiUas) / 3, 2);
                    
                    // Tentukan predikat
                    $predikat = $this->getPredikat($nilaiAkhir);

                    $nilai[] = [
                        'siswa_id' => $siswaItem->id,
                        'mapel_id' => $mapelItem->id,
                        'kelas_id' => $siswaItem->kelas_id,
                        'semester' => $sem,
                        'nilai_tugas' => $nilaiTugas,
                        'nilai_uts' => $nilaiUts,
                        'nilai_uas' => $nilaiUas,
                        'nilai_akhir' => $nilaiAkhir,
                        'predikat' => $predikat,
                        'keterangan' => "Nilai semester {$sem}",
                        'created_at' => $sem === '1' ? now()->subMonths(6) : now()->subMonths(1),
                        'updated_at' => now(),
                    ];
                }
            }
        }

        // Insert in chunks
        foreach (array_chunk($nilai, 500) as $chunk) {
            DB::table('nilai')->insert($chunk);
        }
    }

    private function generateNilai($min, $max)
    {
        // Generate nilai dengan distribusi normal (lebih banyak nilai bagus)
        $rand = rand(1, 100);
        if ($rand <= 20) {
            // 20% nilai rendah (60-75)
            return round(rand(60, 75) + (rand(0, 9) / 10), 1);
        } elseif ($rand <= 50) {
            // 30% nilai sedang (75-85)
            return round(rand(75, 85) + (rand(0, 9) / 10), 1);
        } else {
            // 50% nilai bagus (85-100)
            return round(rand(85, 100) + (rand(0, 9) / 10), 1);
        }
    }

    private function getPredikat($nilai)
    {
        if ($nilai >= 90) return 'A';
        if ($nilai >= 80) return 'B';
        if ($nilai >= 70) return 'C';
        if ($nilai >= 60) return 'D';
        return 'E';
    }
}
