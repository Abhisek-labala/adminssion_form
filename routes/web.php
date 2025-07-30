<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdmissionRequestController;

Route::get('/', function () {
    return view('admission_form');
});

Route::get('/admissions', [AdmissionRequestController::class, 'index'])->name('admission.index');
Route::post('/admissions', [AdmissionRequestController::class, 'store'])->name('admission.store');
Route::get('/hospitals', [AdmissionRequestController::class, 'getHospitals']);
