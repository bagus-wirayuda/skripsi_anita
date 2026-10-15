<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KepsekSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * Creates kepsek records linked to users with role 'kepsek'
     */
    public function run(): void
    {
        // Get user ID for kepsek role (first user based on UserSeeder order)
        $kepsekUser = DB::table('users')
            ->where('role', 'kepsek')
            ->first();

        if ($kepsekUser) {
            $kepsek = [
                [
                    'user_id' => $kepsekUser->id,
                    'nip' => '196001011980031001',
                    'pangkat' => 'Pembina Utama Muda',
                    'no_hp' => '081234567800',
                    'alamat' => 'Jl. Kepala Sekolah No. 1, Unduolo',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ];

            DB::table('kepsek')->insert($kepsek);
        }
    }
}
