<?php

namespace App\Http\Controllers\Registrar;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\StudentProfiling;
// use App\Models\Image;
use App\Models\Registrar\Faculty;
use App\Models\Image;

class StudentRecords extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function getJHS(){
            $student = StudentProfiling::where('grade_level', '<', 11)->with([
                'adviser' => function($query) {
                    $query->select('id', \DB::raw("CONCAT(fname, ' ', COALESCE(mname, ''), ' ', lname) AS full_name"), 'department');
                }

            ])->get();
                $data = [
                    'status'=>200,
                    'student'=>$student,
                ];
            return response()->json($data, 200);

    }
    public function getSHS(){
            $student = StudentProfiling::where('grade_level', '>', 10)->with([
                'adviser' => function($query) {
                    $query->select('id', \DB::raw("CONCAT(fname, ' ', COALESCE(mname, ''), ' ', lname) AS full_name"), 'department');
                }

            ])->get();

                $data = [
                    'status'=>200,
                    'student'=>$student
                ];
                return response()->json($data, 200);

    }


    public function getCounts(){
        $students = StudentProfiling::selectRaw('
            SUM(CASE WHEN grade_level <= 10 THEN 1 ELSE 0 END) AS jhs_count,
            SUM(CASE WHEN grade_level > 10 THEN 1 ELSE 0 END) AS shs_count
        ')->first();
        $data = [
            'status'=>200,
            'student'=>$students
        ];
        return response()->json($data, 200);
    }

    public function getGradeCounts(){
            $counts = StudentProfiling::selectRaw('
        CASE
            WHEN grade_level = 7 THEN "Grade 7"
            WHEN grade_level = 8 THEN "Grade 8"
            WHEN grade_level = 9 THEN "Grade 9"
            WHEN grade_level = 10 THEN "Grade 10"
            WHEN grade_level = 11 THEN "Grade 11"
            WHEN grade_level = 12 THEN "Grade 12"
        END AS grade_level,
        COUNT(*) AS total_count
    ')->whereIn('grade_level', range(7, 12))->groupBy('grade_level')->get();
    $data = [
        'status'=>200,
        'student'=>$counts
    ];
    return response()->json($data, 200);

    }

    /**
     * Show the form for creating a new resource.
     */


    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
