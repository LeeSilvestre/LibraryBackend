<?php

namespace App\Http\Controllers;

use App\Models\MedicalCert;
use Illuminate\Http\Request;

class MedicalCertController extends Controller
{
    /**
     * Get all medical certificates.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $medicalCerts = MedicalCert::all();
        return response()->json($medicalCerts);
    }

    /**
     * Create a new medical certificate.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'date_created' => 'required|date',
            'name' => 'required|string',
            'school_id' => 'required|string',
            'birthdate' => 'required|date',
            'age' => 'required|string',
            'blood_pressure' => 'required|string',
            'pulse_rate' => 'required|string',
            'vision_left' => 'required|string',
            'vision_right' => 'required|string',
            'weight' => 'required|string',
            'height' => 'required|string',
        ]);

        $medicalCert = MedicalCert::create($validatedData);

        return response()->json($medicalCert, 201);
    }

    /**
     * Get a specific medical certificate.
     *
     * @param  \App\Models\MedicalCert  $medicalCert
     * @return \Illuminate\Http\Response
     */
    public function show(MedicalCert $medicalCert)
    {
        return response()->json($medicalCert);
    }

    /**
     * Update a specific medical certificate.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MedicalCert  $medicalCert
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MedicalCert $medicalCert)
    {
        $validatedData = $request->validate([
            'date_created' => 'nullable|date',
            'name' => 'nullable|string',
            'school_id' => 'nullable|string',
            'birthdate' => 'nullable|date',
            'age' => 'nullable|string',
            'blood_pressure' => 'nullable|string',
            'pulse_rate' => 'nullable|string',
            'vision_left' => 'nullable|string',
            'vision_right' => 'nullable|string',
            'weight' => 'nullable|string',
            'height' => 'nullable|string',
        ]);

        $medicalCert->update($validatedData);

        return response()->json($medicalCert);
    }

    /**
     * Delete a specific medical certificate.
     *
     * @param  \App\Models\MedicalCert  $medicalCert
     * @return \Illuminate\Http\Response
     */
    public function destroy(MedicalCert $medicalCert)
    {
        $medicalCert->delete();

        return response()->json(null, 204);
    }
}
