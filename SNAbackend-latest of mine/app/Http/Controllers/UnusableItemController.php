<?php

namespace App\Http\Controllers;

use App\Models\damageItems;
use App\Models\unusableItems;
use Illuminate\Http\Request;

class UnusableItemController extends Controller
    {
        public function index()
        {
            $items = unusableItems::all();
            return response()->json($items);
        }

        public function store(Request $request)
    {
        $request->validate([
            'item_id' => 'required|integer|exists:damage_items,item_id',
            'item_name' => 'required|string',
            'category' => 'required|string',
            'room_number' => 'required|string',
            'school_level' => 'required|string',
            'report_by' => 'required|string',
            'description' => 'required|string',
            'date_reported' => 'required|date',
            'quantity' => 'required|integer',
        ]);

               // Find the damaged item using the item_id
        $damagedItem = damageItems::where('item_id', $request->item_id)->first();

        if (!$damagedItem) {
            return response()->json(['message' => 'Damaged item not found'], 404);
        }

        unusableItems::create($request->all());

        $damagedItem->delete();

        return response()->json(['message' => 'Item marked as unusable successfully']);
    }
}
