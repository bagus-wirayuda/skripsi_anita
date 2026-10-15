<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PenilaianHarianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * Creates penilaian harian data for last 3 months
     */
    public function run(): void
    {
        $siswa = DB::table('siswa')->get();
        $mapel = DB::table('mapel')->get();

        $jenisPenilaian = ['Kuis', 'Tugas', 'Praktik', 'Ulangan Harian', 'Proyek', 'Portofolio'];
        $jenisWeights = [
            'Tugas' => 40,          // 40% tugas
            'Kuis' => 20,           // 20% kuis
            'Ulangan Harian' => 15, // 15% ulangan harian
            'Praktik' => 10,        // 10% praktik
            'Proyek' => 10,         // 10% proyek
            'Portofolio' => 5,      // 5% portofolio
        ];

        $penilaianHarian = [];
        $tanggalAwal = Carbon::now()->subMonths(3)->startOfMonth();
        $tanggalAkhir = Carbon::now()->subDay();

        foreach ($siswa as $siswaItem) {
            // Get mapel for this siswa's class
            $mapelKelas = $mapel->where('kelas_id', $siswaItem->kelas_id);
            
            if ($mapelKelas->isEmpty()) {
                continue;
            }

            $tanggal = $tanggalAwal->copy();
            
            while ($tanggal->lte($tanggalAkhir)) {
                // Skip weekends
                if ($tanggal->isWeekend()) {
                    $tanggal->addDay();
                    continue;
                }

                // Get mapel for this day
                $hariNama = $this->getHariIndonesia($tanggal->dayOfWeek);
                $mapelHariIni = $mapelKelas->where('hari', $hariNama);

                // Random chance untuk ada penilaian (60% chance per hari)
                if (rand(1, 100) <= 60) {
                    foreach ($mapelHariIni as $mapelItem) {
                        // Random jenis penilaian based on weights
                        $rand = rand(1, 100);
                        $jenis = 'Tugas';
                        $cumulative = 0;
                        
                        foreach ($jenisWeights as $jenisItem => $weight) {
                            $cumulative += $weight;
                            if ($rand <= $cumulative) {
                                $jenis = $jenisItem;
                                break;
                            }
                        }

                        // Generate nilai (0-100)
                        $nilai = $this->generateNilai(50, 100);

                        // Deskripsi
                        $deskripsi = "Penilaian {$jenis} pada tanggal " . $tanggal->format('d F Y');

                        // Catatan guru (30% chance ada catatan)
                        $catatanGuru = null;
                        if (rand(1, 100) <= 30) {
                            $catatan = [
                                "Sangat baik, terus pertahankan!",
                                "Perlu peningkatan dalam memahami materi.",
                                "Kerja bagus, sudah menunjukkan kemajuan.",
                                "Perlu lebih banyak latihan.",
                                "Sangat memuaskan, pertahankan prestasinya!",
                                "Perlu perhatian lebih dalam mengerjakan tugas.",
                            ];
                            $catatanGuru = $catatan[rand(0, count($catatan) - 1)];
                        }

                        $penilaianHarian[] = [
                            'siswa_id' => $siswaItem->id,
                            'mapel_id' => $mapelItem->id,
                            'tanggal' => $tanggal->format('Y-m-d'),
                            'jenis_penilaian' => $jenis,
                            'nilai' => $nilai,
                            'deskripsi' => $deskripsi,
                            'catatan_guru' => $catatanGuru,
                            'created_at' => $tanggal->copy()->setTime(rand(14, 16), rand(0, 59), 0),
                            'updated_at' => now(),
                        ];
                    }
                }

                $tanggal->addDay();
            }
        }

        // Insert in chunks
        foreach (array_chunk($penilaianHarian, 500) as $chunk) {
            DB::table('penilaian_harian')->insert($chunk);
        }
    }

    private function generateNilai($min, $max)
    {
        $rand = rand(1, 100);
        if ($rand <= 15) {
            // 15% nilai rendah (50-70)
            return round(rand(50, 70) + (rand(0, 9) / 10), 2);
        } elseif ($rand <= 40) {
            // 25% nilai sedang (70-85)
            return round(rand(70, 85) + (rand(0, 9) / 10), 2);
        } else {
            // 60% nilai bagus (85-100)
            return round(rand(85, 100) + (rand(0, 9) / 10), 2);
        }
    }

    private function getHariIndonesia($dayOfWeek)
    {
        $hari = [
            0 => 'Minggu',
            1 => 'Senin',
            2 => 'Selasa',
            3 => 'Rabu',
            4 => 'Kamis',
            5 => 'Jumat',
            6 => 'Sabtu',
        ];
        
        return $hari[$dayOfWeek] ?? 'Senin';
    }
}
