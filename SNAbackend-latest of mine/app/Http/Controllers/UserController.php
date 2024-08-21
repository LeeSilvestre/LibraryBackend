<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use  App\Models\User;

class UserController extends Controller
{
    //
    public function getUsers(){
        $users = User::all();
        $data = [
            "status" => 200,
            "user" => $users
        ];
        return response()->json($data, 200);
    }
}
