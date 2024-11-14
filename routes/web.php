<?php

use App\Http\Controllers\BookController;
use Illuminate\Support\Facades\Route;


Route::get('/test-admin', function () {
    dd();
});


Route::get('/', function () {
    return redirect() -> route('books.index');
});

Route::resource('books', BookController::class);