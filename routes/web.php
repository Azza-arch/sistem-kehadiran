<?php

use App\Http\Controllers\AdminController;
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

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('home', 'home')
    ->middleware(['auth.admin', 'verified'])
    ->name('home');

Route::get('/user-report/{userId}', [AdminController::class, 'userReport'])
    ->name('user-report');
Route::get('/user-info-edit/{userId}', [AdminController::class, 'userInfo'])
->name('user-info');

Route::get('/create-worker', [AdminController::class, 'createUser'])
->name('create-worker');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__ . '/auth.php';
