<?php

namespace App\Http\Controllers;

use App\Models\Cases;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
// use App\Models\Cases;

class CasesController extends Controller
{
    public function index()
    {
        $cases = Cases::with([
            'studentProfile'
        ])->get();
        return response()->json(['cases' => $cases], 200);
    }

    public function caseStatusUpdate($id, $newStatus){
        $cases = Cases::find($id);

        if (!$cases) {
            return response()->json(["error" => "Case not found"], 404);
        }

        $cases->cases_status = $newStatus;
        $cases->save();

        $data = [
            "code" => 200,
            "data" => $cases
        ];

        return response()->json($data, 200);
    }

   public function store(Request $request)
    {
        // Validation rules
        $rules = [
            'case_title' => 'required|string|max:255',
            'student_id' => 'nullable|string|max:255',
            // 'student_name' => 'nullable|string|max:255',
            'case_description' => 'required|string',
            'case_sanction' => 'required|string',
            // No validation rule for 'case_date' since it will be set automatically
        ];

        // Validate the request data
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        // Prepare data for insertion
        $now = Carbon::now();
        $requestData = $request->all();
        $requestData['case_date'] = $now->toDateString(); // Automatically set current date
        $requestData['created_at'] = $now;
        $requestData['updated_at'] = $now;

        // Create new case record
        $case = Cases::create($requestData);

        // Return the created case record as JSON response
        return response()->json(['case' => $case], 201);
    }

    public function show($id)
    {
        $case = Cases::findOrFail($id);
        return response()->json(['case' => $case], 200);
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'case_title' => 'required|string|max:255',

        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $now = Carbon::now();
        $requestData = $request->all();
        $requestData['updated_at'] = $now;

        $case = Cases::findOrFail($id);
        $case->update($requestData);
        return response()->json(['case' => $case], 200);
    }

    public function destroy($id)
    {
        $case = Cases::findOrFail($id);
        $case->softDelete();
        return response()->json(null, 204);
    }

    public function archive(Request $request)
    {
        // Validate request input
        $validator = Validator::make($request->all(), [
            'cases_id' => 'required|integer|exists:cases,cases_id'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $cases_id = $request->input('cases_id');
        $case = Cases::find($cases_id);

        if ($case->case_status == '0') {
            $case->case_status = '1';
        }


        if (!$case) {
            return response()->json(['error' => 'Case not found'], 404);
        }


        // Soft delete the case
        $case->delete();
        // $case->archive_status = 'archived'; // Set archive status
        $case->save();
        $case->delete();

        return response()->json(['message' => 'Case archived successfully'], 200);
    }


public function getArchivedCases()
{
    try {
        // Fetch cases that are soft-deleted (archived)
        $archivedViolations = Cases::onlyTrashed()->get();

        if ($archivedViolations->isEmpty()) {
            return response()->json([
                'message' => 'No archived cases found',
                'archivedViolations' => []
            ], 404);
        }

        return response()->json([
            'message' => 'Archived cases retrieved successfully',
            'archivedViolations' => $archivedViolations
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Error fetching archived cases',
            'error' => $e->getMessage()
        ], 500);
    }
}

 
}

