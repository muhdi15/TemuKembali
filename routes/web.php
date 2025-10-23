<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;

use App\Http\Controllers\Auth\LoginController;

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


Route::get('/register', [RegisterController::class, 'showForm'])->name('register.form');
Route::post('/register', [RegisterController::class, 'register'])->name('register.post');


use Illuminate\Support\Facades\Auth;

Route::get('/admin/dashboard', function () {
    $user = Auth::user();
    return view('admin/dashboard');
});

Route::get('/user/dashboard', function () {
    $user = Auth::user();
    return '
    <div style="text-align:center; margin-top:100px; font-family:Arial;">
        <h2>Selamat datang di Dashboard Pengguna 👤</h2>
        <p>Anda login sebagai: <strong>' . $user->nama . '</strong></p>
        <form method="POST" action="' . route('logout') . '" style="margin-top:20px;">
            ' . csrf_field() . '
            <button type="submit" 
                style="padding:10px 25px; background:#0061ff; border:none; color:#fff; border-radius:6px; cursor:pointer;">
                🔒 Logout
            </button>
        </form>
    </div>';
});



Route::get('/', function () {
    return view('welcome');
});
