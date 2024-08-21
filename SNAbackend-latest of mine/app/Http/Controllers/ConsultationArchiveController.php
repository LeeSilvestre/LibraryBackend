<?php
namespace App\Http\Controllers;

use App\Models\ConsultationArchive;
use Illuminate\Http\Request;

class ConsultationArchiveController extends Controller
{
    public function index()
    {
        $archives = ConsultationArchive::all();
        return response()->json($archives);
    }

    public function show($id)
    {
        $archive = ConsultationArchive::find($id);

        if (!$archive) {
            return response()->json(['message' => 'Archive not found'], 404);
        }

        return response()->json($archive);
    }

    public function store(Request $request)
    {
        $request->validate([
            'con_id' => 'required|exists:consultations,con_id',
            'student_id' => 'required|string|max:11',
            'con_title' => 'required|string',
            'con_notes' => 'required|string',
            'con_date' => 'nullable|date',
        ]);

        $archive = ConsultationArchive::create($request->all());

        return response()->json($archive, 201);
    }

    public function update(Request $request, $id)
    {
        $archive = ConsultationArchive::find($id);

        if (!$archive) {
            return response()->json(['message' => 'Archive not found'], 404);
        }

        $request->validate([
            'con_id' => 'required|exists:consultations,con_id',
            'student_id' => 'required|string|max:11',
            'con_title' => 'required|string',
            'con_notes' => 'required|string',
            'con_date' => 'nullable|date',
        ]);

        $archive->update($request->all());

        return response()->json($archive);
    }

    public function destroy($id)
    {
        $archive = ConsultationArchive::find($id);

        if (!$archive) {
            return response()->json(['message' => 'Archive not found'], 404);
        }

        $archive->delete();

        return response()->json(['message' => 'Archive deleted successfully']);
    }
}

