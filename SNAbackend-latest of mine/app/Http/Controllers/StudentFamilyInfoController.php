<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\StudentFamilyInfo;

use Validator;

class StudentFamilyInfoController extends Controller
{
    public function getFamilyInfo() {
        $familyInfo = StudentFamilyInfo::all();
        $data = [
            'status'=>200,
            'family'=>$familyInfo
        ];
        return response()->json($data, 200);

    }

    public function storeFamilyInfo (Request $request) {
        $validator = Validator::make($request->all(),[
            'father_name'=>'required',
            'father_occupation'=>'required',
            'father_mobileno'=>'required',
            'mother_name'=>'required',
            'mother_occupation'=>'required',
            'mother_mobileno'=>'required',
            'guardian_name'=>'required',
            'guardian_occupation'=>'required',
            'guardian_mobileno'=>'required',
        ]);

        if($validator->fails()) {

            $data = [
                "status"=>422,
                "message"=>$validator->messages()
            ];

            return response()->json($data,422);
        }

        else {
            $familyInfo = new StudentFamilyInfo();

            $familyInfo->student_id = $request->student_id;

            $familyInfo->father_name=$request->father_name;
            $familyInfo->father_occupation=$request->father_occupation;
            $familyInfo->father_mobileno=$request->father_mobileno;
            $familyInfo->mother_name=$request->mother_name;
            $familyInfo->mother_occupation=$request->mother_occupation;
            $familyInfo->mother_mobileno=$request->mother_mobileno;
            $familyInfo->guardian_name=$request->guardian_name;
            $familyInfo->guardian_occupation=$request->guardian_occupation;
            $familyInfo->guardian_mobileno=$request->guardian_mobileno;

            $familyInfo->save();

            $data = [
                "status"=>"200",
                "message"=>"Student Family Information Uploaded Successfully"
            ];

            return response()->json($data,200);
            
        }
    }


}
