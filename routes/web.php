<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::prefix('user')->namespace('User')->name('show.')->group(function () {
    Route::get('/curriculum_list', [App\Http\Controllers\User\CurriculumController::class, 'showCurriculumList'])->name('curriculum');

    Route::get('/schedules/{yearMonth}/{grade}', [App\Http\Controllers\User\CurriculumController::class, 'schedules'])->name('schedules');

    Route::post('/logout', [App\Http\Controllers\User\CurriculumController::class, 'logout'])->name('logout');
});

Route::prefix('admin')->namespace('Admin')->name('show.')->group(function () {
    Route::get('/banner_edit', [App\Http\Controllers\Admin\BannerController::class, 'showBannerEdit'])->name('banner.edit');

    Route::post('/banner_edit', [App\Http\Controllers\Admin\BannerController::class, 'showBannerStore'])->name('banner.store');

    Route::delete('/banner_edit', [App\Http\Controllers\Admin\BannerController::class, 'showBannerDelete'])->name('banner.delete');

    Route::get('/top', [App\Http\Controllers\Admin\TopController::class, 'showTop'])->name('top');

    Route::post('/logout', [App\Http\Controllers\Admin\TopController::class, 'logout'])->name('logout');

    Route::prefix('auth')->namespace('Auth')->group(function () {
        Route::get('/login', [App\Http\Controllers\Admin\Auth\LoginController::class, 'showLoginForm'])->name('login');

        Route::post('/login', [App\Http\Controllers\Admin\Auth\LoginController::class, 'login'])->name('login.send');

        Route::get('/register', [App\Http\Controllers\Admin\Auth\RegisterController::class, 'showRegisterForm'])->name('register');

        Route::post('/register', [App\Http\Controllers\Admin\Auth\RegisterController::class, 'register'])->name('register.create');
    });
});



Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/', function () {
    return view('welcome');
    });
    
