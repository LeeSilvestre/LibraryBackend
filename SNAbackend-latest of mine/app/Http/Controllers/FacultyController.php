<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Faculty;

class FacultyController extends Controller
{
    public function allFaculty()
    {
        return response()->json(Faculty::all(), 200);
    }

    public function showFaculty($id)
    {
        $faculty = Faculty::find($id);
        if (!$faculty) {
            return response()->json(['error' => 'Faculty not found'], 404);
        }
        return response()->json($faculty, 200);
    }

    public function createFaculty(Request $request)
    {
        $faculty = Faculty::create($request->all());
        return response()->json($faculty, 201);
    }

    public function updateFaculty(Request $request, $id)
    {
        $faculty = Faculty::find($id);
        if (!$faculty) {
            return response()->json(['error' => 'Faculty not found'], 404);
        }
        $faculty->update($request->all());
        return response()->json(['message' => 'Faculty updated successfully'], 200);
    }

    public function deleteFaculty($id)
    {
        $faculty = Faculty::find($id);
        if (!$faculty) {
            return response()->json(['error' => 'Faculty not found'], 404);
        }
        $faculty->delete();
        return response()->json(['message' => 'Faculty deleted successfully'], 200);
    }
}
