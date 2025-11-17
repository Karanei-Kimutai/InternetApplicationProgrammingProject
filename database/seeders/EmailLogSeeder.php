<?php

namespace Database\Seeders;

use App\Models\EmailLog;
use App\Models\TemporaryPass;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class EmailLogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $logDefinitions = [
            'PASS-GUEST-ADMISSIONS-20241025' => [
                [
                    'recipient_email' => 'daniel.mwangi@example.com',
                    'subject' => 'Temporary pass approved',
                    'status' => 'sent',
                    'error_message' => null,
                    'sent_at' => Carbon::create(2024, 10, 24, 17, 45),
                ],
                [
                    'recipient_email' => 'daniel.mwangi@example.com',
                    'subject' => 'QR code delivered',
                    'status' => 'sent',
                    'error_message' => null,
                    'sent_at' => Carbon::create(2024, 10, 24, 18, 0),
                ],
            ],
            'PASS-GUEST-LABS-20241020' => [
                [
                    'recipient_email' => 'brenda.kiplagat@example.com',
                    'subject' => 'Temporary pass request outcome',
                    'status' => 'failed',
                    'error_message' => 'Delivery blocked: outside permitted visiting hours.',
                    'sent_at' => Carbon::create(2024, 10, 19, 16, 15),
                ],
            ],
            'PASS-GUEST-ORIENTATION-20241101' => [
                [
                    'recipient_email' => 'maria.ochieng@example.com',
                    'subject' => 'Temporary pass application received',
                    'status' => 'sent',
                    'error_message' => null,
                    'sent_at' => Carbon::create(2024, 10, 28, 9, 30),
                ],
            ],
        ];

        $passes = TemporaryPass::whereIn('qr_code_token', array_keys($logDefinitions))
            ->get()
            ->keyBy('qr_code_token');

        foreach ($logDefinitions as $token => $logs) {
            $pass = $passes[$token] ?? null;

            if (! $pass) {
                continue;
            }

            foreach ($logs as $log) {
                EmailLog::updateOrCreate(
                    [
                        'temporary_pass_id' => $pass->id,
                        'subject' => $log['subject'],
                        'sent_at' => $log['sent_at'],
                    ],
                    [
                        'recipient_email' => $log['recipient_email'],
                        'status' => $log['status'],
                        'error_message' => $log['error_message'],
                    ]
                );
            }
        }
    }
}
