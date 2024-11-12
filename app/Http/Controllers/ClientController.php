<?php

namespace App\Http\Controllers;
use App\Models\Client;
use App\Models\Window;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Department;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Hash;



class ClientController extends Controller
{
    public function index()
    {
        return view('queue.dashboard');
    }

    public function window()
    {
        return view('queue.allWindow');
    }

    public function homepage()
    {
        return view('homepage');
    }

    public function user()
    {
        $users = User::all();
        $departments = Department::all();  // Get all departments from the database
      
        return view('user.user', compact(['users', 'departments']));
    }



 
     // Method to get all clients (for AJAX)
     public function getAllClients()
     {
        $currentDepartment = Auth::user()->department;

        $clients = Client::where('department', $currentDepartment)->get();

        return response()->json($clients);
     }


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

    public function store()
    {
        $validatedattributes = request()->validate([
            'name' => ['required'],
            'w_id' => ['required'],
            'department' => ['required'],
            'email' => ['required', 'email', 'max:254'],
            'password' => ['required', Password::min(8)->letters()->numbers()] //password_confirmation

        ]);

        $user = User::create($validatedattributes);


        return redirect('/user');
    }

    // Update the specified user in storage
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6',
        ]);

   
        $user->name = $request->name;
        $user->department = $request->department;
        $user->email = $request->email;

        // If a new password is provided, update it
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        return redirect()->back()->with('success', 'User updated successfully.');
    }

    // Remove the specified user from storage
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->back()->with('success', 'User deleted successfully.');
    }










    
}