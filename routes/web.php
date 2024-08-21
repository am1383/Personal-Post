<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;

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

Route::get('register', [RegisterController::class, 'index'])->name('register.panel');

Route::get('boot', [LoginController::class, 'index'])->name('login.panel');

Route::get('logout', [LoginController::class, 'indexL'])->name('logout.panel');
