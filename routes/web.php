<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\GuestTemporaryPassController;
use App\Http\Controllers\MemberTemporaryPassController;

// Homepage → University Member Login first
Route::get('/', function () {
    return view('systemLandingPage');
})->name('systemLandingPage');

// Route to the University Member Login page
Route::get('/universityMemberLogin', function () {
    return view('auth.universityMemberLoginPage');
})->name('universityMemberLogin');
// Handle the University Member Login form submission (external DB auth)
Route::post('/universityMemberLogin', function (Request $request) {
    $request->validate([
        'login' => ['required','string'], // email or admission ID
        'password' => ['required','string'],
    ]);

    $login = trim($request->input('login'));
    $password = $request->input('password');

    try {
        $query = DB::connection('university')->table('v_university_members');
        if (is_numeric($login)) {
            $user = $query->where('id', (int) $login)->first();
        } else {
            $user = $query->where('email', $login)->first();
        }

        if ($user && Hash::check($password, $user->password)) {
            session([
                // Display name
                'member' => $user->name,
                // Username (admission number) for forms
                'member_username' => (string) $user->id,
                // Keep ID separately if needed elsewhere
                'member_id' => $user->id,
                'member_email' => $user->email,
                'member_role' => $user->role ?? null,
                'member_photo' => $user->photo_url ?? null,
            ]);
            return redirect()->route('ams.dashboard');
        }

        return back()->withInput(['login' => $login])->with('auth_error', 'Invalid credentials. Use your email or admission ID and password.');
    } catch (\Throwable $e) {
        return back()->withInput(['login' => $login])->with('auth_error', 'Authentication service unavailable. Please try again later.');
    }
})->name('universityMemberLogin.submit');

// Logout for university member
Route::match(['get','post'], '/logout', function () {
    session()->forget('member');
    return redirect()->route('universityMemberLogin');
})->name('logout');

// Admin login form
Route::get('/adminLogin', [AdminController::class, 'showLoginForm'])->name('adminLogin');

// Handle admin login submission
Route::post('/adminLogin', [AdminController::class, 'login'])->name('adminLogin.submit');

// Admin logout
Route::post('/adminLogout', [AdminController::class, 'logout'])->name('adminLogout');

// Confirmation page (shared)
Route::view('/confirmation', 'confirmation')->name('confirmation');

// AMS dashboard (require simple session login)
Route::get('/ams-dashboard', function (Request $request) {
    if (!session()->has('member')) {
        return redirect()->route('universityMemberLogin');
    }
    return view('ams.dashboard');
})->name('ams.dashboard');

//Admin Dashboard Route
Route::get('/adminDashboard', [App\Http\Controllers\AdminController::class, 'dashboard'])->middleware('auth:web')->name('adminDashboard');

//Route to Strathmore University Public Site
Route::get('/publicSite', function () {
    return view('public_site');
})->name('publicSite.show');

//Route to the Visit Us page
Route::get('/visit', function () {
    return view('visit');
})->name('visit.show');

//Route to handle the Visit Us form submission
Route::post('/visit', [GuestTemporaryPassController::class, 'store'])->name('visit.submit');


// Guest pass now uses the public "Visit Us" page
Route::get('/guest-form', function () {
    return redirect()->route('visit.show');
})->name('tpas.guest.apply');

Route::get('/members-form', function () {
    if (!session()->has('member')) {
        return redirect()->route('universityMemberLogin');
    }
    return view('frontend.members-form');
})->name('tpas.members.apply');

// Submit member temporary pass form
Route::post('/members-form', [MemberTemporaryPassController::class, 'store'])->name('tpas.members.submit');

// Route for AMS student modules: redirect to AMS dashboard
Route::get('/ams-student-modules', function () {
    return redirect()->route('ams.dashboard');
})->name('ams.student.modules');

// Route for 'Apply as Student' button
Route::get('/apply-student', function () {
    return redirect()->route('universityMemberLogin');
})->name('apply.student');

// Route for 'Apply as Guest' button
Route::get('/apply-guest', function () {
    return redirect()->route('visit.show');
})->name('apply.guest');

// Approve a guest application
Route::post('/admin/pass/{id}/approve', [App\Http\Controllers\AdminController::class, 'approvePass'])->name('admin.pass.approve');

// Reject a guest application
Route::post('/admin/pass/{id}/reject', [App\Http\Controllers\AdminController::class, 'rejectPass'])->name('admin.pass.reject');

// Admin: reset a member's 30‑day rate limit (local/testing convenience)
Route::post('/admin/member/reset', [AdminController::class, 'resetMemberRateLimit'])
    ->middleware('auth:web')
    ->name('admin.member.reset');

// QR code preview (PNG) by token
Route::get('/tpas/qr/{token}', function (string $token) {
    $pass = \App\Models\TemporaryPass::where('qr_code_token', $token)->firstOrFail();
    if (!$pass->qr_code_path) {
        $pass->generateQrCodeImage(payload: route('tpas.qr.verify', ['token' => $token]));
    }
    $path = storage_path('app/public/' . $pass->qr_code_path);
    abort_unless(is_file($path), 404);
    return response()->file($path, [
        'Content-Type' => 'image/png',
        'Cache-Control' => 'public, max-age=604800',
    ]);
})->name('tpas.qr.show');

// QR verification endpoint (JSON payload for now)
Route::get('/tpas/verify/{token}', function (string $token) {
    $pass = \App\Models\TemporaryPass::where('qr_code_token', $token)->firstOrFail();
    return response()->json([
        'token' => $token,
        'status' => $pass->status,
        'valid_from' => optional($pass->valid_from)->toIso8601String(),
        'valid_until' => optional($pass->valid_until)->toIso8601String(),
    ]);
})->name('tpas.qr.verify');
