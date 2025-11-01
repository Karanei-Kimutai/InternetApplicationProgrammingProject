<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAdminRequest;
use App\Http\Requests\UpdateAdminRequest;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $universityApplications = \App\Models\TemporaryPass::where('passable_type', 'App\\Models\\UniversityMember')
            ->latest()->take(10)->get();

        $guestApplications = \App\Models\TemporaryPass::where('passable_type', 'App\\Models\\Guest')
            ->latest()->take(10)->get();

        $statistics = [
            'university_count' => \App\Models\TemporaryPass::where('passable_type', 'App\\Models\\UniversityMember')->count(),
            'guest_count' => \App\Models\TemporaryPass::where('passable_type', 'App\\Models\\Guest')->count(),
        ];

        return view('adminDashboard', compact('universityApplications', 'guestApplications', 'statistics'));
    }

    // Approve/Reject actions
    public function approvePass($id)
    {
        $pass = \App\Models\TemporaryPass::findOrFail($id);
        $pass->status = 'approved';
        $pass->approved_by = Auth::id();
        $pass->save();
        return redirect()->route('adminDashboard')->with('success', 'Pass approved.');
    }

    public function rejectPass($id)
    {
        $pass = \App\Models\TemporaryPass::findOrFail($id);
        $pass->status = 'rejected';
        $pass->approved_by = Auth::id();
        $pass->save();
        return redirect()->route('adminDashboard')->with('success', 'Pass rejected.');
    }
}
