<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\EmergencyContactController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\SosController;
use App\Livewire\GroundingExercise;
use Illuminate\Support\Facades\Route;

// Home + grounding exercise: always reachable, no login in front of "Calmify Me".
Route::get('/', GroundingExercise::class)->name('home');
Route::get('/sos', SosController::class)->name('sos');
Route::get('/einstellungen', SettingsController::class)->name('settings');

Route::middleware('guest')->group(function () {
    Route::get('/registrieren', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/registrieren', [RegisteredUserController::class, 'store'])->middleware('throttle:6,1');
    Route::get('/anmelden', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/anmelden', [AuthenticatedSessionController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    Route::post('/abmelden', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
    Route::delete('/konto', [AccountController::class, 'destroy'])->name('account.destroy');

    Route::resource('kontakte', EmergencyContactController::class)
        ->except('show')
        ->parameters(['kontakte' => 'contact'])
        ->names('contacts');
});
