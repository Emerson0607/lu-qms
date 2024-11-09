<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Models\Client;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\SessionController;

// Route to display the clients (home page)
Route::get('/', [ClientController::class, 'index']);

// Route to get all clients (for AJAX)
Route::get('/client', [ClientController::class, 'getAllClients'])->middleware('auth');

Route::get('/get-oldest-client', [ClientController::class, 'getOldestClient']);


Route::get('/homepage', [ClientController::class, 'homepage']);


Route::get('/register', [RegisteredUserController::class, 'create']);
Route::post('/register', [RegisteredUserController::class, 'store']);

Route::get('/login', [SessionController::class, 'create'])->name('login');
Route::post('/login', [SessionController::class, 'store']);
Route::post('/logout', [SessionController::class, 'destroy']);