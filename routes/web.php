<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\ProfileController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

//Admin Routes
Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin.')->group(function () {
    //Admin Login Routes
    Route::match(['get', 'post'],'login', [AdminController::class, 'login'])->name('login');

     Route::group(['middleware' => ['admin']], function () {
         //Admin Dashboard Routes
        Route::get('dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::post('logout', [AdminController::class, 'logout'])->name('logout');
        Route::match(['get', 'post'], 'update-admin-password', [AdminController::class, 'updateAdminPassword'])->name('admin-update-password');
         //Check current password
        Route::post( 'check-admin-password', [AdminController::class, 'checkAdminPassword'])->name('check-admin-password');
            //Update Admin Details
        Route::match(['get', 'post'], 'update-admin-details', [AdminController::class, 'updateAdminDetails'])->name('admin-update-details');
            //Update Vendor details
        Route::match(['get', 'post'], 'update-vendor-details/{slug}', [AdminController::class, 'updateVendorDetails'])->name('vendor-update-details');
        //View Admins / Sub Admins / Vendors

        Route::get('admins/{type?}', [AdminController::class, 'admins'])->name('admins');

        }




     );
});


