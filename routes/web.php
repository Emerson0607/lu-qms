<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Models\Client;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\SessionController;

// Route to display the clients (home page)
Route::get('/', [ClientController::class, 'index']);

Route::controller(ClientController::class)->group(function () {
    Route::get('/client', 'getAllClients')->middleware('auth');
    Route::get('/get-oldest-client', 'getOldestClient');
    Route::get('/windows', 'getAllWindows');
    Route::get('/waitingQueue', 'waitingQueue');
    Route::get('/homepage', 'homepage');
});

Route::controller(RegisteredUserController::class)->group(function () {
    Route::get('/register', 'create');
    Route::post('/register', 'store');
});

Route::controller(SessionController::class)->group(function () {
    Route::get('/login', 'create')->name('login');
    Route::post('/login', 'store');
    Route::post('/logout', 'destroy');
});