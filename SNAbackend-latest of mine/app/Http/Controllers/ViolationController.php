<?php

namespace App\Http\Controllers;

use App\Models\Violation;
use Illuminate\Http\Request;
use App\Models\StudentProfiling;
use App\Models\Cases;

class ViolationController extends Controller
{
    public function index()
    {
        $violations = Violation::all();
        return response()->json(['cases' => $violations]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_ID' => 'required|string',
            'student_name' => 'nullable|string',
            'case_title' => 'required|string',
            'case_description' => 'required|string',
            'case_sanction' => 'required|string',
            'case_status' => 'nullable|boolean',
            'case_date' => 'nullable|date',
        ]);

        $violation = Violation::create($request->all());
        return response()->json($violation, 201);
    }

    public function archive(Request $request)
    {
        // You might want to move this logic to a separate method if the logic is complex
        $violation = Violation::find($request->cases_id);
        if ($violation) {
            // Perform any archival logic here, e.g., moving to another table or just marking as archived
            $violation->delete();
            return response()->json(['message' => 'Violation archived successfully.']);
        }
        return response()->json(['message' => 'Violation not found.'], 404);
    }


    public function restore(Request $request)
    {
        // Validate the request with cases_id
        $request->validate([
            'cases_id' => 'required|integer|exists:cases,cases_id', // Ensure this matches your column name
        ]);
    
        try {
            // Find the archived case using cases_id
            $archivedCase = Cases::where('cases_id', $request->cases_id)->first();
    
            if ($archivedCase) {
                // Restore the archived case to the main table
                $violation = new Violation();
                $violation->student_id = $archivedCase->student_id;
                $violation->case_title = $archivedCase->case_title;
                $violation->case_description = $archivedCase->case_description;
                $violation->case_status = $archivedCase->case_status;
                $violation->case_date = $archivedCase->case_date;
                $violation->save();
    
                // Optionally, delete the archived record if it's not needed anymore
                $archivedCase->delete();
    
                return response()->json(['message' => 'Violation restored successfully.']);
            }
    
            return response()->json(['message' => 'Violation not found.'], 404);
        } catch (\Exception $e) {
            Log::error('Error restoring violation: ' . $e->getMessage());
            return response()->json(['message' => 'An error occurred while restoring the record.'], 500);
        }
    }
    public function getJHS()
    {
        // Define the grades we're interested in
        $grades = ['7', '8', '9', '10'];
        $data = [];

        foreach ($grades as $grade) {
            // Fetch total cases for the grade
            

            // Fetch cleared cases for the grade
            $cleared = Cases::whereHas('studentProfile', function ($query) use ($grade) {
                $query->where('grade_level', $grade);
            })->onlyTrashed()->count();

            // Fetch not cleared cases for the grade
            $notCleared = Cases::whereHas('studentProfile', function ($query) use ($grade) {
                $query->where('grade_level', $grade);
            })->where('case_status', '1')->count(); // Assuming '0' represents not cleared status

            $total = $cleared + $notCleared;

            // Store the results in the array
            $data[$grade] = [
                'total' => $total,
                'cleared' => $cleared,
                'not_cleared' => $notCleared,
            ];
        }

        return response()->json(['data' => $data], 200);
    }

    public function getSHS()
    {
        $grades = ['11', '12'];
        $data = [];

        foreach ($grades as $grade) {
            // Fetch total cases for the grade
            

            // Fetch cleared cases for the grade
            $cleared = Cases::whereHas('studentProfile', function ($query) use ($grade) {
                $query->where('grade_level', $grade);
            })->onlyTrashed()->count();

            // Fetch not cleared cases for the grade
            $notCleared = Cases::whereHas('studentProfile', function ($query) use ($grade) {
                $query->where('grade_level', $grade);
            })->where('case_status', '1')->count(); // Assuming '0' represents not cleared status

            $total = $cleared + $notCleared;

            // Store the results in the array
            $data[$grade] = [
                'total' => $total,
                'cleared' => $cleared,
                'not_cleared' => $notCleared,
            ];
        }

        return response()->json(['data' => $data], 200);
    }

    
    public function generateReport($reportType, Request $request)
    {
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        // Validate dates
        if (! $startDate || ! $endDate) {
            return response()->json(['error' => 'Invalid date range'], 400);
        }

        try {
            // Convert dates to Carbon instances
            $start = Carbon::createFromFormat('Y-m-d', $startDate);
            $end = Carbon::createFromFormat('Y-m-d', $endDate);

            // Generate the report
            $export = new ViolationsExport($start, $end, $reportType);

            // Return the generated report as a downloadable file
            return Excel::download($export, "{$reportType}.xlsx");
        } catch (\Exception $e) {
            // Handle exceptions
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

}

