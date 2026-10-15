<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * Creates 1 admin record
     */
    public function run(): void
    {
        // Get user ID for admin role
        $adminUser = DB::table('users')
            ->where('role', 'admin')
            ->first();

        if ($adminUser) {
            $admin = [
                [
                    'user_id' => $adminUser->id,
                    'nip' => '198501011990031001',
                    'jabatan' => 'Admin Sistem',
                    'no_hp' => '081234567850',
                    'alamat' => 'Jl. Administrasi No. 10, Unduolo',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ];

            DB::table('admin')->insert($admin);
        }
    }
}
