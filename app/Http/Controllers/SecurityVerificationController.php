<?php

namespace App\Http\Controllers;

use App\Models\TemporaryPass;
use Illuminate\Http\Request;

class SecurityVerificationController extends Controller
{
    public function showPortal()
    {
        return view('security.verify');
    }

    public function lookup(Request $request)
    {
        $data = $request->validate([
            'token' => ['required','string','max:255'],
        ]);

        $pass = TemporaryPass::with('passable')
            ->where('qr_code_token', $data['token'])
            ->first();

        if (! $pass) {
            return response()->json([
                'found' => false,
                'message' => 'Pass not found.',
            ], 404);
        }

        return response()->json([
            'found' => true,
            'status' => $pass->status,
            'reason' => $pass->reason_label,
            'pass_reference' => strtoupper(substr($pass->qr_code_token, 0, 8)),
            'holder_name' => $pass->passable?->name,
            'holder_email' => $pass->passable?->email,
            'pass_type' => class_basename($pass->passable_type),
            'valid_from' => optional($pass->valid_from)?->toIso8601String(),
            'valid_until' => optional($pass->valid_until)?->toIso8601String(),
            'qr_token' => $pass->qr_code_token,
        ]);
    }
}
