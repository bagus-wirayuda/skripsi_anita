<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * Creates 60 siswa records (5 siswa per kelas)
     */
    public function run(): void
    {
        $kelas = DB::table('kelas')->orderBy('id')->get();
        $ortu = DB::table('ortu')->orderBy('id')->get();

        $namaSiswa = [
            'Andi Pratama', 'Siti Nurhaliza', 'Budi Santoso', 'Rina Wati', 'Ahmad Fauzi',
            'Siti Fatimah', 'Muhammad Rizki', 'Dewi Sartika', 'Hendra Gunawan', 'Lina Marlina',
            'Ahmad Yani', 'Siti Rahayu', 'Bambang Sutrisno', 'Ratna Dewi', 'Ahmad Zulkarnain',
            'Siti Maimunah', 'Joko Widodo', 'Siti Nurjanah', 'Ahmad Dahlan', 'Rina Sari',
            'Budi Prasetyo', 'Siti Khadijah', 'Ahmad Syarif', 'Dewi Lestari', 'Muhammad Ali',
            'Siti Aisyah', 'Ahmad Rizki', 'Lina Sari', 'Budi Hartono', 'Siti Maryam',
            'Ahmad Fadil', 'Siti Zulaikha', 'Budi Kurniawan', 'Rina Permata', 'Ahmad Maulana',
            'Siti Khairunnisa', 'Muhammad Fikri', 'Dewi Anggraini', 'Hendra Wijaya', 'Lina Kurnia',
            'Ahmad Rizaldi', 'Siti Nurul', 'Bambang Hidayat', 'Ratna Sari', 'Ahmad Firdaus',
            'Siti Mardiyah', 'Joko Susilo', 'Siti Nurhayati', 'Ahmad Fauzan', 'Rina Kartika',
            'Budi Setiawan', 'Siti Khoiriyah', 'Ahmad Syahputra', 'Dewi Puspita', 'Muhammad Iqbal',
            'Siti Nurhasanah', 'Ahmad Fauzi', 'Lina Wulandari', 'Budi Santosa', 'Siti Nurhalimah',
        ];

        $tempatLahir = ['Unduolo', 'Jakarta', 'Bandung', 'Surabaya', 'Yogyakarta', 'Medan', 'Semarang', 'Makassar', 'Palembang', 'Denpasar'];
        $jenisKelamin = ['L', 'P'];

        $siswa = [];
        $ortuIndex = 0;
        $nisCounter = 2024001;
        $nisnCounter = 1001234567;

        foreach ($kelas as $kelasItem) {
            for ($i = 0; $i < 5; $i++) {
                $siswaIndex = count($siswa);
                $jenisKel = $jenisKelamin[$siswaIndex % 2];
                $tanggalLahir = now()->subYears(6 + (int)$kelasItem->tingkat)->subDays(rand(1, 365));
                
                $siswa[] = [
                    'kelas_id' => $kelasItem->id,
                    'ortu_id' => $ortu[$ortuIndex % count($ortu)]->id,
                    'nama_siswa' => $namaSiswa[$siswaIndex % count($namaSiswa)] . ' ' . ($siswaIndex > count($namaSiswa) - 1 ? ($siswaIndex + 1) : ''),
                    'nis' => (string)$nisCounter,
                    'nisn' => (string)$nisnCounter,
                    'tanggal_lahir' => $tanggalLahir->format('Y-m-d'),
                    'tempat_lahir' => $tempatLahir[$siswaIndex % count($tempatLahir)],
                    'jenis_kelamin' => $jenisKel,
                    'alamat' => 'Jl. Raya Unduolo No. ' . (200 + $siswaIndex),
                    'qr_code' => 'SDN1-UNDUOLO-' . $nisCounter,
                    'created_at' => now()->subMonths(11)->addDays($siswaIndex),
                    'updated_at' => now(),
                ];
                
                $ortuIndex++;
                $nisCounter++;
                $nisnCounter++;
            }
        }

        DB::table('siswa')->insert($siswa);
    }
}
