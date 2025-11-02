<?php

namespace App\Jobs;

use App\Mail\TemporaryPassIssuedMail;
use App\Models\EmailLog;
use App\Models\TemporaryPass;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendTemporaryPassEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public int $temporaryPassId,
        public string $recipientEmail,
        public ?string $recipientName = null,
        public ?int $emailLogId = null,
    ) {}

    public function handle(): void
    {
        $pass = TemporaryPass::find($this->temporaryPassId);
        if (!$pass) {
            return;
        }

        Mail::to($this->recipientEmail)
            ->send(new TemporaryPassIssuedMail($pass, $this->recipientName ?? 'Member'));

        if ($this->emailLogId) {
            EmailLog::where('id', $this->emailLogId)
                ->update(['status' => 'sent', 'error_message' => null, 'sent_at' => now()]);
        }
    }

    public function failed(\Throwable $exception): void
    {
        if ($this->emailLogId) {
            EmailLog::where('id', $this->emailLogId)
                ->update(['status' => 'failed', 'error_message' => $exception->getMessage()]);
        }
    }
}

