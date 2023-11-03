<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CheckUpController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ServiceController;
use App\Models\CheckUp;
use App\Models\Listing;
use App\Models\User;
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

Route::middleware(['auth'])->group(function () {
    //Single listings
    Route::get('/listings/{id}', function ($id) {
        return view('listing', [
            'listing' => Listing::find($id)
        ]);
    });

    Route::get('/register', [AuthController::class, 'signup'])->middleware('permission:create users')->name('register');

    Route::get('/users/{id}', [AuthController::class, 'single'])->middleware('permission:view users')->name('users.single');

    Route::get('/', [ListingController::class, 'index'])->name('listings');

    Route::get('/users', [AuthController::class, 'index'])->middleware('permission:view users')->name('users.index');

    Route::post('/register', [AuthController::class, 'register'])->middleware('permission:create users')->name('register');

    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/users/{id}/edit', [AuthController::class, 'editUser'])->middleware('permission:edit users')->name('editUser');

    Route::put('/users/{id}', [AuthController::class, 'updateUser'])->middleware('permission:edit users')->name('updateUser');

    Route::get('/admin/create-role', [AdminController::class, 'createRole'])->middleware('permission:create roles')->name('admin.createRole');

    Route::post('/admin/create-role', [AdminController::class, 'createRole'])->middleware('permission:create roles')->name('admin.createRole.post');

    Route::get('/admin/roles', [AdminController::class, 'showRoles'])->middleware('permission:view roles')->name('admin.showRoles');

    Route::delete('/users/{id}/delete', [AuthController::class, 'deleteUser'])->middleware('permission:delete users')->name('deleteUser');

    Route::post('/admin/assign-role', [AdminController::class, 'assignRole'])->middleware('permission:edit roles')->name('admin.assignRole.post');

    Route::get('/admin/roles/{id}/edit', [AdminController::class, 'editRole'])->middleware('permission:edit roles')->name('admin.editRole');

    Route::get('/admin/roles/{id}', [AdminController::class, 'viewRole'])->middleware('permission:view roles')->name('admin.viewRole');

    Route::put('/admin/roles/{id}', [AdminController::class, 'updateRole'])->middleware('permission:edit roles')->name('admin.updateRole');

    Route::delete('/admin/remove-permission', [AdminController::class, 'removePermission'])->name('admin.removePermission');

    Route::get('/users/{id}/delete', [AuthController::class, 'deleteUser'])->middleware('permission:delete users')->name('deleteUser');

    Route::get('/users/{id}/enable', [AuthController::class, 'enableUser'])->middleware('permission:approve changes')->name('enableUser');

    Route::post('/users/{id}/enable', [AuthController::class, 'enableUser'])->middleware('permission:approve changes')->name('enableUser');

    Route::get('/users/{id}/disable', [AuthController::class, 'disableUser'])->middleware('permission:approve changes')->name('disableUser');

    Route::delete('/users/{id}/disable', [AuthController::class, 'disableUser'])->middleware('permission:approve changes')->name('disableUser');

    Route::get('/patients', [PatientController::class, 'index'])->middleware('permission:view patients')->name('patients.index');

    Route::get('/patients/create', [PatientController::class, 'create'])->middleware('permission:create patients')->name('patients.create');

    Route::post('/patients', [PatientController::class, 'post'])->middleware('permission:create patients')->name('patients.post');

    Route::get('/patients/{id}', [PatientController::class, 'show'])->middleware('permission:view patients')->name('patients.show');

    Route::put('/patients/{id}', [PatientController::class, 'update'])->middleware('permission:edit patients')->name('patients.update');
    
    Route::get('/patients/{id}/edit', [PatientController::class, 'edit'])->middleware('permission:edit patients')->name('patients.edit');

    Route::get('/patients-search', [PatientController::class, 'liveSearch'])->name('patients.live-search');
    
    Route::get('/checkups', [CheckUpController::class, 'index'])->middleware('permission:view checkups')->name('checkups.index');
    
    Route::get('checkups/create', [CheckUpController::class, 'create'])->middleware('permission:create checkups')->name('checkups.create');
    
    Route::post('/checkups', [CheckUpController::class, 'post'])->middleware('permission:create checkups')->name('checkups.post');
    
    Route::get('/checkups/{id}', [CheckUpController::class, 'show'])->middleware('permission:view checkups')->name('checkups.show');
    
    Route::get('/checkups/{id}/edit', [CheckUpController::class, 'edit'])->middleware('permission:edit checkups')->name('checkups.edit');
    
    Route::put('/checkups/{id}', [CheckUpController::class, 'update'])->middleware('permission:edit checkups')->name('checkups.update');
    
    Route::get('/checkups-search', [CheckUpController::class, 'liveSearch'])->name('checkups.live-search');

    Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
    
    Route::get('/medicine', [MedicineController::class, 'index'])->name('medicine.index');
});


//Login
Route::get('/login', function () {
    return view('login');
});

Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::get('/otp-verify', [AuthController::class, 'showOtpVerificationForm'])->name('otp_verify');

Route::post('/otp-verify', [AuthController::class, 'verifyOtp'])->name('otp_verify.post');

Route::get('/password/change', [AuthController::class, 'showPasswordChangeForm'])->name('password.change');

Route::post('/password/change', [AuthController::class, 'changePassword'])->name('password.change.post');
