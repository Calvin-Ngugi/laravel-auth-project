<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\BillingController;
use App\Http\Controllers\CheckUpController;
use App\Http\Controllers\DiagnosisController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\ServiceController;
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

    Route::get('/services', [ServiceController::class, 'index'])->middleware('permission:view services')->name('services.index');

    Route::get('/services/create', [ServiceController::class, 'create'])->name('services.create');

    Route::post('/services', [ServiceController::class, 'post'])->name('services.post');

    Route::get('/services/{id}', [ServiceController::class, 'show'])->name('services.show');

    Route::get('/services/{id}/edit', [ServiceController::class, 'edit'])->name('services.edit');

    Route::put('/services/{id}', [ServiceController::class, 'update'])->name('services.update');

    Route::get('/services-search', [ServiceController::class, 'liveSearch'])->name('services.live-search');

    Route::get('/medicine', [MedicineController::class, 'index'])->name('medicine.index');

    Route::get('/medicine/create', [MedicineController::class, 'create'])->name('medicine.create');

    Route::post('/medicine', [MedicineController::class, 'post'])->name('medicine.post');

    Route::get('/medicine/{id}', [MedicineController::class, 'show'])->name('medicine.show');

    Route::get('/medicine/{id}/edit', [MedicineController::class, 'edit'])->name('medicine.edit');

    Route::put('/medicine/{id}', [MedicineController::class, 'update'])->name('medicine.update');

    Route::get('/medicine-search', [MedicineController::class, 'liveSearch'])->name('medicine.live-search');

    Route::get('/rooms', [RoomController::class, 'index'])->name('rooms.index');

    Route::get('/rooms/create', [RoomController::class, 'create'])->name('rooms.create');

    Route::post('/rooms', [RoomController::class, 'post'])->name('rooms.post');

    Route::get('/rooms/{id}', [RoomController::class, 'show'])->name('rooms.show');

    Route::get('/rooms/{id}/edit', [RoomController::class, 'edit'])->name('rooms.edit');

    Route::put('/rooms/{id}', [RoomController::class, 'update'])->name('rooms.update');

    Route::get('/diagnosis/create', [DiagnosisController::class, 'create'])->name('diagnosis.create');

    Route::post('/diagnosis', [DiagnosisController::class, 'post'])->name('diagnosis.post');

    Route::get('/appointments/create', [AppointmentController::class, 'create'])->name('appointment.create');

    Route::get('/appointments', [AppointmentController::class, 'index'])->name('appointment.index');

    Route::get('/appointments/{patient_id}/checkup/{id}', [AppointmentController::class, 'checkup'])->name('appointment.checkup');

    Route::post('/appointments/{appointmentId}/checkup', [AppointmentController::class, 'postCheckup'])->name('appointment.postCheckup');

    Route::get('/appointments/{patient_id}/diagnosis/{id}', [AppointmentController::class, 'diagnosis'])->name('appointment.diagnosis');

    Route::post('/appointments/{appointmentId}/diagnosis', [AppointmentController::class, 'postDiagnosis'])->name('appointment.postDiagnosis');

    Route::post('/appointments', [AppointmentController::class, 'post'])->name('appointment.post');

    Route::post('/appointments/{appointmentId}/assign-room', [RoomController::class, 'assignRoom'])->name('rooms.assignRoom');

    Route::post('/appointments/{appointmentId}/proceed-to-diagnosis', [AppointmentController::class, 'proceedToDiagnosis'])->name('appointments.proceedToDiagnosis');

    Route::post('/appointments/{appointmentId}/proceed-to-billing', [AppointmentController::class, 'proceedToBilling'])->name('appointment.proceedToBilling');

    Route::post('/appointments/{appointmentId}/checkout', [AppointmentController::class, 'checkout'])->name('appointment.checkout');

    Route::post('/patients/{id}/create-appointment', [PatientController::class, 'createAppointment'])->name('patients.createAppointment');

    Route::get('/appointments/billing', [BillingController::class, 'index'])->name('appointment.billing');

    Route::post('/appointments/{appointmentId}/pay-checkup', [AppointmentController::class, 'payCheckup'])->name('appointments.payCheckup');
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
