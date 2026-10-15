<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GuruSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * Creates 8 guru records
     */
    public function run(): void
    {
        $guruUsers = DB::table('users')
            ->where('role', 'guru')
            ->orderBy('id')
            ->get();

        $guruData = [
            [
                'nip' => '196501011985032001',
                'pangkat' => 'Pembina Tingkat I',
                'no_hp' => '081234567890',
                'alamat' => 'Jl. Pendidikan No. 123, Unduolo',
                'tanggal_lahir' => '1965-01-01',
                'jenis_kelamin' => 'P',
            ],
            [
                'nip' => '197002151990031002',
                'pangkat' => 'Pembina',
                'no_hp' => '081234567891',
                'alamat' => 'Jl. Merdeka No. 45, Unduolo',
                'tanggal_lahir' => '1970-02-15',
                'jenis_kelamin' => 'L',
            ],
            [
                'nip' => '197503201995032003',
                'pangkat' => 'Penata Tingkat I',
                'no_hp' => '081234567892',
                'alamat' => 'Jl. Sudirman No. 67, Unduolo',
                'tanggal_lahir' => '1975-03-20',
                'jenis_kelamin' => 'P',
            ],
            [
                'nip' => '197804251998031004',
                'pangkat' => 'Penata',
                'no_hp' => '081234567893',
                'alamat' => 'Jl. Gatot Subroto No. 89, Unduolo',
                'tanggal_lahir' => '1978-04-25',
                'jenis_kelamin' => 'L',
            ],
            [
                'nip' => '198105301999032005',
                'pangkat' => 'Penata Muda Tingkat I',
                'no_hp' => '081234567894',
                'alamat' => 'Jl. Ahmad Yani No. 12, Unduolo',
                'tanggal_lahir' => '1981-05-30',
                'jenis_kelamin' => 'P',
            ],
            [
                'nip' => '198407052000031006',
                'pangkat' => 'Penata Muda',
                'no_hp' => '081234567895',
                'alamat' => 'Jl. Diponegoro No. 34, Unduolo',
                'tanggal_lahir' => '1984-07-05',
                'jenis_kelamin' => 'L',
            ],
            [
                'nip' => '198708102001032007',
                'pangkat' => 'Penata Muda',
                'no_hp' => '081234567896',
                'alamat' => 'Jl. Kartini No. 56, Unduolo',
                'tanggal_lahir' => '1987-08-10',
                'jenis_kelamin' => 'P',
            ],
            [
                'nip' => '199009152002031008',
                'pangkat' => 'Penata Muda',
                'no_hp' => '081234567897',
                'alamat' => 'Jl. Imam Bonjol No. 78, Unduolo',
                'tanggal_lahir' => '1990-09-15',
                'jenis_kelamin' => 'L',
            ],
        ];

        $guru = [];
        foreach ($guruUsers as $index => $user) {
            if (isset($guruData[$index])) {
                $guru[] = array_merge([
                    'user_id' => $user->id,
                    'created_at' => $user->created_at,
                    'updated_at' => now(),
                ], $guruData[$index]);
            }
        }

        DB::table('guru')->insert($guru);
    }
}
