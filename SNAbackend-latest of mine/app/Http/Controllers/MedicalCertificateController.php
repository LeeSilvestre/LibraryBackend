<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Barryvdh\DomPDF\Facade\Pdf;

use Illuminate\Support\Facades\Storage;

class MedicalCertificateController extends Controller
{
    public function generate(Request $request)
    {

        $request->validate([
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

        $data = $request->only([ 'date_created','name', 'school_id','age','blood_pressure','pulse_rate','birthdate','vision_left','vision_right','weight','height']);
    
        $pdf = PDF::loadView('medical_certificate', ['data'=>$data]);
        
        // Generate a unique filename for each download
        $filename = 'medical_certificate_' . time() . '.pdf';
        
        // Store the PDF file in public storage
        $filePath = 'temp/' . $filename;

        Storage::disk('public')->put($filePath, $pdf->output());
        
        // Generate a temporary URL manually
        $temporaryUrl = url('/storage/' . $filePath); // Assuming you have configured the public disk properly
        
        // Return the temporary URL as JSON
        return response()->json(['download_link' => $temporaryUrl]);
        
    }
}
