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
    //Authentication Logic goes here
    return redirect();
})->name('universityMemberLogin.submit');
//Route to the Admin login page
Route::get('/adminLogin', function () {
    return view('auth.adminLoginPage');
})->name('adminLogin');
//Route to handle the Admin Login form submission
Route::post('/adminLogin',function(){
    //Authentication Logic goes here
    return redirect();
})->name('adminLogin.submit');