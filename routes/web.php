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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('user')->namespace('User')->name('user.')->group(function () {
  Route::get('/login',[App\Http\Controllers\User\Auth\LoginController::class,'showLoginForm'])->name('show.login');
  Route::post('/login',[App\Http\Controllers\User\Auth\LoginController::class,'login'])->name('login');
  Route::post('/logout',[App\Http\Controllers\User\Auth\LoginController::class,'logout'])->name('logout');
  Route::get('/top',[App\Http\Controllers\User\TopController::class,'showTop'])->name('show.top');
  Route::get('/delivery/{id}',[App\Http\Controllers\User\DeliveryController::class,'showDelivery'])->name('show.delivery')->middleware('auth');
  Route::post('/delivery/{id}',[App\Http\Controllers\User\DeliveryController::class,'updateClearFlg'])->name('update.clearFlg')->middleware('auth');
  Route::get('/register',[App\Http\Controllers\User\Auth\RegisterController::class,'showRegisterForm'])->name('show.register');
  Route::post('/register',[App\Http\Controllers\User\Auth\RegisterController::class,'register'])->name('register');
  Route::get('/article/{id}',[App\Http\Controllers\User\ArticleController::class,'showArticle'])->name('show.article')->middleware('auth');
  Route::get('/curriculm_list',[App\Http\Controllers\User\CurriculumController::class,'showCurriculumList'])->name('show.curriculum.list')->middleware('auth');
  Route::get('/profile',[App\Http\Controllers\User\ProfileController::class,'showProfileForm'])->name('show.profile')->middleware('auth');
  Route::get('/progress',[App\Http\Controllers\User\ProgressController::class,'showProgress'])->name('show.progress')->middleware('auth');
});