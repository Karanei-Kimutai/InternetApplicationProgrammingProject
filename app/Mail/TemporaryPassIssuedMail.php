<?php

namespace App\Mail;

use App\Models\TemporaryPass;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class TemporaryPassIssuedMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(public TemporaryPass $pass, public string $recipientName = 'Member')
    {
    }

    public function build()
    {
        $mail = $this->subject('Temporary Pass Approved')
            ->view('emails.temporary_pass_issued', [
                'pass' => $this->pass,
                'recipientName' => $this->recipientName,
                'qrUrl' => route('tpas.qr.show', ['token' => $this->pass->qr_code_token]),
                'verifyUrl' => route('tpas.qr.verify', ['token' => $this->pass->qr_code_token]),
            ]);

        if ($this->pass->qr_code_path) {
            $path = 'public/' . ltrim($this->pass->qr_code_path, '/');
            if (Storage::exists($path)) {
                $mail->attach(Storage::path($path), [
                    'as' => 'temporary-pass-qr.png',
                    'mime' => 'image/png',
                ]);
            }
        }

        return $mail;
    }
}

