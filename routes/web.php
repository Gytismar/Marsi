<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthGRIController;

Route::get('/', function () {
    return view ('welcome2' );
});



Route::get('/login', [AuthGRIController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthGRIController::class, 'login']);
Route::post('/logout', [AuthGRIController::class, 'logout'])->name('logout');

Route::get('/register', [AuthGRIController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthGRIController::class, 'register']);

Route::get('/dashboard', function () {
    return 'Welcome to your dashboard!';
})->middleware('auth')->name('dashboard');
