<?php

namespace App\Services;

use App\Support\MailSendResult;
use Illuminate\Support\Facades\Log;
use PHPMailer\PHPMailer\PHPMailer;
use Throwable;

class ApplicationMailer
{
    public function __construct(private readonly ?array $config = null)
    {
    }

    /**
     * Send a rendered Blade view via PHPMailer.
     *
     * @param  array<int|string, array<string, string>>  $attachments
     */
    public function sendUsingView(
        string $view,
        array $data,
        string $subject,
        string $recipientEmail,
        ?string $recipientName = null,
        array $attachments = []
    ): MailSendResult {
        $config = $this->config ?? config('phpmailer', []);

        try {
            $mailer = $this->buildMailer($config);
            $mailer->clearAddresses();
            $mailer->addAddress($recipientEmail, $recipientName);

            $html = view($view, $data)->render();

            $mailer->isHTML(true);
            $mailer->Subject = $subject;
            $mailer->Body = $html;
            $mailer->AltBody = strip_tags(
                preg_replace('/<br\\s*\\/?>/i', PHP_EOL, $html) ?? $html
            );

            foreach ($attachments as $attachment) {
                $path = $attachment['path'] ?? null;

                if (!$path || !is_readable($path)) {
                    continue;
                }

                $name = $attachment['name'] ?? basename($path);

                if (!empty($attachment['cid'])) {
                    $mailer->addEmbeddedImage($path, $attachment['cid'], $name);
                } else {
                    $mailer->addAttachment($path, $name);
                }
            }

            $mailer->send();

            return MailSendResult::sent();
        } catch (Throwable $exception) {
            Log::error('Unable to send email via PHPMailer.', [
                'subject' => $subject,
                'recipient' => $recipientEmail,
                'error' => $exception->getMessage(),
            ]);

            return MailSendResult::failed($exception->getMessage());
        }
    }

    /**
     * Configure PHPMailer with the supplied settings.
     */
    protected function buildMailer(array $config): PHPMailer
    {
        $mailer = new PHPMailer(true);
        $mailer->CharSet = 'UTF-8';
        $mailer->Encoding = 'base64';

        $transport = strtolower($config['transport'] ?? 'smtp');

        if ($transport === 'smtp') {
            $mailer->isSMTP();
            $mailer->Host = (string) ($config['host'] ?? '127.0.0.1');
            $mailer->Port = (int) ($config['port'] ?? 2525);
            $mailer->SMTPAuth = !empty($config['username']);

            if ($mailer->SMTPAuth) {
                $mailer->Username = (string) $config['username'];
                $mailer->Password = (string) ($config['password'] ?? '');
            }

            if (!empty($config['encryption'])) {
                $mailer->SMTPSecure = (string) $config['encryption'];
            }

            $mailer->Timeout = (int) ($config['timeout'] ?? 10);
            $mailer->SMTPDebug = !empty($config['debug']) ? 2 : 0;

            $verifyPeer = (bool) ($config['verify_peer'] ?? true);

            $mailer->SMTPOptions = [
                'ssl' => [
                    'verify_peer' => $verifyPeer,
                    'verify_peer_name' => $verifyPeer,
                    'allow_self_signed' => !$verifyPeer,
                ],
            ];
        } else {
            $mailer->isMail();
        }

        $fromAddress = (string) ($config['from']['address'] ?? 'no-reply@strathmoretpas.com');
        $fromName = (string) ($config['from']['name'] ?? config('app.name', 'Temporary Pass Application System'));

        $mailer->setFrom($fromAddress, $fromName);

        return $mailer;
    }
}
