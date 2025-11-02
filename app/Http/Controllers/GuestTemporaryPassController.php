<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGuestTemporaryPassRequest;
use App\Models\Guest;
use App\Models\TemporaryPass;
use Illuminate\Http\RedirectResponse;

class GuestTemporaryPassController extends Controller
{
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

        $temporaryPass->logEmail(
            $guest->email,
            'Guest Temporary Pass Application Received'
        );

        return redirect()->route('visit.show')
            ->with('status', 'Application received. An administrator will review your request and contact you via email.');
    }
}
