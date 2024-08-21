<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PhysicalExamination;
use Illuminate\Validation\ValidationException;

class PhysicalExaminationController extends Controller
{
    /**
     * Store a newly created physical examination record in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // Validate the incoming request data
        $validated = $request->validate([
            'student_id' => 'nullable|integer|exists:student_profilings,student_id',
            'blood_pressure' => 'required|string',
            'pulse_rate' => 'required|string',
            'vision_left' => 'required|string',
            'vision_right' => 'required|string',
            'height' => 'required|string',
            'weight' => 'required|string',
            'cl' => 'required|string',
            'abdomen' => 'required|string',
            'extremities' => 'required|string',
            'skin' => 'required|string',
            'cvs' => 'required|string',
            'personal_family_history' => 'required|string',
            'remarks' => 'required|string',
            'date' => 'required|date',
        ], [
            'student_id.exists' => 'The selected student does not exist.',
            'blood_pressure.required' => 'Blood pressure is required.',
            // Add other custom messages as needed
        ]);

        try {
            // Create a new Physical Examination record
            $examination = PhysicalExamination::create($validated);

            // Return a successful response with the created data
            return response()->json([
                'message' => 'Data submitted successfully!',
                'data' => $examination
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to submit data',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Retrieve the physical examination record for a specific student.
     *
     * @param string $studentId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPhysicalExamination($studentId)
    {
        $physicalExamination = PhysicalExamination::where('student_id', $studentId)->first();

        if (!$physicalExamination) {
            return response()->json([
                'message' => 'Physical examination not found'
            ], 404);
        }

        return response()->json($physicalExamination, 200);
    }

    /**
     * Retrieve all physical examination records.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllPhysicalExaminations()
    {
        $physicalExaminations = PhysicalExamination::all();

        return response()->json($physicalExaminations, 200);
    }

    /**
     * Update the specified physical examination record in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param string $studentId
     * @return \Illuminate\Http\JsonResponse
     */
    public function updatePhysicalExamination(Request $request, $studentId)
    {
        // Find the physical examination record by student_id
        $physicalExamination = PhysicalExamination::where('student_id', $studentId)->first();

        if (!$physicalExamination) {
            return response()->json([
                'message' => 'Physical examination not found'
            ], 404);
        }

        // Validate the incoming request data
        $validated = $request->validate([
            'student_id' => 'nullable|integer|exists:student_profilings,student_id',
            'blood_pressure' => 'required|string',
            'pulse_rate' => 'required|string',
            'vision_left' => 'required|string',
            'vision_right' => 'required|string',
            'height' => 'required|string',
            'weight' => 'required|string',
            'cl' => 'required|string',
            'abdomen' => 'required|string',
            'extremities' => 'required|string',
            'skin' => 'required|string',
            'cvs' => 'required|string',
            'personal_family_history' => 'required|string',
            'remarks' => 'required|string',
            'date' => 'required|date',
        ]);

        try {
            // Update the record with validated data
            $physicalExamination->update($validated);

            return response()->json([
                'message' => 'Data updated successfully!',
                'data' => $physicalExamination
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to update data',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified physical examination record from storage.
     *
     * @param string $studentId
     * @return \Illuminate\Http\JsonResponse
     */
    public function deletePhysicalExamination($studentId)
    {
        // Find the physical examination record by student_id
        $physicalExamination = PhysicalExamination::where('student_id', $studentId)->first();

        if (!$physicalExamination) {
            return response()->json([
                'message' => 'Physical examination not found'
            ], 404);
        }

        try {
            // Delete the record
            $physicalExamination->delete();

            return response()->json([
                'message' => 'Physical examination deleted successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to delete data',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}