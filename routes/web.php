<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RoomController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

// Redirects authenticated users to dashboard, others to login

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});

// Dashboard

Route::get('/', [DashboardController::class, 'index'])
    ->name('dashboard')
    ->middleware('auth');

// Rooms

Route::get('rooms', [RoomController::class, 'index'])
    ->name('rooms.index')
    ->middleware('auth');
Route::get('rooms/create', [RoomController::class, 'create'])
    ->name('rooms.create')
    ->middleware('auth');
Route::post('rooms/store', [RoomController::class, 'store'])
    ->name('rooms.store')
    ->middleware('auth');
Route::get('rooms/{room}/edit', [RoomController::class, 'edit'])
    ->name('rooms.edit')
    ->middleware('auth');
Route::put('rooms/{roomId}', [RoomController::class, 'update'])
    ->name('rooms.update')
    ->middleware('auth');
Route::delete('rooms/delete/{roomId}', [RoomController::class, 'destroy'])
    ->name('rooms.destroy')
    ->middleware('auth');




require __DIR__.'/auth.php';
