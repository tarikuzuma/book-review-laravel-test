<?php

use Illuminate\Support\Facades\Route;


Route::get('/test-admin', function () {
    dd();
});


Route::get('/', function () {
    return view('welcome');
});
