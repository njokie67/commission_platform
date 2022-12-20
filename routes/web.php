<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\DataManagerController;
use App\Http\Controllers\DataManagerSalesController;
use App\Http\Controllers\salesrepregistrationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

Route::redirect('/', '/dashboard', 301);

Auth::routes();

Route::middleware(['auth', 'active'])->group(function () {
    Route::get('dashboard', [DataManagerController::class, 'guide']);
});

Route::get('/add/new/organisation/url', [DataManagerController::class, 'addorgurl']);

Route::middleware(['auth', 'admin', 'organization'])->group(function () {
    Route::prefix('organization/{system_id}')->group(function () {
        Route::get('/dashboard', [DataManagerController::class, 'index']);
        Route::get('/reps', [DataManagerController::class, 'reps']);
        Route::get('/opportunities', [DataManagerController::class, 'opportunities']);
        Route::get('/reps/{id}', [DataManagerController::class, 'viewrep']);
        Route::post('/commission', [DataManagerController::class, 'postcommission']);
        Route::get('/management', [DataManagerController::class, 'management']);
        Route::post('/register', [DataManagerController::class, 'registerusers']);
    });
    Route::get('/documentation', function () {
        return 'pending discussion';
    });
});
Route::middleware(['auth'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
});
Route::middleware(['auth', 'admin'])->group(function () {
    Route::post('/add/new/api', [ApiController::class, 'newapi']);
    Route::get('/refresh/{system_id}', [ApiController::class, 'refresh']);
    Route::get('/admin/settings', [DataManagerController::class, 'settings']);
    Route::post('/delete/apiholder/{id}', [DataManagerController::class, 'removekey']);
});
Route::middleware(['auth', 'salesrep', 'active', 'organization'])->group(function () {
    Route::prefix('salesrep/{system_id}')->group(function () {
        Route::get('/dashboard', [DataManagerSalesController::class, 'index']);
    });
    Route::get('/documentation', function () {
        return 'pending discussion';
    });
});


Route::get('/registration/unique/{id}', [salesrepregistrationController::class, 'registration'])->name('salesrep.registration');

Route::post('/setnewpassword/user/{id}', [salesrepregistrationController::class, 'setnewpassword']);