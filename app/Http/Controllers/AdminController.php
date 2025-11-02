<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAdminRequest;
use App\Http\Requests\UpdateAdminRequest;
use App\Models\Admin;
use App\Models\Guest;
use App\Models\TemporaryPass;
use App\Models\UniversityMember;
use Carbon\CarbonImmutable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redirect;
use App\Jobs\SendTemporaryPassEmail;

class AdminController extends Controller
{
    // Resource methods
    public function index() { }
    public function create() { }
    public function store(StoreAdminRequest $request) { }
    public function show(Admin $admin) { }
    public function edit(Admin $admin) { }
    public function update(UpdateAdminRequest $request, Admin $admin) { }
    public function destroy(Admin $admin) { }

    // Authentication methods
    public function showLoginForm()
    {
        return view('auth.adminLoginPage');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::guard('web')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended(route('adminDashboard'));
        }

        return back()->withErrors([
            'email' => 'Invalid credentials.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('adminLogin');
    }

    // Dashboard method
    public function dashboard()
    {
        $universityApplications = TemporaryPass::where('passable_type', UniversityMember::class)
            ->latest()->take(10)->get();

        $guestApplications = TemporaryPass::where('passable_type', Guest::class)
            ->latest()->take(10)->get();

        $statistics = [
            'university_count' => TemporaryPass::where('passable_type', UniversityMember::class)->count(),
            'guest_count' => TemporaryPass::where('passable_type', Guest::class)->count(),
        ];

        return view('adminDashboard', compact('universityApplications', 'guestApplications', 'statistics'));
    }

    // Approve/Reject actions
    public function approvePass($id)
    {
        $pass = TemporaryPass::findOrFail($id);
        $now = CarbonImmutable::now();

        $pass->status = 'approved';
        $pass->approved_by = Auth::id();
        $pass->valid_from = $now;
        $pass->valid_until = $this->determineExpiry($pass, $now);

        if (!$pass->qr_code_token) {
            $pass->qr_code_token = Str::uuid()->toString();
        }

        $pass->save();

        // Ensure a QR image exists for approved passes
        $pass->generateQrCodeImage(payload: route('tpas.qr.verify', ['token' => $pass->qr_code_token]));

        if ($recipient = $this->resolveRecipientEmail($pass)) {
            $log = $pass->logEmail($recipient, 'Temporary Pass Approved', 'queued');
            SendTemporaryPassEmail::dispatch(
                temporaryPassId: $pass->id,
                recipientEmail: $recipient,
                recipientName: $pass->passable->name ?? 'Guest/Member',
                emailLogId: $log->id
            );
        }

        return redirect()->route('adminDashboard')->with('success', 'Pass approved.');
    }

    public function rejectPass($id)
    {
        $pass = TemporaryPass::findOrFail($id);
        $pass->status = 'rejected';
        $pass->approved_by = Auth::id();
        $pass->valid_from = null;
        $pass->valid_until = null;
        $pass->qr_code_token = null;
        $pass->save();

        if ($recipient = $this->resolveRecipientEmail($pass)) {
            $pass->logEmail($recipient, 'Temporary Pass Application Rejected', 'sent');
        }

        return redirect()->route('adminDashboard')->with('success', 'Pass rejected.');
    }

    /**
     * Determine the expiry date based on applicant type and reason.
     */
    protected function determineExpiry(TemporaryPass $pass, CarbonImmutable $start): CarbonImmutable
    {
        if ($pass->passable_type === UniversityMember::class && $pass->reason === 'lost_id') {
            return $start->addDays(7);
        }

        return $start->addDay();
    }

    /**
     * Resolve email recipient for notifications.
     */
    protected function resolveRecipientEmail(TemporaryPass $pass): ?string
    {
        $passable = $pass->passable;

        return $passable?->email ?? null;
    }

    /**
     * Reset a member's 30‑day rate limit by marking recent passes as rejected.
     * Intended for testing/local use only.
     */
    public function resetMemberRateLimit(Request $request)
    {
        $data = $request->validate([
            'member_id' => ['required','integer','min:1'],
        ]);

        $memberId = (int) $data['member_id'];

        $affected = TemporaryPass::where('passable_type', UniversityMember::class)
            ->where('passable_id', $memberId)
            ->where('created_at', '>=', now()->subDays(30))
            ->update(['status' => 'rejected']);

        return Redirect::route('adminDashboard')
            ->with('success', "Rate limit reset for member {$memberId}. Updated {$affected} record(s).");
    }
}
