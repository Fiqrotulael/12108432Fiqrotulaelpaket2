<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard');
});
Route::get('1', function () {
    return view('Login');
});
Route::get('2', function () {
    return view('register');
});