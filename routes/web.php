<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TicketController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

// Ticket Submission Route
Route::post('/submit-ticket', [TicketController::class, 'store'])->name('ticket.submit');

// Ticket Status Check
Route::get('/check-status', [TicketController::class, 'checkStatusForm'])->name('ticket.status.form');
Route::post('/check-status', [TicketController::class, 'checkStatus'])->name('ticket.status.check');

// Admin Routes
Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminController::class, 'loginForm'])->name('login');
    Route::post('/login', [AdminController::class, 'login']);
    Route::post('/logout', [AdminController::class, 'logout'])->name('admin.logout');

    Route::middleware('auth')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/ticket/{type}/{id}', [AdminController::class, 'show'])->name('admin.ticket.show');
        Route::put('/ticket/{type}/{id}', [AdminController::class, 'update'])->name('admin.ticket.update');
    });
});
