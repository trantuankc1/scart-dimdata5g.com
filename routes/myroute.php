<?php

use App\Http\Controllers\AgencyDashBoardController;
use App\Http\Controllers\AgencyUserLogin;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Customize web Routes
|--------------------------------------------------------------------------
|
 */

/**
 * Route Login Agency User
 */
Route::get('/agency-login', [AgencyUserLogin::class, 'formLogin'])->name('agency_users.login');
Route::post('/agency-login', [AgencyUserLogin::class, 'login'])->name('agency_users.login');
Route::get('/logout', [AgencyUserLogin::class, 'logoutAgencyUser'])->name('agency_users.logout');

Route::prefix('/agency')->middleware('checkLoginUserAgency')->group(function () {
    Route::get('/dashboard', [AgencyDashBoardController::class, 'index'])->name('agency_user.dashboard');
});
