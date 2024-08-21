<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Consultation;
use App\Models\StudentProfiling;
use App\Models\Cases;

class ConsultationController extends Controller
{
    public function index()
    {
        try {
            // Fetch only consultations where con_status is 'UNARCHIVED'
            $consultations = Consultation::where('con_status', 'UNARCHIVED')->get();
            
            return response()->json(['consultations' => $consultations]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to retrieve consultations', 'message' => $e->getMessage()], 500);
        }
    }

    public function archived()
    {
        try {
            // Fetch consultations where con_status is 'ARCHIVED'
            $consultations = Consultation::where('con_status', 'ARCHIVED')->get();
            
            return response()->json(['consultations' => $consultations]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to retrieve archived consultations', 'message' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $consultation = Consultation::create($request->all());
            return response()->json(['consultation' => $consultation], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create consultation'], 500);
        }
    }

    public function show(Consultation $consultation)
    {
        try {
            return response()->json(['consultation' => $consultation]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Consultation not found'], 404);
        }
    }

    public function update(Request $request, Consultation $consultation)
    {
        try {
            $consultation->update($request->all());
            return response()->json(['consultation' => $consultation]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update consultation'], 500);
        }
    }

    public function destroy(Consultation $consultation)
    {
        try {
            $consultation->delete();
            return response()->json(['message' => 'Consultation deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete consultation'], 500);
        }
    }

    public function archive($id)
    {
        try {
            $consultation = Consultation::findOrFail($id);

            $consultation->update(['con_status' => 'ARCHIVED']);
            $consultation-> save();
            return response()->json(['consultation' => $consultation], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to archive consultation', 'message' => $e->getMessage()], 500);
        }
    }

    public function ConsultationsJHS()
    {
        // Define the grades we're interested in
        $grades = ['7', '8', '9', '10'];
        $data = [];

        foreach ($grades as $grade) {
            // Fetch total cases for the grade
            $consultation = Consultation::whereHas('studentProfile', function ($query) use ($grade) {
                $query->where('grade_level', $grade);
            })->count();

            // Fetch not cleared cases for the grade
           

            $total = $consultation;

            // Store the results in the array
            $data[$grade] = [
                'total' => $total,
               
            ];
        }

        return response()->json(['data' => $data], 200);
    }
    
    public function ConsultationSHS()
    {
            $grades = ['11', '12'];
            $data = [];

            foreach ($grades as $grade) {
            // Fetch all consultations with related student profiles for the given grades
            $consultation = Consultation::whereHas('studentProfile', function ($query) use ($grade) {
                $query->where('grade_level', $grade);
            })->count();

          $total = $consultation;

                // Store the results in the array
              $data[$grade] = [
                'total' => $total,
               
            ];
        }
        

        return response()->json(['data' => $data], 200);
    }
}
