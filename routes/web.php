<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\LinkController;
use App\Http\Controllers\TemplateLetterController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

Route::get('/', function () {
    return view('layouts.app');
});

Auth::routes();


Route::middleware(['auth'])
    ->prefix('dashboard')
    ->name('dashboard.')
    ->group(function () {
        Route::get("/", [DashboardController::class, "index"]);
        Route::resource('/users', UserController::class);
        Route::resource('/templates', TemplateLetterController::class);
        Route::resource('/links', LinkController::class);
    });

// Halaman Guest
Route::get('/link/{unique_code_link}', [GuestController::class, 'index'])->name('guest.index');
Route::get('/template-variables/{id}', [TemplateLetterController::class, 'getTemplateVariables'])->name('template.variables');

// Proses form input dari guest
Route::post('/link', [GuestController::class, 'store']);
