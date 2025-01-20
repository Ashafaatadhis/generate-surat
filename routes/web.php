<?php

use App\Http\Controllers\GuestController;
use App\Http\Controllers\TemplateLetterController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();


Route::middleware(['auth'])
    ->prefix('dashboard')
    ->name('dashboard.')
    ->group(function () {
        Route::resource('/users', UserController::class);
        Route::resource('/templates', TemplateLetterController::class);
    });

// Halaman Guest
Route::get('/', [GuestController::class, 'index'])->name('guest.index');
Route::get('/template-variables/{id}', [TemplateLetterController::class, 'getTemplateVariables'])->name('template.variables');

// Proses form input dari guest
Route::post('/', [GuestController::class, 'store'])->name('guest.store');
