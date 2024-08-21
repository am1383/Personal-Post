<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\AdminController;

Route::post('admin/show', [AdminController::class, 'showPost']);

Route::post('admin/add', [AdminController::class, 'addPost']);

Route::group(['middleware' => ['auth:api']], function () {
    Route::post('logout', [LoginController::class, 'logout'])->name('logout.api');
});

Route::group(['middleware' => ['guest:api']], function () {
    Route::post('register', [RegisterController::class, 'register'])->name('api.register');
    Route::post('boot', [LoginController::class, 'login'])->name('api.login');
});
