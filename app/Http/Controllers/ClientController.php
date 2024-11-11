<?php

namespace App\Http\Controllers;
use App\Models\Client;
use App\Models\Window;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ClientController extends Controller
{
    public function homepage()
    {
        return view('homepage');
    }

     // Method to display the clients on the home page
     public function index()
     {
         return view('layout');
     }
 
     // Method to get all clients (for AJAX)
     public function getAllClients()
     {
        $currentDepartment = Auth::user()->department;

        $clients = Client::where('department', $currentDepartment)->get();

        return response()->json($clients);
     }


    // // Method to get all window (for AJAX)
    // public function getAllWindows()
    // {
    //     $currentDepartment = Auth::user()->department;
    //     $window_queue = Window::where('department', 'IT')->get();

    //     return response()->json($window_queue);
    // }

    public function getAllWindows()
    {
        $currentDepartment = Auth::user()->department;
    
        // Fetch the windows and join with window_list to fetch the window name
        $window_queue = Window::where('department', $currentDepartment)
            ->leftJoin('window_list', 'windows.w_id', '=', 'window_list.w_id')
            ->select('windows.*', 'window_list.name as window_name') // Selecting the window data and name from window_list
            ->get();
    
        // Return the result as JSON
        return response()->json($window_queue);
    }
    

   
    public function getOldestClient()
    {
        // Fetch the oldest client from the clients table

        $currentDepartment = Auth::user()->department;
        $user_w_id = Auth::user()->w_id;
        $client = Client::where('department', $currentDepartment)->oldest()->first();

        // if ($client) {
        //     // Delete previous data from the Window model
        //     Window::truncate();  // This will delete all records in the Window table

        //     // Store the data into the Window model
        //     $window = new Window();
        //     $window->name = $client->name;
        //     $window->w_id = $user_w_id; 
        //     $window->department = $client->department;
        //     $window->number = $client->number;
        //     $window->save(); // Save the data to the Window model

        //     // Delete the client data after storing it in the Window model
        //     $client->delete();

        //     return response()->json([
        //         'name' => $window->name,
        //         'number' => $window->number,
        //         'w_id' => Auth::user()->w_id,
        //         'department' => $window->department,
        //     ]);
        // } else {
        //     return response()->json([
        //         'message' => 'No clients found.'
        //     ], 404);
        // }


        if ($client) {
            // Update or create the Window record with matching w_id and department
            Window::updateOrCreate(
                ['w_id' => $user_w_id, 'department' => $currentDepartment],
                ['name' => $client->name, 'number' => $client->number, 'status' => "Now Serving"]
            );
        
            // Retrieve the updated or created Window record
            $window = Window::where('w_id', $user_w_id)
                            ->where('department', $currentDepartment)
                            ->first();
        
            // Delete the client data after storing it in the Window model
            $client->delete();
        
            return response()->json([
                'name' => $window->name,
                'number' => $window->number,
                'w_id' => $window->w_id,
                'department' => $window->department,
                'status' => $window->status
            ]);
        } else {
            return response()->json([
                'message' => 'No clients found.'
            ], 404);
        }


    }



    
    public function waitingQueue()
    {

        $currentDepartment = Auth::user()->department;
        $user_w_id = Auth::user()->w_id;
        $window = Window::where('w_id', $user_w_id)
        ->where('department', $currentDepartment)
        ->first();

        if ($window) {
            // Update or create the Window record with matching w_id and department
            Window::updateOrCreate(
                ['w_id' => $user_w_id, 'department' => $currentDepartment],
                ['name' => "---", 'number' => "---", 'status' => "Waiting..."]
            );
        
            // Retrieve the updated or created Window record
            $window = Window::where('w_id', $user_w_id)
                            ->where('department', $currentDepartment)
                            ->first();
    
            return response()->json([
                'name' => $window->name,
                'number' => $window->number,
                'w_id' => $window->w_id,
                'department' => $window->department,
                'status' => $window->status
            ]);
        } else {
            return response()->json([
                'message' => 'No clients found.'
            ], 404);
        }


    }
}