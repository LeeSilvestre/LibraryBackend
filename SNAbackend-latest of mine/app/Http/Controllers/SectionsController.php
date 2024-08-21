<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Section;
class SectionsController extends Controller
{
    //

    public function getSections(){
        $section = Section::with([
            'adviser' => function($query) {
                $query->select('id', \DB::raw("CONCAT(fname, ' ', COALESCE(mname, ''), ' ', lname) AS full_name"), 'department');
            }]
        )->get();
        $data = [
            "status" => 200,
            "data" => $section
        ];
        return response()->json($data, 200);
    }
}
