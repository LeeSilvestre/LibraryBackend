<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Barryvdh\DomPDF\Facade\Pdf;

use Illuminate\Support\Facades\Storage;

class DentalCertificateController extends Controller
{
    public function generate(Request $request)
    {

        $request->validate([
            
            'name' => 'required|string',
            'birthdate' => 'required|date',
            
        ]);

        $data = $request->only(['name', 'birthdate']);
    
        $pdf = PDF::loadView('dental_certificate', ['data'=>$data]);
        
        // Generate a unique filename for each download
        $filename = 'dental_certificate_' . time() . '.pdf';
        
        // Store the PDF file in public storage
        $filePath = 'temp/' . $filename;

        Storage::disk('public')->put($filePath, $pdf->output());
        
        // Generate a temporary URL manually
        $temporaryUrl = url('/storage_new/' . $filePath); // Assuming you have configured the public disk properly
        
        // Return the temporary URL as JSON
        return response()->json(['download_link' => $temporaryUrl]);
        
    }
}
