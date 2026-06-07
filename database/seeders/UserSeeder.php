<?php

namespace Database\Seeders;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tenants = [
            [
                'name' => 'PT Nusantara Digital',
                'users' => [
                    ['name' => 'Budi Santoso', 'role' => 'admin'],
                    ['name' => 'Siti Rahma', 'role' => 'editor'],
                    ['name' => 'Andi Pratama', 'role' => 'viewer'],
                ]
            ],
            [
                'name' => 'CV Teknologi Maju',
                'users' => [
                    ['name' => 'Dewi Lestari', 'role' => 'admin'],
                    ['name' => 'Rizky Saputra', 'role' => 'editor'],
                    ['name' => 'Fajar Nugroho', 'role' => 'viewer'],
                ]
            ]
        ];

        foreach ($tenants as $tenantData) {
            $tenant = Tenant::create([
                'name' => $tenantData['name'],
            ]);

            foreach ($tenantData['users'] as $userData) {

                User::create([
                    'name'      => $userData['name'],
                    'email'     => strtolower(str_replace(' ', '', $userData['name'])) . '@flowforge.com',
                    'role'      => $userData['role'],
                    'tenant_id' => $tenant->id,
                    'password'  => Hash::make('12345678'),
                ]);
            }
        }
    }
}
