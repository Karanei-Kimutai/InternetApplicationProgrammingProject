<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMemberTemporaryPassRequest;
use App\Models\TemporaryPass;
use App\Models\UniversityMember;
use App\Services\ApplicationMailer;
use Carbon\CarbonImmutable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;

class MemberTemporaryPassController extends Controller
{
    public function __construct(private readonly ApplicationMailer $mailer)
    {
    }

    /**
     * Handle the submission of a university member temporary pass request.
     */
    public function store(StoreMemberTemporaryPassRequest $request): RedirectResponse
    {
        if (!session()->has('member_id')) {
            return redirect()->route('universityMemberLogin')
                ->with('auth_error', 'Your session expired. Please sign in again to submit a request.');
        }

        $memberId = (int) session('member_id');
        $memberEmail = (string) session('member_email');
        $memberName = (string) session('member');
        $reason = $request->validated('reason');

        $now = CarbonImmutable::now();

        if ($this->isWithinThirtyDayRestriction($memberId, $reason, $now)) {
            $temporaryPass = TemporaryPass::create([
                'passable_type' => UniversityMember::class,
                'passable_id' => $memberId,
                'status' => 'rejected',
                'reason' => $reason,
            ]);

            $subject = 'Temporary Pass Application Rejected - Visit security office';
            $mailResult = $this->mailer->sendUsingView(
                'emails.member-physical-required',
                [
                    'recipientName' => $memberName,
                    'reasonLabel' => $temporaryPass->reason_label,
                    'senderName' => config('app.name') . ' Security Office',
                ],
                $subject,
                $memberEmail,
                $memberName
            );

            $temporaryPass->logEmail(
                $memberEmail,
                $subject,
                $mailResult->sent ? 'sent' : 'failed',
                $mailResult->error
            );

            return redirect()->back()->with('error', 'You have reached the limit for this reason within the last 30 days. Please visit the security office to apply physically.');
        }

        $validUntil = $reason === 'lost_id'
            ? $now->addDays(7)
            : $now->addDay();

        $temporaryPass = TemporaryPass::create([
            'passable_type' => UniversityMember::class,
            'passable_id' => $memberId,
            'status' => 'approved',
            'reason' => $reason,
            'qr_code_token' => Str::uuid()->toString(),
            'valid_from' => $now,
            'valid_until' => $validUntil,
        ]);

        // Generate and persist QR code image for the approved pass
        $temporaryPass->generateQrCodeImage(
            payload: route('tpas.qr.verify', ['token' => $temporaryPass->qr_code_token])
        );

        $qrShow = route('tpas.qr.show', ['token' => $temporaryPass->qr_code_token]);
        $qrVerify = route('tpas.qr.verify', ['token' => $temporaryPass->qr_code_token]);

        $subject = 'Temporary Pass Approved';
        $attachments = [];

        $timezone = config('app.timezone', 'UTC');
        $validFromFormatted = $temporaryPass->valid_from
            ? $temporaryPass->valid_from->timezone($timezone)->format('D, d M Y g:i A')
            : 'Pending activation';
        $validUntilFormatted = $temporaryPass->valid_until
            ? $temporaryPass->valid_until->timezone($timezone)->format('D, d M Y g:i A')
            : 'Pending activation';

        if ($temporaryPass->qr_code_path) {
            $qrFullPath = storage_path('app/public/' . ltrim($temporaryPass->qr_code_path, '/'));
            if (is_readable($qrFullPath)) {
                $attachments[] = [
                    'path' => $qrFullPath,
                    'name' => 'temporary-pass-qr.png',
                ];
            }
        }

        $mailResult = $this->mailer->sendUsingView(
            'emails.member-pass-approved',
            [
                'recipientName' => $memberName,
                'reasonLabel' => $temporaryPass->reason_label,
                'validFrom' => $validFromFormatted,
                'validUntil' => $validUntilFormatted,
                'passReference' => strtoupper(substr($temporaryPass->qr_code_token ?? '', 0, 8)),
                'qrShowUrl' => $qrShow,
                'qrVerifyUrl' => $qrVerify,
                'senderName' => config('app.name') . ' Security Office',
            ],
            $subject,
            $memberEmail,
            $memberName,
            $attachments
        );

        $temporaryPass->logEmail(
            $memberEmail,
            $subject,
            $mailResult->sent ? 'sent' : 'failed',
            $mailResult->error
        );

        return redirect()->route('confirmation')
            ->with('status', 'Temporary pass issued. QR code generated successfully.')
            ->with('qr_url', $qrShow)
            ->with('verify_url', $qrVerify)
            ->with('qr_token', $temporaryPass->qr_code_token)
            ->with('valid_from', optional($temporaryPass->valid_from)->toIso8601String())
            ->with('valid_until', optional($temporaryPass->valid_until)->toIso8601String());
    }

    /**
     * Determine if the member is within the 30-day restriction window for the supplied reason.
     */
    protected function isWithinThirtyDayRestriction(int $memberId, string $reason, CarbonImmutable $now): bool
    {
        if (!in_array($reason, ['lost_id', 'misplaced_id'], true)) {
            return false;
        }

        return TemporaryPass::where('passable_type', UniversityMember::class)
            ->where('passable_id', $memberId)
            ->where('reason', $reason)
            ->where('status', '!=', 'rejected')
            ->where('created_at', '>=', $now->subDays(30))
            ->exists();
    }

}
