<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Logging;
use Carbon\Carbon;

class LoggingController extends Controller
{
    public function allLog()
    {
        $logs = Logging::all()->map(function ($log) {
            $log->login_time = Carbon::parse($log->login_time)->format('H:i:s');
            $log->logout_time = $log->logout_time ? Carbon::parse($log->logout_time)->format('H:i:s') : null;
            return $log;
        });

        return response()->json($logs, 200);
    }

    public function showALog($id)
    {
        $log = Logging::find($id);
        if (!$log) {
            return response()->json(['error' => 'Log not found'], 404);
        }

        $log->login_time = Carbon::parse($log->login_time)->format('H:i:s');
        $log->logout_time = $log->logout_time ? Carbon::parse($log->logout_time)->format('H:i:s') : null;

        return response()->json($log, 200);
    }

    public function createALog(Request $request)
    {
        $studentId = $request->input('student_id');

        $existingLog = Logging::where('student_id', $studentId)
            ->where('status', 0) 
            ->orderBy('log_id', 'desc')
            ->first();

        if ($existingLog) {
            $existingLog->status = 1;
            $existingLog->logout_time = now(); 
            $existingLog->save();

            return response()->json(['message' => 'Existing session closed successfully']);
        } else {
            Logging::create([
                'student_id' => $studentId,
                'login_time' => now(),
                'status' => 0,
                'login_date' => now()->toDateString(),
            ]);
    
            return response()->json(['message' => 'New session created successfully']);
        }
    }
}