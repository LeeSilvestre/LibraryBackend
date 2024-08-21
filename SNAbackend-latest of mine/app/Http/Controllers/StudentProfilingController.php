<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\StudentProfiling;
use App\Models\User;
use App\Models\Image;
use App\Models\LibraryStatus;
use App\Models\Registrar\Enrollment;
use App\Models\Registrar\Faculty;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;



use Validator;

class StudentProfilingController extends Controller
{

    //############################# G E T   M E T H O D S #######################################
    public function index() {
        $student = StudentProfiling::with([
            'adviser' => function($query) {
                $query->select('id', \DB::raw("CONCAT(fname, ' ', COALESCE(mname, ''), ' ', lname) AS full_name"), 'department');
            },
        ])->get();
        $data = [
            'status'=>200,
            'student'=>$student
        ];
        return response()->json($data, 200);

    }

    public function indexId($id) {
        $student = StudentProfiling::where('student_recno', $id)->first();
        $data = [
            'status'=>200,
            'student'=>$student
        ];
        return response()->json($data, 200);

    }

     /////////////////////////////////////////////////////////////////////////////////////////////
    /*
    |                                                                                              /
    |                                                                                           /
    |
    |
    |
    |
    |
    */

    // ########################### P O S T  M E T H O D S ##################################

    // newly enrolled
    public function upload(Request $request) {
        $validator = Validator::make($request->all(),[
            'first_name'=>'required',
            'last_name'=>'required',
            'sex_at_birth'=>'required',
            'birth_date'=>'required|date',
            'contact_no'=>'required',
            'grade_level' => 'required',
        ]);

        if ($validator->fails()) {
            $data = [
                "status"=>422,
                "message"=>$validator->messages()
            ];
            return response()->json($data, 422);
        }

        $student = new StudentProfiling();
        $student->fill($request->except('student_id'));

        $student->save();


        $data = [
            "status" => "200",
            "message" => "Student Profile Uploaded Successfully"
        ];

        return response()->json($data, 200);
    }


    // NEWLY ENROLLED CREADET ACCOUTN
    public function aasd(Request $request) {

        if ($validator->fails()) {
            $data = [
                "status"=>422,
                "message"=>$validator->messages()
            ];
            return response()->json($data, 422);
        }

        $email = $request->student_lrn . '@sna.edu.ph';

        // Check if the email already exists
        if (User::where('email', $email)->exists()) {
            $data = [
                "status"=>422,
                "message"=>"The email address already exists."
            ];
            return response()->json($data, 422);
        }

        $hashedPassword = Hash::make($request->password);

        $user = User::create([
            'name' => $request->first_name,
            'email' => $email,
            'password' => $hashedPassword,
        ]);

        $student = new StudentProfiling();
        $student->user_id = $user->id;
        $enroll = new Enrollment();

        $student->fill($request->all());


        $student->student_id = $user->id;
        $student->save();


        $data = [
            "status" => "200",
            "message" => "Student Profile Uploaded Successfully"
        ];

        return response()->json($data, 200);
    }

    /////////////////////////////////////////////////////////////////////////////////////////////
    /*
    |                                                                                              /
    |                                                                                           /
    |
    |
    |
    |
    |
    */
// ########################### U P D A T E    M E T H O D S ##################################

// public function createAccount(Request $request, $id)
// {
//     // Get current year
//     $year = date('Y');

//     // Find the student profile

//     // Check if student profile exists
//     // if (!$student) {
//     //     return response()->json(['message' => 'Student not found'], 404);
//     // }

//     // Generate random student ID
//     $randomDigits = str_pad(mt_rand(0, 99999), 5, '0', STR_PAD_LEFT);
//     $studentID = $year . $randomDigits;

//     $student = StudentProfiling::where('student_recno', $id)->first();
//     // Update student profile
//     $student->student_id = $request->input('student_id', $studentID);
//     $student->grade_level = $request->grade_level;
//     $student->enrollment_status = $request->enrollment_status;
//     // $student->save();
//     $studentDept = $student->grade_level > 10 ? 'shs' : 'jhs';

//     DB::beginTransaction();

//     $hashedPassword = Hash::make($request->password);
//     // Create user account
//     $user = User::create([
//         'name' => $student->first_name . ' ' . $student->last_name,
//         'email' => $studentID . '@sna.edu.ph',
//         'role' => 'student',
//         'department' => $studentDept,
//         'password' => $hashedPassword,
//     ]);

//     $student->enrollment_status = $request->enrollment_status;
//     $student->adviser_id = $request->adviser_id;


//     // Link user account to student profile
//     $student->user_id = $user->id;

//     // Save student profile
//     $student->save();


//     // Return a success response
//     return response()->json(['message' => 'Student status updated successfully', 'student' => $student]);
// }



    public function edit(Request $request,$id){
        $validator = Validator::make($request->all(),[
            'student_lrn'=>'required',
            'first_name'=>'required',
            'last_name'=>'required',
            'middle_name'=>'required',
            'extension'=>'',
            'contact_no'=>'required',
            'email'=>'required|email',
            'birth_date'=>'required|date',
            'birth_place'=>'required',
            'sex_at_birth'=>'required',
            'citizenship'=>'required',
            'religion'=>'required',
            'region'=>'required',
            'province'=>'required',
            'city'=>'required',
            'barangay'=>'required',
            'street'=>'required',
            'zip_code'=>'required'
        ]);

        if($validator->fails()) {

            $data = [
                "status"=>422,
                "message"=>$validator->messages()
            ];

            return response()->json($data,422);
        }

        else {
            $student = StudentProfiling::find($id);
            $student->student_lrn=$request->student_lrn;
            $student->first_name=$request->first_name;
            $student->last_name=$request->last_name;
            $student->middle_name=$request->middle_name;
            $student->extension=$request->extension;
            $student->contact_no=$request->contact_no;
            //$student->email=$request->email;
            $student->birth_date=$request->birth_date;
            $student->civil_status=$request->civil_status;
            $student->sex_at_birth=$request->sex_at_birth;
            $student->citizenship=$request->citizenship;
            $student->religion=$request->sreligion;
            $student->region=$request->region;
            $student->province=$request->province;
            $student->city=$request->city;
            $student->barangay=$request->barangay;
            $student->street=$request->street;
            $student->zip_code=$request->zip_code;

            $student->save();

            $data = [
                "status"=>"200",
                "message"=>"Student Profile Updated Successfully"
            ];

            return response()->json($data,200);

        }
    }


    public function updateStatus(Request $request, $id)
    {

        $student = StudentProfiling::where('student_recno',$id)->first();
        // $user = User::create([
        //     'name' => $student->first_name . ' ' . $student->last_name,
        //     'email' => $studentID . '@sna.edu.ph',
        //     'role' => 'student',
        //     'department' => $studentDept,
        //     'password' => $hashedPassword,
        // ]);

        // Update the status
        $student->student_id = '2024534';
        $student->student_id = $request->input('field_name');
        $student->fill($request->all());
        $student->save();

        // Return a success response
        return response()->json(['message' => 'Student status updated successfully', 'student' => $student]);
    }

    public function createAccount(Request $request, $id)
{
    // Find the student by student_recno
    $student = StudentProfiling::where('student_recno', $id)->first();

    if ($student) {
        Log::info('Student found: ', $student->toArray());

        $year = date('Y');

        $randomDigits = str_pad(mt_rand(0, 99999), 5, '0', STR_PAD_LEFT);
        $studentID = $year . $randomDigits;

        // Update the student data
        $student->student_id = $request->input('student_id', $studentID);
        $student->enrollment_status = $request->enrollment_status;
        $student->section = $request->section;
        $studentDept = $student->grade_level > 10 ? 'shs' : 'jhs';

        $hashedPassword = Hash::make($request->password);
    // Create user account
    $user = User::create([
        'name' => $student->first_name . ' ' . $student->last_name,
        'email' => $studentID . '@sna.edu.ph',
        'role' => 'student',
        'department' => $studentDept,
        'password' => $hashedPassword,
    ]);

        $student->adviser_id = $request->adviser_id;
        $student->user_id = $user->id;
        // $student->first_name = 'Manuel';

        // Log before saving
        Log::info('Before save: ', $student->toArray());

        $student->save();
        $status = LibraryStatus::create([
            'student_id' => $student->student_id
        ]);

        // Log after saving
        Log::info('After save: ', $student->toArray());

        return response()->json(['message' => 'Student status updated successfully', 'student' => $student]);
    } else {
        Log::error('Student not found with student_recno: ' . $id);
        return response()->json(['message' => 'Student not found'], 404);
    }
}



    public function addAcadInfo(Request $request, $id){

    }

    public function delete($id) {
        $student = StudentProfiling::find($id);
        $student->delete();

        $data = [
            "status" => "200",
            "message" => "Student Profile Deleted Successfully"
        ];

        return response()->json($data,200);
    }
        /////////////////////////////////////////////////////////////////////////////////////////////
    /*
    |                                                                                              /
    |                                                                                           /
    |
    |
    |
    |
    |
    */
}
