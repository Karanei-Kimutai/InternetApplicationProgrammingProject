<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGuestTemporaryPassRequest;
use App\Models\Guest;
use App\Models\TemporaryPass;
use App\Services\ApplicationMailer;
use Illuminate\Http\RedirectResponse;

class GuestTemporaryPassController extends Controller
{
    public function __construct(private readonly ApplicationMailer $mailer)
    {
    }

    /**
     * Handle the submission of a guest temporary pass application.
     */
    public function store(StoreGuestTemporaryPassRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $guest = Guest::firstOrCreate(
            ['email' => $validated['email']],
            ['name' => $validated['name']]
        );

        if ($guest->name !== $validated['name']) {
            $guest->name = $validated['name'];
        }

        if ($request->hasFile('photo')) {
            $guest->profile_image_path = $request->file('photo')->storePublicly('guest-ids', ['disk' => 'public']);
        }

        $guest->save();

        $temporaryPass = TemporaryPass::create([
            'passable_type' => Guest::class,
            'passable_id' => $guest->id,
            'status' => 'pending',
            'reason' => trim($validated['reason']),
        ]);

        $subject = 'Guest Temporary Pass Application Received';
        $mailResult = $this->mailer->sendUsingView(
            'emails.application-received',
            [
                'recipientName' => $guest->name,
                'applicationType' => 'Guest Temporary Pass Application',
                'reasonLabel' => $temporaryPass->reason_label,
                'submittedAt' => now()->format('l, j F Y g:i A'),
                'nextSteps' => 'Our team is reviewing your submission. Expect another email once an administrator approves or requests additional information.',
                'senderName' => config('app.name') . ' Security Office',
            ],
            $subject,
            $guest->email,
            $guest->name
        );

        $temporaryPass->logEmail(
            $guest->email,
            $subject,
            $mailResult->sent ? 'sent' : 'failed',
            $mailResult->error
        );

        return redirect()->route('visit.show')
            ->with('status', 'Application received. An administrator will review your request and contact you via email.');
    }
}
