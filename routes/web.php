<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'fr', 'ar'])) {
        session()->put('app_locale', $locale);
    }
    return redirect()->back();
})->name('lang.switch');

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DoctorSearchController;
use App\Http\Controllers\AppointmentController;

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    
    Route::get('/doctors', [DoctorSearchController::class, 'index'])->name('doctors.index');
    Route::get('/doctors/{doctor}', [DoctorSearchController::class, 'show'])->name('doctors.show');
    
    Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');
    Route::patch('/appointments/{appointment}/status', [AppointmentController::class, 'updateStatus'])->name('appointments.updateStatus');
    Route::patch('/appointments/{appointment}/notes', [AppointmentController::class, 'updateNotes'])->name('appointments.updateNotes');
    
    Route::get('/messages', [\App\Http\Controllers\MessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/{user}', [\App\Http\Controllers\MessageController::class, 'show'])->name('messages.show');
    Route::post('/messages/{user}', [\App\Http\Controllers\MessageController::class, 'store'])->name('messages.store');

    Route::post('/appointments/{appointment}/reviews', [\App\Http\Controllers\ReviewController::class, 'store'])->name('reviews.store');

    Route::post('/doctor/unavailabilities', [\App\Http\Controllers\DoctorUnavailabilityController::class, 'store'])->name('doctor.unavailabilities.store');
    Route::delete('/doctor/unavailabilities/{unavailability}', [\App\Http\Controllers\DoctorUnavailabilityController::class, 'destroy'])->name('doctor.unavailabilities.destroy');

    Route::get('/export/patient-history', [\App\Http\Controllers\PdfExportController::class, 'exportPatientHistory'])->name('export.patient.history');
    Route::get('/export/doctor-schedule', [\App\Http\Controllers\PdfExportController::class, 'exportDoctorSchedule'])->name('export.doctor.schedule');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
