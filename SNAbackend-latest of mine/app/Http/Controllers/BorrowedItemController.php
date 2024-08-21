<?php

namespace App\Http\Controllers;

use App\Models\borrowedItems;
use App\Models\damageItems;
use App\Models\items;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BorrowedItemController extends Controller
{
    public function index()
    {
        $items = borrowedItems::all(); // Fetch all items from the database
        return  $items;
    }

    public function store(Request $request)
    {
        $request->validate([
            'item_id' => 'required|integer|exists:items,id',
            'item_name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'unit_of_measure' => 'required|string|max:255',
            'school_level' => 'required|string|max:255',
            'room_number' => 'required|string|max:255',
            'status' => 'required|string|max:255',
            'adviser' => 'required|string|max:255'
        ]);

        // Retrieve the item to check stock
        $item = items::find($request->item_id);

        // Update the item stock
        $item->item_quantity -= $request->quantity;
        borrowedItems::create($request->all());
        $item->save();
        return response()->json(['message' => 'successfull']);
    }

    // public function show(BorrowedItem $borrowedItem)
    // {
    //     return response()->json($borrowedItem);
    // }

    public function update(Request $request, borrowedItems $borrowedItem)
    {
        $borrowedItem->update($request->all());
        return response()->json($borrowedItem);
    }

    public function totalBorrowedQuantityPerItem()
    {
        $totalBorrowedQuantities = DB::table('borrowed_items')
            ->select('item_id', DB::raw('SUM(quantity) as total_quantity'))
            ->groupBy('item_id')
            ->get();
        return response()->json($totalBorrowedQuantities);
    }

    public function returnItem(Request $request)
    {
        $request->validate([
            'item_id' => 'required|integer|exists:borrowed_items,item_id',
            'quantity' => 'required|integer|min:1',
        ]);

        $borrowedItem = borrowedItems::where('item_id', $request->item_id)->first();
        $item = items::find($borrowedItem->item_id);
        $item->item_quantity += $request->quantity;
        $item->save();

        $borrowedItem->delete();

        return response()->json(['message' => 'return successfull']);
    }

    public function totalOverdueQuantitiesPerItem()
    {
        // Query to calculate total overdue quantities per item
        $totalOverdueQuantities = DB::table('borrowed_items')
            ->select('item_id', DB::raw('SUM(quantity) as total_overdue'))
            ->where('return_date', '<', now()) // Filter overdue items
            ->groupBy('item_id')
            ->get();

        return response()->json($totalOverdueQuantities);
    }

    public function markAsDamaged(Request $request)
    {
        $request->validate([
            'item_id' => 'required|integer|exists:borrowed_items,item_id',
            'report_by' => 'required|string',
            'description' => 'required|string',
            'date_reported' => 'required|date',
        ]);

        $borrowedItem = borrowedItems::where('item_id', $request->item_id)->first();
        if ($borrowedItem) {
            // Move to damaged_items table
            damageItems::create([
                'item_id' => $borrowedItem->item_id,
                'item_name' => $borrowedItem->item_name,
                'category' => $borrowedItem->category,
                'unit_of_measure' => $borrowedItem->unit_of_measure,
                'school_level' => $borrowedItem->school_level,
                'room_number' => $borrowedItem->room_number,
                'quantity' => $borrowedItem->quantity,
                'report_by' => $request->report_by,
                'description' => $request->description,
                'date_reported' => $request->date_reported,
                'adviser' => $borrowedItem->adviser,
            ]);

            // Remove from borrowed_items table
            $borrowedItem->delete();

            return response()->json(['message' => 'successfull to damage item']);
        }
        return response()->json(['message' => 'Item not found'], 404);
    }

}
