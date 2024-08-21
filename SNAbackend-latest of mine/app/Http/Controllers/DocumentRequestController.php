<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StudentProfiling;
use App\Models\DocumentRequest;


class DocumentRequestController extends Controller
{
    //
    public function index()
    {
        $documents = DocumentRequest::select('request_document.*',
            \DB::raw("CONCAT(student_profilings.first_name, ' ', COALESCE(student_profilings.middle_name, ''), ' ', student_profilings.last_name) AS full_name,student_lrn, grade_level"))
            ->join('student_profilings', 'request_document.student_id', '=', 'student_profilings.student_id')
            ->get();

        $data = [
            "status" => 200,
            "data" => $documents
        ];

        return response()->json($data, 200);
    }


    public function getDocument($id){
        $document  = DocumentRequest::where('student_id', $id)->get();
        $data = [
            "status" => 200,
            "data" => $document
        ];

         return response()->json($data, 200);
    }

    public function upload(Request $request) {

        $document  = new DocumentRequest();
        $document->fill($request->all());

        $document->save();

        $data = [
            "status" => "200",
            "message" => "Document Request Uploaded Successfully"
        ];
        return response()->json($data, 200);
    }


}
