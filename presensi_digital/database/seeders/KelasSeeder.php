<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * Creates 12 kelas (1A-6B)
     */
    public function run(): void
    {
        $kelas = [];
        $tingkat = [1, 2, 3, 4, 5, 6];
        $rombel = ['A', 'B'];
        
        $waliKelasNames = [
            'Dra. Siti Aisyah',
            'Budi Santoso, S.Pd',
            'Rina Wati, S.Pd',
            'Ahmad Fauzi, S.Pd',
            'Siti Fatimah, S.Pd',
            'Muhammad Rizki, S.Pd',
            'Dewi Sartika, S.Pd',
            'Hendra Gunawan, S.Pd',
            'Dra. Siti Aisyah', // Guru bisa wali 2 kelas
            'Budi Santoso, S.Pd',
            'Rina Wati, S.Pd',
            'Ahmad Fauzi, S.Pd',
        ];

        $index = 0;
        foreach ($tingkat as $t) {
            foreach ($rombel as $r) {
                // wali_kelas_id akan diupdate setelah guru dibuat
                $kelas[] = [
                    'nama_kelas' => $t . $r,
                    'tingkat' => (string)$t,
                    'urutan_kelas' => $t,
                    'rombel' => $r,
                    'wali_kelas' => $waliKelasNames[$index],
                    'wali_kelas_id' => null, // Will be updated after guru is created
                    'deskripsi' => "Kelas {$t}{$r} - Semester Ganjil 2024/2025",
                    'kapasitas' => 30,
                    'catatan' => "Kelas {$t}{$r} dengan kapasitas 30 siswa",
                    'created_at' => now()->subMonths(12),
                    'updated_at' => now(),
                ];
                $index++;
            }
        }

        DB::table('kelas')->insert($kelas);
        
        // Update wali_kelas_id after guru is created (will be done in a separate update)
        // This will be handled after GuruSeeder runs
    }
}
