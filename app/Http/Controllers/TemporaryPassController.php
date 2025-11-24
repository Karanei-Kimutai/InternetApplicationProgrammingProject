<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTemporaryPassRequest;
use App\Http\Requests\UpdateTemporaryPassRequest;
use App\Models\TemporaryPass;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class TemporaryPassController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTemporaryPassRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(TemporaryPass $temporaryPass)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TemporaryPass $temporaryPass)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTemporaryPassRequest $request, TemporaryPass $temporaryPass)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TemporaryPass $temporaryPass): RedirectResponse
    {
        $isActiveApproved = $temporaryPass->status === 'approved'
            && (! $temporaryPass->valid_until || $temporaryPass->valid_until->isFuture());

        if ($isActiveApproved) {
            return Redirect::route('adminDashboard')
                ->with('error', 'Cannot archive an active pass. Revoke it or wait until it expires.');
        }

        if ($temporaryPass->qr_code_path) {
            Storage::disk('public')->delete($temporaryPass->qr_code_path);
        }

        $temporaryPass->delete();

        return Redirect::route('adminDashboard')->with('success', 'Pass archived successfully.');
    }

    /**
     * Restore a previously archived pass.
     */
    public function restore(int $id): RedirectResponse
    {
        $pass = TemporaryPass::withTrashed()->findOrFail($id);

        if (! $pass->trashed()) {
            return Redirect::route('adminDashboard')->with('error', 'Pass is already active.');
        }

        // Bring back the pass as pending to ensure a fresh review
        $pass->restore();
        $pass->update([
            'status' => 'pending',
            'valid_from' => null,
            'valid_until' => null,
            'approved_by' => null,
            'qr_code_token' => null,
        ]);

        return Redirect::route('adminDashboard')->with('success', 'Pass restored successfully.');
    }

    /**
     * Permanently delete an archived pass.
     */
    public function forceDestroy(int $id): RedirectResponse
    {
        $pass = TemporaryPass::withTrashed()->findOrFail($id);

        if (! $pass->trashed()) {
            return Redirect::route('adminDashboard')->with('error', 'Only archived passes can be purged.');
        }

        if ($pass->qr_code_path) {
            Storage::disk('public')->delete($pass->qr_code_path);
        }

        $pass->forceDelete();

        return Redirect::route('adminDashboard')->with('success', 'Pass purged permanently.');
    }
}
