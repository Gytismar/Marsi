<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthGRIController;

Route::get('/', function () {
    return view('app', ['page' => 'home']);
});

Route::get('/gri/g302-energy', function () {
    return view('app', ['page' => 'gri302']);
});

Route::get('/gri/g303-water', function () {
    return view('app', ['page' => 'gri303']);
});

Route::get('/gri/g305-emissions', function () {
    return view('app', ['page' => 'gri305']);
});

Route::get('/gri/g306-waste', function () {
    return view('app', ['page' => 'gri306']);
});

Route::get('/gri/g403-health-safety', function () {
    return view('app', ['page' => 'gri403']);
});

Route::get('/gri/g2-governance', function () {
    return view('app', ['page' => 'gri2']);
});

Route::get('/duomenys', function () {
    return view('app', ['page' => 'data']);
});

Route::get('/informacija', fn() => view('app', ['page' => 'info']));

Route::get('/informacija/g302-energy', fn() => view('app', ['page' => 'griinfo302']));
Route::get('/informacija/g303-water', fn() => view('app', ['page' => 'griinfo303']));
Route::get('/informacija/g305-emissions', fn() => view('app', ['page' => 'griinfo305']));
Route::get('/informacija/g306-waste', fn() => view('app', ['page' => 'griinfo306']));
Route::get('/informacija/g403-health-safety', fn() => view('app', ['page' => 'griinfo403']));
Route::get('/informacija/g2-governance', fn() => view('app', ['page' => 'griinfo2']));


Route::get('/login', [AuthGRIController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthGRIController::class, 'login']);
Route::post('/logout', [AuthGRIController::class, 'logout'])->name('logout');

Route::get('/register', [AuthGRIController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthGRIController::class, 'register']);

Route::get('/dashboard', function () {
    return 'Welcome to your dashboard!';
})->middleware('auth')->name('dashboard');
