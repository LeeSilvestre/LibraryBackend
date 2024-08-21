<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    // public function createUser(Request $request)
    // {
    //     $request->validate([
    //         'name' => 'required',
    //         'email' => 'required|email|unique:users,email',
    //         'password' => 'required'
    //     ]);


    //     $admin = dmin::create([
    //         'name' => $request->input('name'),
    //         'email' => $request->input('email'),
    //         'password' => bcrypt($request->input('password'))
    //     ]);

    //     // Return a successful response with a token
    //     return response()->json([
    //         'status' => true,
    //         'message' => 'User Created Successfully',
    //         'token' => $admin->createToken("API TOKEN")->plainTextToken
    //     ], 201); // Use 201 Created status code
    // }

    // public function loginUser(Request $request)
    // {
    //     // Validate the request data
    //     $request->validate([
    //         'email' => 'required|email',
    //         'password' => 'required'
    //     ]);

    //     // Attempt to authenticate the user
    //     if (!auth()->attempt($request->only(['email', 'password']))) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Invalid credentials.',
    //         ], 401);
    //     }

    //     // Get the authenticated user
    //     $admin = auth()->user();

    //     // Create a new token for the user
    //     $token = $admin->createToken("API TOKEN")->plainTextToken;

    //     // Return a successful response with the token
    //     return response()->json([
    //         'status' => true,
    //         'message' => 'User Logged In Successfully',
    //         'token' => $token
    //     ], 200);
    // }
}
