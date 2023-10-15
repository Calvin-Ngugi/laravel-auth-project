<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ListingController;
use App\Models\Listing;
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
Route::get('/listings/{id}', function($id) {
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
});


Route::get('/', [ListingController::class, 'index'])->name('listings');

Route::get('/users', [AuthController::class, 'index'])->name('users.index');

Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::get('/otp-verify', [AuthController::class, 'showOtpVerificationForm'])->name('otp_verify');

Route::post('/otp-verify', [AuthController::class, 'verifyOtp'])->name('otp_verify.post');

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/password/change', [AuthController::class, 'showPasswordChangeForm'])->name('password.change');

Route::post('/password/change', [AuthController::class, 'changePassword'])->name('password.change.post');

Route::get('/super-admin/roles', [AdminController::class, 'showRoles'])->middleware('role:super-admin')->name('admin.showRoles');

Route::post('/super-admin/assign-role', [AdminController::class, 'assignRole'])->middleware('role:super-admin')->name('admin.assignRole.post');
