<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\borrowingItems;
use App\Models\items;

class BorrowingItemsController extends Controller
{
    public function allBorrows()
    {
        return response() -> json(borrowingItems::all(), 200);
    }

    public function showNewestStatusId()
    {
        $newestId = borrowingItems::orderBy('id', 'desc')->limit(1)->value('id');
        return response() -> json(['id' => $newestId], 200);
    }

    public function createBorrowStatus(Request $request)
    {
        $itemId = $request->input('id');
        $item = items::find($itemId);
        if (!$item) {
            return response()->json(['error' => 'Item not found'], 404);
        }
        if ($item->items_quantity <= 0) {
            return response()->json(['error' => 'Item is out of stock'], 404);
        }
        $item->items_quantity--;
        $item->save();
        $borrowStatus = borrowingItems::create($request->all());
        return response()->json($borrowStatus, 201);
    }

    public function getAllBorrowByStudent($id)
    {
        $borrowStatus = borrowingItems::where('student_id', $id)->get();
        return response()->json($borrowStatus, 200);
    }

    public function getAllBorrowByBorrow($id)
    {
        $borrowStatus = borrowingItems::find($id);
        if (!$borrowStatus) {
            return response()->json(['error' => 'Item not Found'], 404);
        }
        return response()->json($borrowStatus, 200);
    }

    public function updateBorrowStatus($id)
    {
        $borrowStatus = borrowingItems::find($id);
        if (!$borrowStatus) {
            return response()->json(['error' => 'Borrowed item not found'], 404);
        }
        $borrowStatus->update(['status' => 'returned']);
        $item = $borrowStatus->item;
        $item->increment('items_quantity');
        return response()->json(['message' => 'Borrow status updated successfully'], 200);
    }
}
