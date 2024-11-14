<?php

use App\Http\Controllers\BookController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReviewController;


Route::get('/test-admin', function () {
    dd();
});


Route::get('/', function () {
    return redirect() -> route('books.index');
});

Route::resource('books', BookController::class)
    ->only (['index', 'show']);

Route::resource('books.reviews', ReviewController::class)
    -> scoped(['review' => 'book'])
    ->only(['create', 'store']);