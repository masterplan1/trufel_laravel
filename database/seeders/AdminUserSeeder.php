<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'trufel',
            'email' => 'masterplan1@ukr.net',
            'email_verified_at' => now(),
            'password' => bcrypt('trufelbakeryUser2023'),
            'is_admin' => true
        ]);
    }
}
