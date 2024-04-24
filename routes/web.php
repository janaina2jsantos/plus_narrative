<?php

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

// home
Route::get('/', function () {
    return view('welcome');
});

// dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

// profile
Route::get("/profile", function() {
    return view('profile');
})->middleware('auth')->name('profile');

// notification
Route::get("/notification/{slug}", function() {
    return view('notification');
})->middleware('auth')->name('notification.show');

// users
Route::prefix('users')->group(function () {
    Route::get("/create", function() {
        return view('users.create');
    })->middleware(['auth', 'permission:administer users'])->name('users.create');

    Route::get('/{id}/edit', function() {
        return view('users.edit');
    })->middleware(['auth', 'permission:administer users|view admin dashboard'])->name('users.edit');
   
    Route::get('/{id}/delete', ['middleware' => ['auth', 'permission:administer users'], 'uses' => [\App\Http\Livewire\Users::class, 'delete']])->name('users.delete');
});

require __DIR__.'/auth.php';
