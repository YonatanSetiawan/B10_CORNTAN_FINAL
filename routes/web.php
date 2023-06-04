<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KalenderTanam;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LandingPageController;
// use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Auth::routes();

Route::get('/', [LandingPageController::class, 'index'])->name('landing');

Route::group(['middleware' => 'auth'], function() {
    Route::get('/kalender', [KalenderTanam::class, 'index'])->name('kalender');
    Route::post('schedule', [KalenderTanam::class, 'tambah_rencana'])->name('schedule.store');
    Route::post('schedule/update/{id}', [KalenderTanam::class, 'update_rencana'])->name('schedule.update');
    
    Route::get('/admin', [AdminController::class, 'index'])->name('home')->middleware('admin');
    Route::get('/user', [UserController::class, 'index'])->name('user');
    Route::get('/user/dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');
    Route::post('user/update/{id}', [UserController::class, 'update'])->name('user.update');
    Route::post('user/upgrade/{id}', [UserController::class, 'upgrade'])->name('user.upgrade');
    Route::post('user/payment/{id}', [UserController::class, 'payment'])->name('user.payment');

    Route::post('/admin/approve/{id}', [AdminController::class, 'approve'])->name('admin.approve');
    Route::post('/admin/reject/{id}', [AdminController::class, 'reject'])->name('admin.reject');
});

Route::get('/home', [HomeController::class, 'index']);