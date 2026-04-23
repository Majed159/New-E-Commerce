<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Category\CategoryController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

//Route::resource('/admin/dashboard', AdminController::class)->only(['index']);

Route::prefix('admin')->group(function () {
    Route::get('auth/{provider}/redirect', [AdminController::class, 'redirectToProvider'])
        ->whereIn('provider', ['google', 'facebook'])
        ->name('admin.oauth.redirect');

    Route::get('auth/{provider}/callback', [AdminController::class, 'handleProviderCallback'])
        ->whereIn('provider', ['google', 'facebook'])
        ->name('admin.oauth.callback');

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

//    ==============================================================================================================
//                      Category
//    ==============================================================================================================

        Route::resource('categories', CategoryController::class);

        Route::post('update-category-status', [CategoryController::class, 'updateCategoryStatus']);
        Route::post('delete-category-image',[CategoryController::class,'deleteCategoryImage']);
       Route::post('delete-sizechart-image',[CategoryController::class,'deleteSizechartImage']);



//    ==============================================================================================================
//                      Product
//    ==============================================================================================================
        Route::resource('products', ProductController::class);
        Route::post('update-product-status', [ProductController::class, 'updateProductStatus']);
//        Route::post('create_edit_product', [ProductController::class, 'createEditProduct']);


        Route::post('/product/upload-image',[ProductController::class,'uploadImage'])->name('product.upload.image');
        Route::post('/product/upload-video',[ProductController::class,'uploadVideo'])->name('product.upload.video');
        Route::get('delete-product-main-image/{id}',[ProductController::class,'deleteProductMainImage']);
        Route::get('delete-product-video/{id}',[ProductController::class,'deleteProductVideo']);

             //Admin logout
        Route::get('logout', [AdminController::class, 'destroy'])->name('admin.logout');
    });
});
