<?php

use App\Http\Controllers\AgencyController;
use App\Http\Controllers\AgencyDashBoardController;
use App\Http\Controllers\AgencyUserController;
use App\Http\Controllers\AgencyUserLogin;
use App\Http\Controllers\AgencyWithdrawalController;
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
// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/agency-login', [AgencyUserLogin::class, 'formLogin'])->name('agency_users.login');
Route::post('/agency-login', [AgencyUserLogin::class, 'login'])->name('agency_users.login');
Route::get('/logout', [AgencyUserLogin::class, 'logoutAgencyUser'])->name('agency_users.logout');

Route::prefix('agency')->middleware('checkLoginUserAgency')->group(function () {
    Route::get('/dashboard', [AgencyDashBoardController::class, 'index'])->name('agency_user.dashboard');

    Route::get('/withdraw', [AgencyWithdrawalController::class, 'index'])->name('agency_user.withdraw');
    Route::post('/process-withdraw', [AgencyWithdrawalController::class, 'processWithdraw'])->name('agency_user.process_withdraw');
    Route::get('/list-transaction', [AgencyWithdrawalController::class, 'listTransaction'])->name('agency_user.listTransaction');
    Route::get('/edit-info-bank/{id}', [AgencyWithdrawalController::class, 'editInfoPayout'])->name('agency_user.edit_info_bank');
    Route::put('/update-info-bank/{id}', [AgencyWithdrawalController::class, 'updateInfoBank'])->name('agency_user.update_info_bank');


    Route::get('/link/{agencyUuid}', [AgencyDashBoardController::class, 'redirectPageFromAgency'])->name('redirect.from.agency');
});

Route::group(
    [
        'prefix' => SC_ADMIN_PREFIX,
        'middleware' => SC_ADMIN_MIDDLEWARE,
    ],
    function () {
        foreach (glob(__DIR__ . '/Routes/*.php') as $filename) {
            require_once $filename;
        }
        if (file_exists(app_path('Admin/Controllers/DashboardController.php'))) {
            $nameSpaceAdminDashboard = 'App\Admin\Controllers';
        } else {
            $nameSpaceAdminDashboard = 'SCart\Core\Admin\Controllers';
        }

        /**
         * create lever agency
         */

        Route::get('/list-agency', [AgencyController::class, 'index'])->name('agency.index');
        Route::get('/create-agency', [AgencyController::class, 'create'])->name('agency.create');
        Route::post('/create-agency', [AgencyController::class, 'store'])->name('agency.store');
        Route::get('/agency/{id}/edit', [AgencyController::class, 'edit'])->name('agencies.edit');
        Route::put('/agency/{id}', [AgencyController::class, 'update'])->name('agencies.update');
        Route::delete('/agencies/{id}', [AgencyController::class, 'destroy'])->name('agencies.destroy');

        /**
         *  create user agency
         */
        Route::get('/list-agency-user', [AgencyUserController::class, 'index'])->name('agency_users.index');
        Route::get('/agency_users/create', [AgencyUserController::class, 'create'])->name('agency_users.create');
        Route::post('/agency_users', [AgencyUserController::class, 'store'])->name('agency_users.store');

        Route::get('/agency_users/{agencyId}/edit', [AgencyUserController::class, 'edit'])->name('agency_users.edit');
        Route::put('/agency-user/{id}', [AgencyUserController::class, 'update'])->name('agency_users.update');
        Route::delete('/agency-user/{id}', [AgencyUserController::class, 'delete'])->name('agency_users.destroy');
    }
);

