<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Route::any('/logout', [App\Http\Controllers\AuthController::class, 'logoutUser'])->name('logout');

// Login Route
Route::get('/login', [App\Http\Controllers\AuthController::class, 'index']);
Route::post('/login', [App\Http\Controllers\AuthController::class, 'login'])->name('login');

// Register Route
Route::get('/register', [App\Http\Controllers\AuthController::class, 'register']);
Route::post('/register', [App\Http\Controllers\AuthController::class, 'create']);

//Country State Route
Route::get('country/states', [App\Http\Controllers\AuthController::class, 'index']);
Route::post('fetch-states', [App\Http\Controllers\AuthController::class, 'fetchState']);

// Super Admin Routes
Route::group(['as' => 'superadmin.', 'prefix' => 'superadmin', 'namespace' => 'superadmin', 'middleware' => ['auth', 'superadmin']], function () {

    Route::get('dashboard', [App\Http\Controllers\SuperAdmin\DashboardController::class, 'index'])->name('dashboard');
});

// Admin Routes
Route::group(['as' => 'admin.', 'prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => ['auth', 'admin']], function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
});



