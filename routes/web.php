<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/guest-form', function () {
    return view('frontend.guest-form');
});

Route::get('/members-form', function () {
    return view('frontend.members-form');
});
