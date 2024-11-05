<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\Delivery_timeController;
use App\Http\Controllers\CurriculumController;

Route::prefix('admin')->namespace('Admin')->name('show.')->group(function () {
  Route::get('/banner_edit', [App\Http\Controllers\Admin\BannerController::class, 'showBannerEdit'])->name('banner.edit');

  Route::post('/banner_edit', [App\Http\Controllers\Admin\BannerController::class, 'showBannerStore'])->name('banner.store');

  Route::delete('/banner_edit/{id}', [App\Http\Controllers\Admin\BannerController::class, 'showBannerDelete'])->name('banner.delete');

  Route::get('/top', [App\Http\Controllers\Admin\TopController::class, 'showTop'])->name('top');

  Route::post('/logout', [App\Http\Controllers\Admin\TopController::class, 'logout'])->name('logout');

  Route::prefix('auth')->namespace('Auth')->group(function () {
    Route::get('/login', [App\Http\Controllers\Admin\Auth\LoginController::class, 'showLoginForm'])->name('login');

    Route::post('/login', [App\Http\Controllers\Admin\Auth\LoginController::class, 'login'])->name('login.send');

    Route::get('/register', [App\Http\Controllers\Admin\Auth\RegisterController::class, 'showRegisterForm'])->name('register');

    Route::post('/register', [App\Http\Controllers\Admin\Auth\RegisterController::class, 'register'])->name('register.create');
  });
});

Route::prefix('user')->namespace('User')->name('user.')->group(function () {
  Route::get('/login', [App\Http\Controllers\User\Auth\LoginController::class, 'showLoginForm'])->name('show.login');
  Route::post('/login', [App\Http\Controllers\User\Auth\LoginController::class, 'login'])->name('login');
  Route::post('/logout', [App\Http\Controllers\User\Auth\LoginController::class, 'logout'])->name('logout');

  Route::get('/top', [App\Http\Controllers\User\TopController::class, 'showTop'])->name('show.top');
  Route::get('/delivery/{id}', [App\Http\Controllers\User\DeliveryController::class, 'showDelivery'])->name('show.delivery')->middleware('auth');
  Route::post('/delivery/{id}', [App\Http\Controllers\User\DeliveryController::class, 'updateClearFlg'])->name('update.clearFlg')->middleware('auth');

  Route::get('/register', [App\Http\Controllers\User\Auth\RegisterController::class, 'showRegisterForm'])->name('show.register');
  Route::post('/register', [App\Http\Controllers\User\Auth\RegisterController::class, 'register'])->name('register');

  Route::get('/article/{id}', [App\Http\Controllers\User\ArticleController::class, 'showArticle'])->name('show.article')->middleware('auth');
  Route::get('/curriculum_list', [App\Http\Controllers\User\CurriculumController::class, 'showCurriculumList'])->name('show.curriculum.list');

  Route::get('/profile', [App\Http\Controllers\User\ProfileController::class, 'showProfileForm'])->name('show.profile')->middleware('auth');
  Route::get('/progress', [App\Http\Controllers\User\ProgressController::class, 'showProgress'])->name('show.progress')->middleware('auth');

  Route::get('/schedules/{yearMonth}/{grade}', [App\Http\Controllers\User\CurriculumController::class, 'schedules'])->name('schedules');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('user')->namespace('User')->name('user.')->group(function () {
  Route::get('/login', [App\Http\Controllers\User\Auth\LoginController::class, 'showLoginForm'])->name('show.login');
  Route::post('/login', [App\Http\Controllers\User\Auth\LoginController::class, 'login'])->name('login');
  Route::post('/logout', [App\Http\Controllers\User\Auth\LoginController::class, 'logout'])->name('logout');
  Route::get('/top', [App\Http\Controllers\User\TopController::class, 'showTop'])->name('show.top');
  Route::get('/delivery/{id}', [App\Http\Controllers\User\DeliveryController::class, 'showDelivery'])->name('show.delivery')->middleware('auth');
  Route::post('/delivery/{id}', [App\Http\Controllers\User\DeliveryController::class, 'updateClearFlg'])->name('update.clearFlg')->middleware('auth');
  Route::get('/register', [App\Http\Controllers\User\Auth\RegisterController::class, 'showRegisterForm'])->name('show.register');
  Route::post('/register', [App\Http\Controllers\User\Auth\RegisterController::class, 'register'])->name('register');
  Route::get('/article/{id}', [App\Http\Controllers\User\ArticleController::class, 'showArticle'])->name('show.article')->middleware('auth');
  Route::get('/curriculm_list', [App\Http\Controllers\User\CurriculumController::class, 'showCurriculumList'])->name('show.curriculum.list')->middleware('auth');
  Route::get('/profile', [App\Http\Controllers\User\ProfileController::class, 'showProfileForm'])->name('show.profile')->middleware('auth');
  Route::get('/progress', [App\Http\Controllers\User\ProgressController::class, 'showProgress'])->name('show.progress')->middleware('auth');
});

Route::prefix('admin')->namespace('Admin')->name('admin.')->group(function () {
  Route::get('/curriculum/grade/{gradeId}', [App\Http\Controllers\Admin\CurriculumController::class, 'getCurriculumsByGrade'])->name('curriculum.grade');
  Route::get('/curriculum/{gradeId}', [App\Http\Controllers\Admin\CurriculumController::class, 'index'])->name('curriculum.index');
  Route::get('/curriculum_edit/{id}', [App\Http\Controllers\Admin\CurriculumController::class, 'edit'])->name('curriculum.edit');
  Route::put('/curriculum_update', [App\Http\Controllers\Admin\CurriculumController::class, 'update'])->name('curriculum.update');
  Route::post('/delivery_time/store', [App\Http\Controllers\Admin\Delivery_timeController::class, 'store'])->name('delivery_time.store');
  Route::get('/delivery_time/show/{id}', [App\Http\Controllers\Admin\Delivery_timeController::class, 'show'])->name('delivery_time.show');
  Route::delete('/delivery_time/{id}', [App\Http\Controllers\Admin\Delivery_timeController::class, 'destroy'])->name('delivery_time.destroy');
  Route::get('/delivery_times/create', [App\Http\Controllers\Admin\CurriculumController::class, 'create'])->name('Curriculum.create');
});
