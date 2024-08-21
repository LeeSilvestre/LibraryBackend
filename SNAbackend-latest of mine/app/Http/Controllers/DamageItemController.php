<?php

namespace App\Http\Controllers;

use App\Models\damageItems;
use App\Models\unusableItems;
use App\Models\items;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DamageItemController extends Controller
{
    public function index()
    {
        $items = damageItems::all();
        return response()->json($items);
    }

    public function store(Request $request)
{
    $request->validate([
        'item_id' => 'required|integer|exists:borrowed_items,item_id',
        'item_name' => 'required|string',
        'category' => 'required|string',
        'unit_of_measure' => 'required|string',
        'room_number' => 'required|string',
        'school_level' => 'required|string',
        'report_by' => 'required|string',
        'description' => 'required|string',
        'date_reported' => 'required|date',
        'adviser' => 'required|string',
        'quantity' => 'required|integer',
    ]);

    damageItems::create($request->all());


    return response()->json(['message' => 'Item marked as damaged successfully']);
}

    public function repairItem(Request $request)
    {
        $request->validate([
            'item_id' => 'required|integer|exists:damage_items,item_id',
            'quantity' => 'required|integer',
        ]);

        // Find the damaged item using the item_id
        $damagedItem = damageItems::where('item_id', $request->item_id)->first();

        // Find the original item
        $item = items::find($damagedItem->item_id);

        // Update the item's stock
        $item->item_quantity += $request->quantity;
        $item->save();

        $damagedItem->delete();

        return response()->json(['message' => 'Item repaired successfully']);
    }

    public function totalDamagedQuantitiesPerItem()
    {
        $damagedQuantities = damageItems::select('item_id', DB::raw('SUM(quantity) as total_damaged'))
            ->groupBy('item_id')
            ->get();

        return response()->json($damagedQuantities);
    }

}
