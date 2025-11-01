<?php

use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Route;

//Homepage Route
Route::get('/', function () {
    return view('systemLandingPage');
})->name('systemLandingPage');

//Route to the University Member Login page
Route::get('/universityMemberLogin', function () {
    return view('auth.universityMemberLoginPage');
})->name('universityMemberLogin');
//Route to handle the University Member Login form submission
Route::post('/universityMemberLogin',function(){
    // TODO: Replace with real authentication.
    // Redirect to system landing page after successful login.
    return redirect()->route('systemLandingPage');
})->name('universityMemberLogin.submit');
//Route to the Admin login page
Route::get('/adminLogin', function () {
    return view('auth.adminLoginPage');
})->name('adminLogin');
//Route to handle the Admin Login form submission
Route::post('/adminLogin',function(){
    // TODO: Replace with real authentication.
    return redirect()->route('adminDashboard');
})->name('adminLogin.submit');

// Simple confirmation page (shown after submitting an application)
Route::view('/confirmation', 'confirmation')->name('confirmation');

// Dummy AMS dashboard (placeholder layout for university members)
Route::view('/ams-dashboard', 'ams.dashboard')->name('ams.dashboard');

//Admin Dashboard Route
Route::get('/adminDashboard', function () {
    return view('adminDashboard');
})->name('adminDashboard');

//Route to Strathmore University Public Site
Route::get('/publicSite', function () {
    return view('public_site');
})->name('publicSite.show');

//Route to the Visit Us page
Route::get('/visit', function () {
    return view('visit');
})->name('visit.show');

//Route to handle the Visit Us form submission
Route::post('/visit', function () {
    // TODO: Implement form handling logic.
    return redirect()->route('confirmation');
})->name('visit.submit');


Route::get('/guest-form', function () {
    return view('frontend.guest-form');
});

Route::get('/members-form', function () {
    return view('frontend.members-form');
});

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
