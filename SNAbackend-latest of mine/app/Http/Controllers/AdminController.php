<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
class AdminController extends Controller
{
    //

    public function createUser( Request $request){

        $user = new User();
        $user->fill($request->all());
        $user->save();

        $data = [
            "code" => 200,
            "message" => "User Created Succesfully"
        ];

        return response()->json($data, 200);
    }

    public function store(Request $request)
    {
        try {
            // Validate request data
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:6',
                'role' => 'required|in:user,admin', // Adjust role validation as needed
            ]);

            // Create user record
            $newUser = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'role' => $request->role,
            ]);

            // Optionally, return the newly created user or any additional data
            return response()->json($newUser, 201); // Return the newly created user with HTTP status 201 (Created)
        } catch (\Exception $e) {
            // Handle exceptions
            \Log::error('Error creating user account.', ['message' => $e->getMessage()]);
            return response()->json(['error' => $e->getMessage()], 500); // Return error message with HTTP status 500 (Internal Server Error)
        }
    }



public function login(Request $request)
    {


        if(!Auth::attempt($request->only(['email', 'password']))) {
            return $this->error('', 'Credentials do not match', 401);
        }

        $user = User::where('email', $request->email)->first();

        return $this->success([
            'user' => $user,
        ]);
    }


    public function getRole()
    {
        // Fetch all users along with their roles
        $users = User::all(['id', 'role']); // Adjust attributes as per your User model

        // Prepare the response
        $response = [];
        foreach ($users as $user) {
            $response[] = [
                'id' => $user->id,
                'role' => $user->role,
            ];
        }

        // Return roles as JSON response
        return response()->json($response);
    }

}
