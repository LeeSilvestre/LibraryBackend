<?php

namespace App\Http\Controllers;

use App\Models\items;
use Illuminate\Http\Request;

class ItemsController extends Controller
{

    public function displayItems(Request $request)
    {
        $item = items::all();
        return response()->json($item);
    }


    public function addItems(Request $request)
    {
        $request->validate([
            'item_name' => 'required|string|max:255',
            'item_quantity' => 'required|integer',
            'category' => 'required|string|max:255',
            'unit_of_measure' => 'required|string|max:255',
            'school_level' => 'required|string|max:255',
            'room_number' => 'required|integer',
            'acceptedby' => 'required|string|max:255',
        ]);

        $item = items::create($request->all());

        return response()->json(['message' => 'successful added']);
    }

    public function updateItems(Request $request)
    {
        $item = items::findOrFail($request->id);

        $request->validate([
            'item_name' => 'required|string|max:255',
            'item_quantity' => 'required|integer',
            'category' => 'required|string|max:255',
            'unit_of_measure' => 'required|string|max:255',
            'school_level' => 'required|string|max:255',
            'room_number' => 'required|integer',
            'acceptedby' => 'required|string|max:255',
        ]);

        $item->update($request->only([
            'item_name',
            'item_quantity',
            'category',
            'unit_of_measure',
            'school_level',
            'room_number',
            'acceptedby'
        ]));

        return response()->json(['message' => 'successful updated']);
    }


    public function deleteItems(Request $request)
    {
        $items = items::findOrFail($request->id);
        $items->delete();
        return response()->json(['message' => 'successfull Deleted']);
    }


}
