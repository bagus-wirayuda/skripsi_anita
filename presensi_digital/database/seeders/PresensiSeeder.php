<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PresensiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * Creates presensi data for last 3 months
     */
    public function run(): void
    {
        $siswa = DB::table('siswa')->get();
        $mapel = DB::table('mapel')->get();
        $guru = DB::table('guru')->get();

        $statusList = ['hadir', 'izin', 'sakit', 'alpha', 'terlambat'];
        $statusWeights = [
            'hadir' => 70,      // 70% hadir
            'izin' => 10,       // 10% izin
            'sakit' => 10,      // 10% sakit
            'alpha' => 5,       // 5% alpha
            'terlambat' => 5,   // 5% terlambat
        ];

        $presensi = [];
        $tanggalAwal = Carbon::now()->subMonths(3)->startOfMonth();
        $tanggalAkhir = Carbon::now()->subDay();

        // Generate presensi untuk setiap siswa
        foreach ($siswa as $siswaItem) {
            // Get mapel for this siswa's class
            $mapelKelas = $mapel->where('kelas_id', $siswaItem->kelas_id);
            
            if ($mapelKelas->isEmpty()) {
                continue;
            }

            $tanggal = $tanggalAwal->copy();
            
            while ($tanggal->lte($tanggalAkhir)) {
                // Skip weekends (Sabtu dan Minggu)
                if ($tanggal->isWeekend()) {
                    $tanggal->addDay();
                    continue;
                }

                // Get mapel for this day
                $hariNama = $this->getHariIndonesia($tanggal->dayOfWeek);
                $mapelHariIni = $mapelKelas->where('hari', $hariNama);

                foreach ($mapelHariIni as $mapelItem) {
                    // Random status based on weights
                    $rand = rand(1, 100);
                    $status = 'hadir';
                    $cumulative = 0;
                    
                    foreach ($statusWeights as $stat => $weight) {
                        $cumulative += $weight;
                        if ($rand <= $cumulative) {
                            $status = $stat;
                            break;
                        }
                    }

                    // Get guru for this mapel
                    $guruMapel = $guru->where('id', $mapelItem->guru_id)->first();
                    $guruId = $guruMapel ? $guruMapel->id : null;

                    // Waktu masuk (jika hadir atau terlambat)
                    $waktuMasuk = null;
                    if ($status === 'hadir') {
                        $jamMulai = Carbon::parse($mapelItem->jam_mulai);
                        $waktuMasuk = $jamMulai->addMinutes(rand(-5, 10))->format('H:i:s');
                    } elseif ($status === 'terlambat') {
                        $jamMulai = Carbon::parse($mapelItem->jam_mulai);
                        $waktuMasuk = $jamMulai->addMinutes(rand(10, 30))->format('H:i:s');
                    }

                    $presensi[] = [
                        'siswa_id' => $siswaItem->id,
                        'guru_id' => $guruId,
                        'mapel_id' => $mapelItem->id,
                        'ortu_id' => null,
                        'tanggal' => $tanggal->format('Y-m-d'),
                        'waktu_masuk' => $waktuMasuk,
                        'waktu_keluar' => null,
                        'status' => $status,
                        'qr_data' => $siswaItem->qr_code,
                        'keterangan' => $status === 'izin' ? 'Izin dari orang tua' : ($status === 'sakit' ? 'Sakit' : null),
                        'lokasi' => 'SDN 1 Unduolo',
                        'created_at' => $tanggal->copy()->setTime(rand(7, 8), rand(0, 59), 0),
                        'updated_at' => now(),
                    ];
                }

                $tanggal->addDay();
            }
        }

        // Insert in chunks to avoid memory issues
        foreach (array_chunk($presensi, 500) as $chunk) {
            DB::table('presensi')->insert($chunk);
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
