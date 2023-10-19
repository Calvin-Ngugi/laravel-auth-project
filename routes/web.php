<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ListingController;
use App\Models\Listing;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Single listings
Route::get('/listings/{id}', function ($id) {
    return view('listing', [
        'listing' => Listing::find($id)
    ]);
});

//Login
Route::get('/login', function () {
    return view('login');
});

Route::get('/register', function () {
    return view('register');
})->middleware('permission:create users');


Route::get('/', [ListingController::class, 'index'])->name('listings');

Route::get('/users', [AuthController::class, 'index'])->middleware('permission:view users')->name('users.index');

Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::post('/register', [AuthController::class, 'register'])->middleware('permission:create users')->name('register');

Route::get('/otp-verify', [AuthController::class, 'showOtpVerificationForm'])->name('otp_verify');

Route::post('/otp-verify', [AuthController::class, 'verifyOtp'])->name('otp_verify.post');

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/password/change', [AuthController::class, 'showPasswordChangeForm'])->name('password.change');

Route::post('/password/change', [AuthController::class, 'changePassword'])->name('password.change.post');

Route::get('/users/{id}/edit', [AuthController::class, 'editUser'])->middleware('permission:edit users')->name('editUser');

Route::put('/users/{id}', [AuthController::class, 'updateUser'])->middleware('permission:edit users')->name('updateUser');

Route::get('/admin/create-role', [AdminController::class, 'createRole'])->middleware('permission:create roles')->name('admin.createRole');

Route::post('/admin/create-role', [AdminController::class, 'createRole'])->middleware('permission:create roles')->name('admin.createRole.post');

Route::get('/admin/roles', [AdminController::class, 'showRoles'])->middleware('permission:view roles')->name('admin.showRoles');

Route::delete('/users/{id}', [AuthController::class, 'deleteUser'])->middleware('permission:delete users')->name('deleteUser');

Route::post('/admin/assign-role', [AdminController::class, 'assignRole'])->middleware('permission:edit roles')->name('admin.assignRole.post');

Route::get('/admin/roles/{id}/edit', [AdminController::class, 'editRole'])->middleware('permission:edit roles')->name('admin.editRole');

Route::get('/admin/roles/{id}', [AdminController::class, 'viewRole'])->middleware('permission:view roles')->name('admin.viewRole');

Route::put('/admin/roles/{id}', [AdminController::class, 'updateRole'])->middleware('permission:edit roles')->name('admin.updateRole');

