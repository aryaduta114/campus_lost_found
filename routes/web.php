<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\StaffReportController;
use App\Http\Controllers\ClaimController;
use App\Http\Controllers\StaffClaimController;
use App\Http\Controllers\ReturnController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminUserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'email.verified'])
    ->name('dashboard');

/*
|--------------------------------------------------------------------------
| User Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'email.verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

    Route::resource('/reports', ReportController::class);

    Route::get('/reports/{report}/claim', [ClaimController::class, 'create'])
        ->name('claims.create');

    Route::post('/reports/{report}/claim', [ClaimController::class, 'store'])
        ->name('claims.store');
});

/*
|--------------------------------------------------------------------------
| Staff Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'email.verified', 'staff'])->group(function () {
    Route::get('/staff/reports', [StaffReportController::class, 'index'])
        ->name('staff.reports.index');

    Route::patch('/staff/reports/{report}/approve', [StaffReportController::class, 'approve'])
        ->name('staff.reports.approve');

    Route::patch('/staff/reports/{report}/reject', [StaffReportController::class, 'reject'])
        ->name('staff.reports.reject');

    Route::get('/staff/claims', [StaffClaimController::class, 'index'])
        ->name('staff.claims.index');

    Route::patch('/staff/claims/{claim}/approve', [StaffClaimController::class, 'approve'])
        ->name('staff.claims.approve');

    Route::patch('/staff/claims/{claim}/reject', [StaffClaimController::class, 'reject'])
        ->name('staff.claims.reject');

    Route::get('/claims/{claim}/return', [ReturnController::class, 'create'])
        ->name('returns.create');

    Route::post('/claims/{claim}/return', [ReturnController::class, 'store'])
        ->name('returns.store');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'email.verified', 'admin'])->group(function () {
    Route::get('/admin/users', [AdminUserController::class, 'index'])
        ->name('admin.users.index');

    Route::patch('/admin/users/{user}/role', [AdminUserController::class, 'updateRole'])
        ->name('admin.users.update-role');

    Route::resource('/categories', CategoryController::class);

    Route::resource('/locations', LocationController::class);
});

require __DIR__.'/auth.php';