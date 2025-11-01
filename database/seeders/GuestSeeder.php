<?php

namespace Database\Seeders;

use App\Models\Guest;
use Illuminate\Database\Seeder;

class GuestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $guests = [
            [
                'name' => 'Maria Ochieng',
                'email' => 'maria.ochieng@example.com',
                'profile_image_path' => null,
            ],
            [
                'name' => 'Daniel Mwangi',
                'email' => 'daniel.mwangi@example.com',
                'profile_image_path' => 'profiles/guests/daniel-mwangi.jpg',
            ],
            [
                'name' => 'Brenda Kiplagat',
                'email' => 'brenda.kiplagat@example.com',
                'profile_image_path' => 'profiles/guests/brenda-kiplagat.png',
            ],
        ];

        foreach ($guests as $guest) {
            Guest::updateOrCreate(
                ['email' => $guest['email']],
                $guest
            );
        }
    }
}
