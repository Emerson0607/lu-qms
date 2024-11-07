<?php

namespace App\Http\Controllers;
use App\Models\Client;
use App\Models\Window;
use Illuminate\Http\Request;


class ClientController extends Controller
{
   
public function getOldestClient()
{
    // Fetch the oldest client from the clients table
    $client = Client::oldest()->first();

    if ($client) {
        // Store the data into the Window model
        $window = new Window();
        $window->name = $client->name;
        $window->number = $client->number;
        $window->save(); // Save the data to the Window model

        // Delete the client data after storing it in the Window model
        $client->delete();

        return response()->json([
            'name' => $client->name,
            'number' => $client->number,
        ]);
    } else {
        return response()->json([
            'message' => 'No clients found.'
        ], 404);
    }

}
}