<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Guest;
use App\Models\TemporaryPass;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TemporaryPassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = Admin::first();
        if (! $admin) {
            $admin = Admin::create([
                'name' => 'Admin',
                'email' => 'admin@tpas.com',
                'password' => Hash::make('password'),
            ]);
        }

        $guestEmails = [
            'maria.ochieng@example.com',
            'daniel.mwangi@example.com',
            'brenda.kiplagat@example.com',
        ];

        $guests = Guest::whereIn('email', $guestEmails)->get()->keyBy('email');

        $passes = [
            [
                'guest_email' => 'maria.ochieng@example.com',
                'status' => 'pending',
                'reason' => 'Attending prospective student orientation',
                'qr_code_token' => 'PASS-GUEST-ORIENTATION-20241101',
                'valid_from' => now()->addDay()->setHour(9)->setMinute(0),
                'valid_until' => now()->addDay()->setHour(12)->setMinute(0),
                'approved_by' => null,
            ],
            [
                'guest_email' => 'daniel.mwangi@example.com',
                'status' => 'pending',
                'reason' => 'Meeting with the admissions office',
                'qr_code_token' => 'PASS-GUEST-ADMISSIONS-20241025',
                'valid_from' => now()->subHours(2),
                'valid_until' => now()->addHours(4),
                'approved_by' => null,
            ],
            [
                'guest_email' => 'brenda.kiplagat@example.com',
                'status' => 'rejected',
                'reason' => 'Request to access research labs outside visiting hours',
                'qr_code_token' => 'PASS-GUEST-LABS-20241020',
                'valid_from' => now()->subDays(5)->setHour(8)->setMinute(0),
                'valid_until' => now()->subDays(5)->setHour(17)->setMinute(0),
                'approved_by' => $admin->id,
            ],
        ];

        foreach ($passes as $pass) {
            $guest = $guests[$pass['guest_email']] ?? null;

            if (! $guest) {
                continue;
            }

            $guest->passes()->updateOrCreate(
                ['qr_code_token' => $pass['qr_code_token']],
                [
                    'status' => $pass['status'],
                    'reason' => $pass['reason'],
                    'valid_from' => $pass['valid_from'],
                    'valid_until' => $pass['valid_until'],
                    'approved_by' => $pass['approved_by'],
                ]
            );
        }
    }
}
