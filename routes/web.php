<?php

use App\Http\Controllers\Admin\AdminController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

//Route::resource('/admin/dashboard', AdminController::class)->only(['index']);

Route::prefix('admin')->group(function () {
    route::get('login', [AdminController::class, 'create'])->name('admin.login');
    route::post('login', [AdminController::class, 'store'])->name('admin.login.request');
    Route::group(['middleware' => 'admin'], function () {
        //Dashboard
        Route::resource('dashboard', AdminController::class)->only('index');
        //Display  Password
        Route::get('update-password',[AdminController::class,'edit'])->name('admin.update_password');
        //verify-password
        Route::post('verify-password',[AdminController::class,'verifyPassword'])->name('admin.verify.Password');
        //update Password Route
        Route::post('admin/update-password',[AdminController::class,'updatePasswordRequest'])->name('admin.update.password.request');

        //admin Info Update
        Route::get('update-details', [AdminController::class, 'editDetails'])->name('admin.update_details');

       Route::post('update-details', [AdminController::class, 'updateDetails'])->name('admin.update_details.request');
        //Admin logout
        Route::get('logout', [AdminController::class, 'destroy'])->name('admin.logout');
    });
});
