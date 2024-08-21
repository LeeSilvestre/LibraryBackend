<?php

namespace App\Http\Controllers\Registrar;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\registrar\Faculty;
use App\Models\Image;
use Validator;

class FacultyProfile extends Controller
{
    public function index()
    {
        // Retrieve faculty data
        $faculty = Faculty::all();

        foreach ($faculty as $facultyMember) {
            $image = Image::where('student_id', $facultyMember->id)->first();
            $facultyMember->image = $image;
        }
        $data = [
            'status' => 200,
            'faculty' => $faculty
        ];
        return response()->json($data, 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'fname' => 'required',
            'mname' => 'required',
            'lname' => 'required',
            'contact_no' => 'required',
            'position' => 'required',
            'department' => 'required',
            'region' => 'required',
            'province' => 'required',
            'city' => 'required',
            'barangay' => 'required',
            'street' => 'required',
            'zip_code' => 'required',
             
        ]);

        if($validator->fails()) {
            $data = [
                "status"=>422,
                "message"=>$validator->messages()
            ];
            return response()->json($data,422);

        } else {
            $faculty = new Faculty;
            $faculty->fill($request->all());
            $faculty->email = $request->lname.'sna@edu.ph';
            $faculty->save();
            $data = [
                'status'=>200,
                'message'=>'Faculty has been successfully added.'
            ];
            return response()->json($data, 200);
        }
    }


    public function getFacultyNames(){
        $faculty =  Faculty::selectRaw("id, CONCAT(fname, ' ', COALESCE(mname, ''), ' ', lname) AS full_name")->get();

        $data =[
            'status' => 200,
            'faculty' => $faculty
        ];

        return response()->json($data, 200);
        
    }
}
