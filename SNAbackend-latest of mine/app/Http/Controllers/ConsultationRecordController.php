<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ConsultationRecord;
use App\Models\Inventory;
use Illuminate\Support\Facades\Log;
use App\Models\StudentProfiling;

class ConsultationRecordController extends Controller
{
    // Retrieve all consultation records with their associated inventory
    public function allRecords()
    {
        $consultationRecords = ConsultationRecord::with('inventory')->get();
        return response()->json($consultationRecords, 200);
    }

    // Create a new consultation record
    public function createConsultationRecord(Request $request)
    {
        Log::info('Received request for creating consultation record:', $request->all());

        // Validation
        $validatedData = $request->validate([
            'student_id' => 'nullable|integer|exists:student_profilings,student_id',
            'complaint' => 'nullable|string',
            'blood_pressure' => 'nullable|string',
            'pulse_rate' => 'nullable|string',
            'oxygen_sat' => 'nullable|string',
            'temp' => 'nullable|string',
            'treatment' => 'nullable|string',
            'medicine_id' => 'nullable|exists:inventories,id',
            'time_in' => 'nullable|date_format:Y-m-d H:i:s',
            'time_out' => 'nullable|date_format:Y-m-d H:i:s',
            'is_timeout' => 'nullable|boolean',
        ]);

        Log::info('Validated data:', $validatedData);

        // Check if the medicine_id exists and update inventory
        if (isset($validatedData['medicine_id'])) {
            $inventory = Inventory::find($validatedData['medicine_id']);

            if ($inventory) {
                // Check if there's enough quantity
                if ($inventory->quantity < 1) {
                    return response()->json(['error' => 'Not enough inventory'], 400);
                }

                // Decrease the quantity
                $inventory->quantity -= 1;
                $inventory->save();
            } else {
                return response()->json(['error' => 'Medicine not found'], 404);
            }
        }

        $consultationRecord = ConsultationRecord::create($validatedData);

        return response()->json($consultationRecord, 201);
    }

    // Retrieve consultation records for a specific student
    public function getConsultationRecordsByStudent($studentId)
    {
        try {
            // Fetch consultation records for the specified student
            $consultationRecords = ConsultationRecord::where('student_id', $studentId)
                ->with('inventory')
                ->get();

            // Check if records are found
            if ($consultationRecords->isEmpty()) {
                return response()->json(['error' => 'No records found for this student'], 404);
            }

            // Return the records as JSON
            return response()->json($consultationRecords, 200);
        } catch (\Exception $e) {
            // Log the error
            Log::error('Failed to fetch consultation records for student', [
                'studentId' => $studentId,
                'error' => $e->getMessage()
            ]);

            // Return a generic error response
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    // Update an existing consultation record
    public function updateConsultationRecord(Request $request, $studentId)
    {
        $consultationRecord = ConsultationRecord::where('student_id', $studentId)->first();

        if (!$consultationRecord) {
            return response()->json(['error' => 'Record not found'], 404);
        }

        $consultationRecord->update($request->all());

        return response()->json(['message' => 'Record updated successfully'], 200);
    }

    // Update the timeout status of a consultation record
    public function updateTimeout(Request $request, $studentId)
    {
        $request->validate([
            'time_out' => 'required|date_format:Y-m-d H:i:s',
        ]);

        try {
            $record = ConsultationRecord::where('student_id', $studentId)->firstOrFail();
            $record->time_out = $request->input('time_out');
            $record->is_timeout = 1;
            $record->save();

            return response()->json(['message' => 'Timeout recorded successfully.'], 200);
        } catch (\Exception $e) {
            Log::error('Failed to record timeout', ['studentId' => $studentId, 'error' => $e->getMessage()]);
            return response()->json(['message' => 'Failed to record timeout.'], 500);
        }
    }

    // Delete a consultation record
    public function deleteConsultationRecord($studentId)
    {
        $consultation = ConsultationRecord::where('student_id', $studentId)->first();

        if (!$consultation) {
            return response()->json(['error' => 'Record not found'], 404);
        }

        $consultation->delete();

        return response()->json(['message' => 'Record deleted successfully'], 200);
    }

    // Get dashboard data
    public function getDashboardData()
    {
        // Get total students
        $totalStudents = StudentProfiling::count();

        // Get total daily patients
        $totalDailyPatients = ConsultationRecord::whereDate('time_in', now()->toDateString())->count();

        // Define grades for Junior High School (JHS)
        $jhsGrades = ['7', '8', '9', '10'];
        $jhsData = [];

        foreach ($jhsGrades as $grade) {
            // Fetch total consultations for the grade
            $jhsData[$grade] = ConsultationRecord::whereHas('studentProfile', function ($query) use ($grade) {
                $query->where('grade_level', $grade);
            })->count();
        }

        // Define grades for Senior High School (SHS)
        $shsGrades = ['11', '12'];
        $shsData = [];

        foreach ($shsGrades as $grade) {
            // Fetch total consultations for the grade
            $shsData[$grade] = ConsultationRecord::whereHas('studentProfile', function ($query) use ($grade) {
                $query->where('grade_level', $grade);
            })->count();
        }

        return response()->json([
            'totalStudents' => $totalStudents,
            'totalDailyPatients' => $totalDailyPatients,
            'juniorHighData' => $jhsData,
            'seniorHighData' => $shsData,
        ]);
    }

    // Get monthly consultations data
    public function getMonthlyConsultations()
    {
        // Initialize arrays to hold the counts
        $juniorHighCounts = array_fill(0, 12, 0); // For Junior High
        $seniorHighCounts = array_fill(0, 12, 0); // For Senior High

        // Define grades for Junior High School (JHS)
        $jhsGrades = ['7', '8', '9', '10'];
        
        // Define grades for Senior High School (SHS)
        $shsGrades = ['11', '12'];

        // Aggregate counts per month for Junior High School
        foreach ($jhsGrades as $grade) {
            for ($month = 1; $month <= 12; $month++) {
                $juniorHighCounts[$month - 1] += ConsultationRecord::whereMonth('time_in', $month)
                    ->whereHas('studentProfile', function ($query) use ($grade) {
                        $query->where('grade_level', $grade);
                    })->count();
            }
        }

        // Aggregate counts per month for Senior High School
        foreach ($shsGrades as $grade) {
            for ($month = 1; $month <= 12; $month++) {
                $seniorHighCounts[$month - 1] += ConsultationRecord::whereMonth('time_in', $month)
                    ->whereHas('studentProfile', function ($query) use ($grade) {
                        $query->where('grade_level', $grade);
                    })->count();
            }
        }

        // Return the data as JSON
        return response()->json([
            'juniorHighData' => $juniorHighCounts,
            'seniorHighData' => $seniorHighCounts,
        ]);
    }
}