<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\UserDashboardController;

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
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';



// Middleware for Role-based Access Control

Route::middleware(['auth', 'roles:admin'])->group(function () {
    // Admin specific routes can be added here
    Route::get('/admindashboard',[AdminDashboardController::class, 'admindashboard'])->name('admin.dashboard');

});

Route::middleware(['auth', 'roles:user'])->group(function () {
    // User specific routes can be added here
    Route::get('/userdashboard',[UserDashboardController::class, 'userdashboard'])->name('user.dashboard');
});
