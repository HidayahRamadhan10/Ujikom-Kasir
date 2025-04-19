<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Cek apakah email admin sudah ada
        if (!User::where('email', 'admin@gmail.com')->exists()) {
            User::create([
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('123'),
                'role' => 'admin',
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
            ]);
        }

        // Cek apakah email staf sudah ada
        if (!User::where('email', 'staf2@gmail.com')->exists()) {
            User::create([
                'name' => 'Staf Biasa',
                'email' => 'staf3@gmail.com',
                'password' => Hash::make('123'),
                'role' => 'staf',
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
            ]);
        }

        // Generate 10 user dummy hanya jika belum ada user dummy sebelumnya
        if (User::count() < 12) { // 2 user default + 10 dummy = 12
            User::factory(10)->create([
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
            ]);
        }
    }
}