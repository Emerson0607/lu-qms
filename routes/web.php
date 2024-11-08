<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Models\Client;
use App\Http\Controllers\ClientController;

// Route to display the clients (home page)
Route::get('/', [ClientController::class, 'index']);

// Route to get all clients (for AJAX)
Route::get('/client', [ClientController::class, 'getAllClients']);

Route::get('/get-oldest-client', [ClientController::class, 'getOldestClient']);