<?php

namespace App\Http\Controllers;

use App\Models\DentalCert;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;

class DentalCertController extends Controller
{
    /**
     * Get all dental certificates.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        // Fetch all dental certificates
        $dentalCerts = DentalCert::all();

        // Optional: Log the results for debugging purposes
        \Log::info('Dental certificates retrieved:', $dentalCerts->toArray());

        // Return the certificates as a JSON response
        return response()->json($dentalCerts);
    }

    /**
     * Get dental certificates by student ID.
     *
     * @param  string  $studentId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDentalCerts(string $studentId): JsonResponse
    {
        try {
            // Retrieve dental certificates for the given student ID
            $dentalCerts = DentalCert::where('student_id', $studentId)->get();
            
            if ($dentalCerts->isEmpty()) {
                return response()->json([
                    'message' => 'No dental certificates found for this student.'
                ], 404);
            }
            
            return response()->json($dentalCerts);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An error occurred while retrieving the dental certificates.',
                'details' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get a specific dental certificate.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        try {
            // Find the dental certificate by its ID
            $dentalCert = DentalCert::findOrFail($id);
            return response()->json($dentalCert);
        } catch (ModelNotFoundException $e) {
            // Return a 404 error if not found
            return response()->json([
                'error' => 'Dental certificate not found'
            ], 404);
        }
    }

    /**
     * Create a new dental certificate.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        // Validate the incoming data
        $validatedData = $request->validate([
            'student_id' => 'nullable|string|max:11',
            'date' => 'required|date',
            'dental_history' => 'required|string',
            'current_dental_issue' => 'nullable|string',
            'examination_findings' => 'required|string',
        ]);

        // Create a new DentalCert instance and fill it with data
        $dentalCert = DentalCert::create($validatedData);

        // Return a response with the newly created certificate
        return response()->json([
            'message' => 'Dental certificate created successfully!',
            'dentalCert' => $dentalCert
        ], 201);
    }

    /**
     * Update a specific dental certificate.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $studentId
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, string $studentId): JsonResponse
    {
        try {
            // Validate the incoming data
            $validatedData = $request->validate([
                'student_id' => 'nullable|string|max:11',
                'date' => 'sometimes|date',
                'dental_history' => 'sometimes|string',
                'current_dental_issue' => 'nullable|string',
                'examination_findings' => 'sometimes|string',
            ]);

            // Find the dental certificate by student_id
            $dentalCert = DentalCert::where('student_id', $studentId)->firstOrFail();

            // Update the certificate with validated data
            $dentalCert->update($validatedData);

            // Return the updated certificate
            return response()->json($dentalCert);
        } catch (ValidationException $e) {
            // Return a 422 error if validation fails
            return response()->json([
                'error' => 'Validation failed',
                'messages' => $e->errors()
            ], 422);
        } catch (ModelNotFoundException $e) {
            // Return a 404 error if not found
            return response()->json([
                'error' => 'Dental certificate not found'
            ], 404);
        }
    }

    /**
     * Delete a specific dental certificate.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            // Find the dental certificate by its ID
            $dentalCert = DentalCert::findOrFail($id);

            // Delete the certificate
            $dentalCert->delete();

            // Return a 204 No Content response
            return response()->json(null, 204);
        } catch (ModelNotFoundException $e) {
            // Return a 404 error if not found
            return response()->json([
                'error' => 'Dental certificate not found'
            ], 404);
        }
    }
}