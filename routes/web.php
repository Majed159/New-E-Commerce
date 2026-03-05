<?php

use App\Http\Controllers\Admin\AdminController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

//Route::resource('/admin/dashboard', AdminController::class)->only(['index']);

Route::prefix('admin')->group(function () {
    route::get('login', [AdminController::class, 'create'])->name('admin.login');
    Route::group(['middleware' => 'admin'], function () {
        Route::resource('dashboard', AdminController::class)->only('index');
    });
});
