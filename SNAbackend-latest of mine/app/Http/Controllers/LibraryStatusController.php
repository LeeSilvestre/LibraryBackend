<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LibraryStatus;

class LibraryStatusController extends Controller
{
    public function allLibStat()
    {
        return response()->json(LibraryStatus::all(), 200);
    }

    public function showALibStat($student_id)
    {
        $student = LibraryStatus::find($student_id);
        if (!$student) {
            return response()->json(['error' => 'Library Status not found'], 404);
        }
        return response()->json($student, 200);
    }
}
