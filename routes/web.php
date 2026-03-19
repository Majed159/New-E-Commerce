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
       //Delete Profile Image
        Route::post('delete-details', [AdminController::class, 'deleteProfileImage']);


        //SubAdmins
        Route::get('subAdmins', [AdminController::class, 'subAdmins'])->name('admin.subAdmins');

        //update subadmin status
        Route::post('update-subadmin-status', [AdminController::class, 'updateSubAdminsStatus']);
        //delete subadmin status
        Route::get('delete-subadmin/{id}', [AdminController::class, 'deleteSubAdmin']);
       //add or edit subadmin
        Route::get('add-edit-subadmin/{id?}', [AdminController::class, 'editSubAdmin']);


        Route::get('update-role/{id?}', [AdminController::class, 'UpdateRole'])->name('admin.update_role');
        Route::post('update-role/request', [AdminController::class, 'UpdateRoleRequest'])->name('admin.update_role.request');


        Route::post('add-edit-subadmin/request', [AdminController::class, 'addEditSubAdminRequest']);
        //Admin logout
        Route::get('logout', [AdminController::class, 'destroy'])->name('admin.logout');
    });
});
