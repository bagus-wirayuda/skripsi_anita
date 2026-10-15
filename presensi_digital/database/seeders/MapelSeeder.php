<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MapelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * Creates mapel for all classes with schedule
     */
    public function run(): void
    {
        $kelas = DB::table('kelas')->orderBy('id')->get();
        $guru = DB::table('guru')->orderBy('id')->get();

        // Mapel untuk SD kelas 1-6
        $mapelList = [
            'Pendidikan Agama Islam',
            'Pendidikan Pancasila dan Kewarganegaraan',
            'Bahasa Indonesia',
            'Matematika',
            'Ilmu Pengetahuan Alam',
            'Ilmu Pengetahuan Sosial',
            'Seni Budaya dan Prakarya',
            'Pendidikan Jasmani, Olahraga dan Kesehatan',
            'Bahasa Inggris',
        ];

        $kodeMapel = [
            'PAI', 'PPKN', 'BIN', 'MTK', 'IPA', 'IPS', 'SBDP', 'PJOK', 'BING'
        ];

        // Jadwal per hari
        $jadwalHari = [
            'Senin' => ['08:00', '09:00', '10:00', '11:00', '13:00', '14:00'],
            'Selasa' => ['08:00', '09:00', '10:00', '11:00', '13:00', '14:00'],
            'Rabu' => ['08:00', '09:00', '10:00', '11:00', '13:00', '14:00'],
            'Kamis' => ['08:00', '09:00', '10:00', '11:00', '13:00', '14:00'],
            'Jumat' => ['08:00', '09:00', '10:00', '11:00'],
            'Sabtu' => ['08:00', '09:00', '10:00', '11:00'],
        ];

        $hariList = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        
        $mapel = [];
        $guruIndex = 0;
        $kodeCounter = 1;

        foreach ($kelas as $kelasItem) {
            $hariIndex = 0;
            $jamIndex = 0;
            
            foreach ($mapelList as $index => $namaMapel) {
                $hari = $hariList[$hariIndex % count($hariList)];
                $jamMulai = $jadwalHari[$hari][$jamIndex % count($jadwalHari[$hari])];
                
                // Hitung jam selesai (1 jam pelajaran = 40 menit)
                $jamMulaiTime = strtotime($jamMulai);
                $jamSelesaiTime = $jamMulaiTime + (40 * 60); // 40 menit
                $jamSelesai = date('H:i:s', $jamSelesaiTime);
                
                $kodeMapelFull = $kodeMapel[$index] . '-' . $kelasItem->tingkat . $kelasItem->rombel . '-' . str_pad($kodeCounter, 3, '0', STR_PAD_LEFT);
                
                $mapel[] = [
                    'guru_id' => $guru[$guruIndex % count($guru)]->id,
                    'kelas_id' => $kelasItem->id,
                    'nama_mapel' => $namaMapel,
                    'kode_mapel' => $kodeMapelFull,
                    'hari' => $hari,
                    'jam_mulai' => $jamMulai,
                    'jam_selesai' => $jamSelesai,
                    'jam_per_minggu' => 2,
                    'deskripsi' => "Mata pelajaran {$namaMapel} untuk kelas {$kelasItem->nama_kelas}",
                    'created_at' => now()->subMonths(11),
                    'updated_at' => now(),
                ];

                $guruIndex++;
                $kodeCounter++;
                $hariIndex++;
                
                // Reset jam index setiap 2 mapel per hari
                if (($index + 1) % 2 == 0) {
                    $jamIndex++;
                }
            }
        }

        DB::table('mapel')->insert($mapel);
    }
}
