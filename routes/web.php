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

Route::group(['middleware' => 'auth'], function() {
    // dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // profile
    Route::get('/profile', function() {
        return view('profile');
    })->name('profile');

    // notification
    Route::get('/notification/{slug}', function() {
        return view('notification');
    })->name('notification.show');

    // users
    Route::get('/users/create', function() {
        return view('users.create');
    })->middleware(['permission:administer users'])->name('users.create');
    
    Route::get('/users/{id}/edit', function($id) {
        return view('users.edit', compact('id'));
    })->middleware(['permission:administer users|view admin dashboard'])->name('users.edit');
});

require __DIR__.'/auth.php';
