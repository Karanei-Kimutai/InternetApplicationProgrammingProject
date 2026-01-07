<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LecturersTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::connection('university')->table('lecturers')->insert([
            [
                'id' => 2101,
                'name' => 'Dr. Eleanor Wanjiku',
                'email' => 'eleanor.wanjiku@university.ac.ke',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
                'photo_url' => 'https://randomuser.me/api/portraits/women/10.jpg',
            ],
            [
                'id' => 2102,
                'name' => 'Prof. Ken Ochieng',
                'email' => 'ken.ochieng@university.ac.ke',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
                'photo_url' => 'https://randomuser.me/api/portraits/men/11.jpg',
            ],
            [
                'id' => 2103,
                'name' => 'Dr. Imani Nassir',
                'email' => 'imani.nassir@university.ac.ke',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
                'photo_url' => 'https://randomuser.me/api/portraits/women/12.jpg',
            ],
            [
                'id' => 2104,
                'name' => 'Prof. Mark Chepkwony',
                'email' => 'mark.chepkwony@university.ac.ke',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
                'photo_url' => 'https://randomuser.me/api/portraits/men/14.jpg',
            ],
            [
                'id' => 2105,
                'name' => 'Dr. Amina Hussein',
                'email' => 'amina.hussein@university.ac.ke',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
                'photo_url' => 'https://randomuser.me/api/portraits/women/15.jpg',
            ],
            [
                'id' => 2106,
                'name' => 'Prof. Victor Mutai',
                'email' => 'victor.mutai@university.ac.ke',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
                'photo_url' => 'https://randomuser.me/api/portraits/men/16.jpg',
            ],
        ]);
    }
}
