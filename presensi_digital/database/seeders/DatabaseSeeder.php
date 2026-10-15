<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * 
     * Complete seed setup with realistic dummy data:
     * - 1 Admin, 1 Kepsek, 8 Guru, 30 Ortu
     * - 12 Kelas (1A-6B)
     * - 60 Siswa (5 siswa per kelas)
     * - Mapel untuk semua kelas dengan jadwal lengkap
     * - Presensi data untuk 3 bulan terakhir
     * - Nilai data untuk semester 1 dan 2
     * - Penilaian harian data untuk 3 bulan terakhir
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,              // 1. Create users (1 admin, 1 kepsek, 8 guru, 30 ortu)
            KelasSeeder::class,             // 2. Create 12 kelas
            KepsekSeeder::class,            // 3. Create 1 kepsek record
            AdminSeeder::class,             // 4. Create 1 admin record
            GuruSeeder::class,              // 5. Create 8 guru records
            UpdateKelasWaliSeeder::class,   // 6. Update wali_kelas_id in kelas
            OrtuSeeder::class,              // 7. Create 30 ortu records
            SiswaSeeder::class,             // 8. Create 60 siswa records
            MapelSeeder::class,             // 9. Create mapel for all classes
            PresensiSeeder::class,          // 10. Create presensi data (3 months)
            NilaiSeeder::class,             // 11. Create nilai data (semester 1 & 2)
            PenilaianHarianSeeder::class,   // 12. Create penilaian harian data (3 months)
        ]);
    }
}
