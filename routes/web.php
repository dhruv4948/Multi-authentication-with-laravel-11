<?php

use App\Http\Controllers\admin\AdminDashboardContorller;
use App\Http\Controllers\admin\AdminLoginContorller;
use App\Http\Controllers\DashboardContorller;
use App\Http\Controllers\LoginContorller;
use Illuminate\Support\Facades\Route;
use Symfony\Component\Mailer\Transport\Smtp\Auth\LoginAuthenticator;

// Route::get('/', function () {
//     return view('welcome');
// });


Route::group(['prefix' => 'account'], function () {
    Route::group(['Middleware' => 'guests'], function () {
        Route::get('login', [LoginContorller::class, 'index'])->name('account.login');
        Route::get('Register', [LoginContorller::class, 'register'])->name('account.register');
        Route::post('Process-Register', [LoginContorller::class, 'processRegistration'])->name('account.processRegistration');
        Route::post('authenticate', [LoginContorller::class, 'authenticate'])->name('account.authenticate');

    });
    Route::group(['Middleware' => 'auth'], function () {
        Route::get('Logout', [LoginContorller::class, 'logout'])->name('account.logout');
        Route::get('Dashboard', [DashboardContorller::class, 'index'])->name('account.dashboard');

    });
});


//  Admin Routes
Route::group(['prefix' => 'admin'], function () {
    Route::group(['Middleware' => 'admin.guest'], function () {
        Route::get('login', [AdminLoginContorller::class, 'index'])->name('admin.login');
        Route::post('authenticate', [AdminLoginContorller::class, 'authenticate'])->name('admin.authenticate');

    });
    Route::group(['Middleware' => 'admin.auth'], function () {
        Route::get('dashboard', [AdminDashboardContorller::class, 'index'])->name('admin.dashboard');
        Route::get('logout', [AdminLoginContorller::class, 'logout'])->name('admin.logout');
    });
});

