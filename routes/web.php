<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Models\Client;
use App\Http\Controllers\ClientController;


// Route to display the clients (home page)
Route::get('/', function () {
  // Get all clients
  $clients = Client::all();
    
  // Get the oldest client
  $oldestClient = Client::orderBy('created_at', 'asc')->first();  // Find the oldest client
  
  // Pass both clients and the oldest client data to the view
  return view('layout', [
      'clients' => $clients,
      'oldestClient' => $oldestClient
  ]);
});

// Route to get all clients (for AJAX)
Route::get('/client', function () {
    return response()->json(Client::all()->toArray());  // Ensure this is an array
});

Route::get('/get-oldest-client', [ClientController::class, 'getOldestClient']);