<?php

use App\Http\Controllers\AgencyController;
use App\Http\Controllers\AgencyUserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

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

Route::get('/agency/{agencyUuid}', [\App\Http\Controllers\ShopProductController::class, 'rediectPageFromAgency'])->name('agency.handle');

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

        Route::get('/agency-users/{id}/edit', [AgencyUserController::class, 'edit'])->name('agency_users.edit');
        Route::put('/agency-users/{id}', [AgencyUserController::class, 'update'])->name('agency_users.update');

    }
);
/**
 * route tạo đại lý
 */
