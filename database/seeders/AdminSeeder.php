<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if the admin already exists to avoid creating duplicates
        // if the seeder is run multiple times.
        if (!Admin::where('email', 'admin@tps.com')->exists()) {
            Admin::create([
                'name' => 'Admin',
                'email' => 'admin@tpas.com',
                'password' => Hash::make('password'),
            ]);
        }
    }
}