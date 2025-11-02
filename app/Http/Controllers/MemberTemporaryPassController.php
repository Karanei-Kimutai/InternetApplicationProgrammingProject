<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMemberTemporaryPassRequest;
use App\Models\TemporaryPass;
use App\Models\UniversityMember;
use Carbon\CarbonImmutable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;

class MemberTemporaryPassController extends Controller
{
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

            $temporaryPass->logEmail(
                $memberEmail,
                'Temporary Pass Application Rejected - Visit security office',
                'sent'
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

        $temporaryPass->logEmail(
            $memberEmail,
            'Temporary Pass Approved',
            'sent'
        );

        return redirect()->route('tpas.members.apply')
            ->with('status', 'Temporary pass issued. Check your email for the QR code and validity details.');
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
