<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class FakultasUserSeeder extends Seeder
{
    public function run(): void
    {
        $fakultasData = [
            'feb' => [
                'name' => 'Admin Fakultas Ekonomi dan Bisnis',
                'email' => 'admin.feb@unsam.ac.id',
            ],
            'fh' => [
                'name' => 'Admin Fakultas Hukum',
                'email' => 'admin.fh@unsam.ac.id',
            ],
            'fp' => [
                'name' => 'Admin Fakultas Pertanian',
                'email' => 'admin.fp@unsam.ac.id',
            ],
            'fkip' => [
                'name' => 'Admin Fakultas Keguruan dan Ilmu Pendidikan',
                'email' => 'admin.fkip@unsam.ac.id',
            ],
            'fst' => [
                'name' => 'Admin Fakultas Sains dan Teknologi',
                'email' => 'admin.fst@unsam.ac.id',
            ],
        ];

        foreach ($fakultasData as $kode => $data) {
            User::updateOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'password' => Hash::make('password123'),
                    'role' => 'user',
                    'fakultas' => $kode,
                ]
            );
        }

        $this->command->info('5 Fakultas users created successfully!');
        $this->command->table(
            ['Email', 'Fakultas', 'Password'],
            collect($fakultasData)->map(fn($d, $k) => [$d['email'], $k, 'password123'])->values()->toArray()
        );
    }
}
