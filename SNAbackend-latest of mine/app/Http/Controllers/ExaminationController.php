<?php

namespace App\Http\Controllers;

use App\Models\Examination;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class ExaminationController extends Controller
{
    public function index()
    {
        // Fetch only the examinations with exam_status 'UNARCHIVED'
        $examinations = Examination::where('exam_status', 'UNARCHIVED')->get();
        return response()->json(['examinations' => $examinations], 200);    
    }

    public function examArchived()
    {
        // Fetch only the examinations with exam_status 'ARCHIVED'
        $examinations = Examination::where('exam_status', 'ARCHIVED')->get();
        return response()->json(['examinations' => $examinations], 200);    
    }

     public function store(Request $request)
    {
        $rules = [
            'exam_title' => 'required|string|max:255',
            // Add other validation rules if needed
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        try {
            $examination = Examination::create($request->all());
            return response()->json(['examination' => $examination], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create examination', 'message' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        $examination = Examination::findOrFail($id);
        return response()->json(['examination' => $examination], 200);
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'exam_title' => 'required|string|max:255',
            
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $now = Carbon::now();
        $requestData = $request->all();
        $requestData['updated_at'] = $now;

        $examination = Examination::findOrFail($id);
        $examination->update($requestData);
        return response()->json(['examination' => $examination], 200);
    }

    public function destroy($id)
    {
        $examination = Examination::findOrFail($id);
        $examination->delete();
        return response()->json(null, 204);
    }

    public function archive($id)
    {
        try {
            $examination = Examination::findOrFail($id);

            $examination->update(['exam_status' => 'ARCHIVED']);
            $examination-> save();
            return response()->json(['examination' => $examination], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to archive examination', 'message' => $e->getMessage()], 500);
        }
    }
}
