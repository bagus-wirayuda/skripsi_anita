<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * Creates users: 1 admin, 1 kepsek, 8 guru, 30 ortu
     */
    public function run(): void
    {
        $users = [
            // Kepala Sekolah
            [
                'name' => 'Dr. Ahmad Hidayat, M.Pd',
                'email' => 'kepsek@sdn1unduolo.sch.id',
                'password' => Hash::make('password123'),
                'role' => 'kepsek',
                'email_verified_at' => now(),
                'created_at' => now()->subMonths(12),
                'updated_at' => now(),
            ],
            
            // Admin
            [
                'name' => 'Siti Nurhaliza',
                'email' => 'admin@sdn1unduolo.sch.id',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'email_verified_at' => now(),
                'created_at' => now()->subMonths(12),
                'updated_at' => now(),
            ],
            
            // Guru (8 guru)
            [
                'name' => 'Dra. Siti Aisyah',
                'email' => 'siti.aisyah@sdn1unduolo.sch.id',
                'password' => Hash::make('password123'),
                'role' => 'guru',
                'email_verified_at' => now(),
                'created_at' => now()->subMonths(12),
                'updated_at' => now(),
            ],
            [
                'name' => 'Budi Santoso, S.Pd',
                'email' => 'budi.santoso@sdn1unduolo.sch.id',
                'password' => Hash::make('password123'),
                'role' => 'guru',
                'email_verified_at' => now(),
                'created_at' => now()->subMonths(11),
                'updated_at' => now(),
            ],
            [
                'name' => 'Rina Wati, S.Pd',
                'email' => 'rina.wati@sdn1unduolo.sch.id',
                'password' => Hash::make('password123'),
                'role' => 'guru',
                'email_verified_at' => now(),
                'created_at' => now()->subMonths(11),
                'updated_at' => now(),
            ],
            [
                'name' => 'Ahmad Fauzi, S.Pd',
                'email' => 'ahmad.fauzi@sdn1unduolo.sch.id',
                'password' => Hash::make('password123'),
                'role' => 'guru',
                'email_verified_at' => now(),
                'created_at' => now()->subMonths(10),
                'updated_at' => now(),
            ],
            [
                'name' => 'Siti Fatimah, S.Pd',
                'email' => 'siti.fatimah@sdn1unduolo.sch.id',
                'password' => Hash::make('password123'),
                'role' => 'guru',
                'email_verified_at' => now(),
                'created_at' => now()->subMonths(10),
                'updated_at' => now(),
            ],
            [
                'name' => 'Muhammad Rizki, S.Pd',
                'email' => 'muhammad.rizki@sdn1unduolo.sch.id',
                'password' => Hash::make('password123'),
                'role' => 'guru',
                'email_verified_at' => now(),
                'created_at' => now()->subMonths(9),
                'updated_at' => now(),
            ],
            [
                'name' => 'Dewi Sartika, S.Pd',
                'email' => 'dewi.sartika@sdn1unduolo.sch.id',
                'password' => Hash::make('password123'),
                'role' => 'guru',
                'email_verified_at' => now(),
                'created_at' => now()->subMonths(9),
                'updated_at' => now(),
            ],
            [
                'name' => 'Hendra Gunawan, S.Pd',
                'email' => 'hendra.gunawan@sdn1unduolo.sch.id',
                'password' => Hash::make('password123'),
                'role' => 'guru',
                'email_verified_at' => now(),
                'created_at' => now()->subMonths(8),
                'updated_at' => now(),
            ],
        ];

        // Orang Tua (30 ortu)
        $ortuNames = [
            ['Ahmad Hidayat', 'ahmad.hidayat@email.com'],
            ['Siti Nurhaliza', 'siti.nurhaliza@email.com'],
            ['Budi Santoso', 'budi.santoso@email.com'],
            ['Rina Wati', 'rina.wati@email.com'],
            ['Ahmad Fauzi', 'ahmad.fauzi@email.com'],
            ['Siti Fatimah', 'siti.fatimah@email.com'],
            ['Muhammad Rizki', 'muhammad.rizki@email.com'],
            ['Dewi Sartika', 'dewi.sartika@email.com'],
            ['Hendra Gunawan', 'hendra.gunawan@email.com'],
            ['Lina Marlina', 'lina.marlina@email.com'],
            ['Ahmad Yani', 'ahmad.yani@email.com'],
            ['Siti Rahayu', 'siti.rahayu@email.com'],
            ['Bambang Sutrisno', 'bambang.sutrisno@email.com'],
            ['Ratna Dewi', 'ratna.dewi@email.com'],
            ['Ahmad Zulkarnain', 'ahmad.zulkarnain@email.com'],
            ['Siti Maimunah', 'siti.maimunah@email.com'],
            ['Joko Widodo', 'joko.widodo@email.com'],
            ['Siti Nurjanah', 'siti.nurjanah@email.com'],
            ['Ahmad Dahlan', 'ahmad.dahlan@email.com'],
            ['Rina Sari', 'rina.sari@email.com'],
            ['Budi Prasetyo', 'budi.prasetyo@email.com'],
            ['Siti Khadijah', 'siti.khadijah@email.com'],
            ['Ahmad Syarif', 'ahmad.syarif@email.com'],
            ['Dewi Lestari', 'dewi.lestari@email.com'],
            ['Muhammad Ali', 'muhammad.ali@email.com'],
            ['Siti Aisyah', 'siti.aisyah.ortu@email.com'],
            ['Ahmad Rizki', 'ahmad.rizki@email.com'],
            ['Lina Sari', 'lina.sari@email.com'],
            ['Budi Hartono', 'budi.hartono@email.com'],
            ['Siti Maryam', 'siti.maryam@email.com'],
        ];

        foreach ($ortuNames as $index => $ortu) {
            $users[] = [
                'name' => $ortu[0],
                'email' => $ortu[1],
                'password' => Hash::make('password123'),
                'role' => 'ortu',
                'email_verified_at' => now()->subMonths(11)->addDays($index),
                'created_at' => now()->subMonths(11)->addDays($index),
                'updated_at' => now(),
            ];
        }

        DB::table('users')->insert($users);
    }
}
