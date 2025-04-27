<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthGRIController;

Route::middleware(['auth'])->prefix('v1')->group(function () {
    Route::get('/me', function () {
        return response()->json([
            'auth_id' => Auth::id(),
            'user' => Auth::user(),
        ]);
    });
});

Route::get('/', function () {
    return view('app', ['page' => 'landing']);
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

Route::get('/pagrindinis', fn() => view('app', ['page' => 'home']));

Route::get('/duomenys', function () {
    return view('app', ['page' => 'data']);
});

Route::get('/ataskaitos', fn() => view('app', ['page' => 'reports']));
Route::get('/ataskaitos/gri302', fn() => view('app', ['page' => 'gri302visuals']));
Route::get('/ataskaitos/gri303', fn() => view('app', ['page' => 'gri303visuals']));
Route::get('/ataskaitos/gri305', fn() => view('app', ['page' => 'gri305visuals']));
Route::get('/ataskaitos/gri306', fn() => view('app', ['page' => 'gri306visuals']));
Route::get('/ataskaitos/gri403', fn() => view('app', ['page' => 'gri403visuals']));
Route::get('/ataskaitos/gri2', fn() => view('app', ['page' => 'gri2visuals']));
Route::get('/ataskaitos/generate', fn() => view('app', ['page' => 'generatedreports']));




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

Route::get('/whoami', function () {
    if (Auth::check()) {
        return 'Logged in as: ' . Auth::user()->email;
    }

    return 'Not logged in.';
});
