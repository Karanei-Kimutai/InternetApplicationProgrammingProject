<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAdminRequest;
use App\Http\Requests\UpdateAdminRequest;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    // ...existing resource methods...

    public function index() {  }
    public function create() {  }
    public function store(StoreAdminRequest $request) { }
    public function show(Admin $admin) { }
    public function edit(Admin $admin) { }
    public function update(UpdateAdminRequest $request, Admin $admin) { }
    public function destroy(Admin $admin) {  }

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
}
