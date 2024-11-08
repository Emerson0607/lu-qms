<?php

namespace App\Http\Controllers;
use App\Models\Client;
use App\Models\Window;
use Illuminate\Http\Request;


class ClientController extends Controller
{

     // Method to display the clients on the home page
     public function index()
     {
         // Get all clients
         $clients = Client::all();
         
         // Get the oldest client
         $oldestClient = Client::orderBy('created_at', 'asc')->first();
         
         // Pass both clients and the oldest client data to the view
         return view('layout', [
             'clients' => $clients,
             'oldestClient' => $oldestClient
         ]);
     }
 
     // Method to get all clients (for AJAX)
     public function getAllClients()
     {
         // Return all clients as JSON
         return response()->json(Client::all()->toArray());
     }
   
    public function getOldestClient()
    {
        // Fetch the oldest client from the clients table
        $client = Client::oldest()->first();

        if ($client) {
            // Delete previous data from the Window model
            Window::truncate();  // This will delete all records in the Window table

            // Store the data into the Window model
            $window = new Window();
            $window->name = $client->name;
            $window->w_id = $client->w_id; //this is for latur *********************************





            $window->number = $client->number;
            $window->save(); // Save the data to the Window model

            // Delete the client data after storing it in the Window model
            $client->delete();

            return response()->json([
                'name' => $window->name,
                'number' => $window->number,
            ]);
        } else {
            return response()->json([
                'message' => 'No clients found.'
            ], 404);
        }

    }
}