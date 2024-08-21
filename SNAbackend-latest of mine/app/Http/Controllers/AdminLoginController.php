<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RegistrarUserActivityLog;
use Illuminate\Support\Facades\Auth;
use Jenssegers\Agent\Agent;

class AdminLoginController extends Controller
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
        try {
            // Validate login request
            $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);

            // Attempt to authenticate user
            if (Auth::attempt($request->only('email', 'password'))) {
                // Authentication successful
                $user = Auth::user();

                $token = $user->createToken('auth_token')->plainTextToken;

                return response()->json([
                    'user' => $user,
                    'message' => 'Authenticated',
                    'access_token' => $token,
                    'token_type' => 'Bearer
                    '], 200);
            } else {
                // Authentication failed
                return response()->json(['message' => 'Invalid credentials'], 401);
            }
        } catch (\Exception $e) {
            // Handle exceptions
            \Log::error('Error during login.', ['message' => $e->getMessage()]);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function login(Request $request)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        // Create an instance of the Agent class
        $agent = new Agent();

        // Attempt authentication
        if (auth()->attempt($request->only(['email', 'password']))) {
            // Get authenticated user
            $user = auth()->user();
            $action = $user->role == 'admin' ? 'Registrar Panel Login' : ($user->role == 'encoder' ? 'Encoder Panel Login' : ($user->role == 'assessor' ? 'Treasurer Panel Login' : 'Admin Panel Login' ));
            $system = $user->role == 'admin' ? 'Registrar Panel' : ($user->role == 'encoder' ? 'Encoder Panel' : ($user->role == 'assessor' ? 'Treasurer Panel' : 'Admin Panel' ));

            // Log the login attempt
            $this->logActivity(
                $user->id,
                $action,
                'SUCCESS',
                'User logged in successfully',
                $agent->browser() . ' on ' . $agent->platform(),
                $request->system_name
            );

            $data = [
                'status' => 200,
                'user' => $user
            ];

            // Return user data as JSON response
            return response()->json($data, 200);
        }

        // Log the failed login attempt
        $this->logActivity(null, 'LOGIN', 'FAILED', 'User login failed', $agent->browser() . ' on ' . $agent->platform(), $request->system_name);

        // If authentication fails, return an error response
        return response()->json(['message' => 'Unauthorized'], 401);
    }

    private function logActivity($userId, $actionType, $status, $details, $deviceInfo, $systemName)
    {
        RegistrarUserActivityLog::create([
            'user_id' => $userId,
            'action_type' => $actionType,
            'action_time' => now(),
            'ip_address' => request()->ip(),
            'details' => $details,
            'status' => $status,
            'module_name' => 'Authentication',
            'system_name' => $systemName,
            'additional_info' => [
                'device_info' => $deviceInfo
            ]
        ]);
    }
}
