<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrtuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * Creates 30 ortu records
     */
    public function run(): void
    {
        $ortuUsers = DB::table('users')
            ->where('role', 'ortu')
            ->orderBy('id')
            ->get();

        $hubungan = ['Ayah', 'Ibu', 'Wali'];
        $pekerjaan = ['Pegawai Swasta', 'PNS', 'Wiraswasta', 'Petani', 'Guru', 'Dokter', 'Perawat', 'Pedagang', 'Buruh', 'Pensiunan'];
        $pendidikan = ['SD', 'SMP', 'SMA', 'D3', 'S1', 'S2'];
        
        $ortu = [];
        foreach ($ortuUsers as $index => $user) {
            $ortu[] = [
                'user_id' => $user->id,
                'nik' => '320101' . str_pad(650101 + $index, 10, '0', STR_PAD_LEFT),
                'hubungan' => $hubungan[$index % count($hubungan)],
                'pekerjaan' => $pekerjaan[$index % count($pekerjaan)],
                'pendidikan' => $pendidikan[$index % count($pendidikan)],
                'no_hp' => '0812' . str_pad(34567800 + $index, 8, '0', STR_PAD_LEFT),
                'alamat' => 'Jl. Raya Unduolo No. ' . (100 + $index),
                'created_at' => $user->created_at,
                'updated_at' => now(),
            ];
        }

        DB::table('ortu')->insert($ortu);
    }
}
