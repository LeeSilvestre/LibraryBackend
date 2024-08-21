<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // Assuming User model exists


class ClinicController extends Controller
{
    // Method to create a new user
    public function createUser(Request $request)
    {
        // Validate incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        // Create new user
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
        ]);

        // Optionally, you can log the user in after creation
        // auth()->login($user);

        // Return a response or redirect as needed
        return response()->json(['message' => 'User created successfully', 'user' => $user], 201);
    }
}
