<?php

namespace App\Http\Controllers;

use App\Models\items;
use App\Models\rooms;
use Illuminate\Http\Request;

class RoomsController extends Controller
{
    public function displayRooms(Request $request)
    {
        $rooms = rooms::all();
        return $rooms;
    }

    public function displaySingleRooms(Request $request)
    {
        $rooms = rooms::find($request->id);
        return $rooms;
    }
    // 
    // 
    public function addRooms(Request $request)
    {
        $request->validate([
            'rooms_num' => 'required',
        ]);
        $rooms = new rooms;
        $rooms->rooms_num = $request->rooms_num;
        $rooms->save();
        return response()->json(['message' => 'successful']);
    }
    // 
    // 
    public function updateRooms(Request $request, $id)
    {
        $rooms = rooms::findOrFail($id);

        $request->validate([
            'rooms_num' => 'required',
        ]);

        $rooms->update([
            'rooms_num' => $request->rooms_num
        ]);

        return response()->json(['message' => 'successful']);
    }

    public function deleteRooms(Request $request)
    {
        $rooms = rooms::findOrFail($request->id);
        $rooms->delete();
        return response()->json(['message' => 'successfull']);
    }
}
