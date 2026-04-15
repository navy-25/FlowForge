<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::create([
            'name' => 'Sryiani',
            'email' => 'admin@flowforge.com',
            'role' => 'admin',
            'password' => Hash::make('12345678'),
        ]);
        User::create([
            'name' => 'Dendi Arman',
            'email' => 'viewer@flowforge.com',
            'role' => 'viewer',
            'password' => Hash::make('12345678'),
        ]);
        User::create([
            'name' => 'Naerika',
            'email' => 'editor@flowforge.com',
            'role' => 'editor',
            'password' => Hash::make('12345678'),
        ]);
    }
}
