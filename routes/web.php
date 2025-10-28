<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

//Route to the University Member Login page
Route::get('/universityMemberLogin', function () {
    return view('auth.universityMemberLoginPage');
})->name('universityMemberLogin');
//Route to handle the University Member Login form submission
Route::post('/universityMemberLogin',function(){
    // TODO: Replace with real authentication.
    // For now, redirect to the dummy AMS dashboard after a successful "login".
    return redirect()->route('ams.dashboard');
})->name('universityMemberLogin.submit');
//Route to the Admin login page
Route::get('/adminLogin', function () {
    return view('auth.adminLoginPage');
})->name('adminLogin');
//Route to handle the Admin Login form submission
Route::post('/adminLogin',function(){
    // TODO: Replace with real authentication.
    // Placeholder: redirect back to admin login until an admin dashboard exists.
    return redirect()->route('adminLogin');
})->name('adminLogin.submit');

// Simple confirmation page (shown after submitting an application)
Route::view('/confirmation', 'confirmation')->name('confirmation');

// Dummy AMS dashboard (placeholder layout for university members)
Route::view('/ams-dashboard', 'ams.dashboard')->name('ams.dashboard');
