<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Auth;

// ===============
// 🧍 Guest Route
// ===============
Route::middleware('role:guest')->group(function () {
    Route::get('/', [LoginController::class, 'showLoginForm'])->name('login.form');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');

    Route::get('/register', [RegisterController::class, 'showForm'])->name('register.form');
    Route::post('/register', [RegisterController::class, 'register'])->name('register.post');
});

// Logout
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// ===============
// 👑 Admin Route
// ===============
Route::middleware('role:admin')->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/pengguna', [AdminController::class, 'pengguna'])->name('admin.pengguna');
    Route::post('/admin/pengguna/store', [AdminController::class, 'storePengguna'])->name('admin.pengguna.store');
    Route::post('/admin/pengguna/update/{id}', [AdminController::class, 'updatePengguna'])->name('admin.pengguna.update');
    Route::delete('/admin/pengguna/delete/{id}', [AdminController::class, 'destroyPengguna'])->name('admin.pengguna.delete');

    Route::get('/admin/laporan-hilang', [AdminController::class, 'laporanHilang'])->name('admin.laporan-hilang');
    Route::post('/admin/laporan-hilang/store', [AdminController::class, 'storeLaporanHilang'])->name('admin.laporan-hilang.store');
    Route::post('/admin/laporan-hilang/update/{id}', [AdminController::class, 'updateLaporanHilang'])->name('admin.laporan-hilang.update');
    Route::delete('/admin/laporan-hilang/delete/{id}', [AdminController::class, 'destroyLaporanHilang'])->name('admin.laporan-hilang.delete');

    Route::get('/admin/laporan-temuan', [AdminController::class, 'laporanTemuan'])->name('admin.laporan-temuan');
    Route::post('/admin/laporan-temuan/store', [AdminController::class, 'storeLaporanTemuan'])->name('admin.laporan-temuan.store');
    Route::post('/admin/laporan-temuan/update/{id}', [AdminController::class, 'updateLaporanTemuan'])->name('admin.laporan-temuan.update');
    Route::delete('/admin/laporan-temuan/delete/{id}', [AdminController::class, 'destroyLaporanTemuan'])->name('admin.laporan-temuan.delete');
});

// ===============
// 👤 User Route
// ===============
Route::middleware('role:user')->group(function () {
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
    })->name('user.dashboard');
});
