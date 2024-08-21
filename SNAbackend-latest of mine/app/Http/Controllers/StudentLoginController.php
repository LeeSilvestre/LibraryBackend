<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StudentProfiling;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Validator;

class StudentLoginController extends Controller
{
    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(Request $request)
    {
       // Validate the request data
       $validator = Validator::make($request->all(), [
        'email' => 'required|email',
        'password' => 'required',
    ]);

    // If validation fails, return error response
    if ($validator->fails()) {
        return response()->json([
            'message' => 'Validation Error',
            'errors' => $validator->errors(),
        ], 422);
    }

    // Attempt to authenticate the user
    if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
        // Authentication successful, generate token
        $token = auth()->user()->createToken('auth_token')->plainTextToken;

        // Return success response with token
        return response()->json([
            'message' => 'Authenticated',
            'access_token' => $token,
            'token_type' => 'Bearer',
        ], 200);
    }

    // Authentication failed, return error response
    return response()->json([
        'message' => 'Unauthenticated',
    ], 401);
    }
}

