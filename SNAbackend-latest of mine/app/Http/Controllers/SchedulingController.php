<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Scheduling;
use App\Models\Registrar\Faculty;

class SchedulingController extends Controller
{
    //

    public function getSched(){
        $sched = Scheduling::all();

        $data = [
            "status" => 200,
            "data" => $sched
        ];
        return response()->json( $data, 200);
    }
    public function getSchedules($id){
        $sched = Scheduling::where('section', $id)->with('faculty')->get();


        $data = [
            "status" => 200,
            "sched" => $sched
        ];
        return response()->json( $data, 200);


    }
    public function insertSched(Request $request) {

        $adviser = Faculty::find($request->adviser_id);
        $schedule = Scheduling::where('section', $request->section)->first();
        $randomDigits = str_pad(mt_rand(0, 99999), 5, '0', STR_PAD_LEFT);
        $classcode =   $request->grade_level < 11 ? '10'. $randomDigits : '20'. $randomDigits;

        $scheduling = new Scheduling();
        $scheduling->classcode = $classcode;
        $scheduling->section = $request->section;
        $scheduling->adviser_id = $request->adviser_id;
        $scheduling->class_desc = $adviser ? $adviser->department : 'N/A'; // Set class_desc based on adviser's specialization
        $scheduling->day = $request->day;

        if(!$schedule){
            $scheduling->time = $request->time;
            $scheduling->save();
        } else{
            if($request->time == $schedule->time ){
                return response()->json([
                    "status" => 400,
                    "Message" => "Schedule Already Taken"
                ], 400);
            } else {
                if($adviser->department == $schedule->class_desc){
                    return response()->json([
                        "status" => 400,
                        "Message" => "Subject Already Taken"
                    ], 400);
                }else {
                    $scheduling->time = $request->time;
                    $scheduling->save();
                }
            }
        }

        return response()->json(['message' => 'Subject added successfully', 'Subject' => $scheduling]);
    }

}
