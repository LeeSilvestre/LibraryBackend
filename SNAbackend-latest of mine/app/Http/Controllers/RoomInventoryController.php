<?php

namespace App\Http\Controllers;

use App\Models\availableItems;
use App\Models\items;
use App\Models\roomInventory;
use App\Models\rooms;
use Illuminate\Http\Request;

class RoomInventoryController extends Controller
{
    public function showRoomInventory($roomId)
    {
        $room = rooms::findOrFail($roomId);
        $roomInventory = $room->roomInventories()->with('item')->get();
        return response()->json($roomInventory);
    }

    public function addItemToRoom(Request $request, $roomId)
    {
        $request->validate([
            'item_id' => 'required|exists:items,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $room = rooms::findOrFail($roomId);
        $item = $request->item_id;
        $quantity = $request->quantity;

        $roomInventory = RoomInventory::where('room_id', $roomId)
            ->where('item_id', $item)
            ->first();

        if ($roomInventory) {
            $roomInventory->quantity += $quantity;
            $roomInventory->save();
        } else {
            RoomInventory::create([
                'room_id' => $roomId,
                'item_id' => $item,
                'quantity' => $quantity,
            ]);
        }

        return response()->json(['message' => 'Item(s) added to room inventory'], 200);
    }

    public function distributeItems(Request $request)
    {
        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'item_id' => 'required|exists:items,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $roomInventory = new RoomInventory();
        $roomInventory->room_id = $request->room_id;
        $roomInventory->item_id = $request->item_id;
        $roomInventory->quantity = $request->quantity;
        $roomInventory->save();

        $availableItem = availableItems::where('item_id', $request->item_id)->first();
        if ($availableItem) {
            $availableItem->available_quantity -= $request->quantity;
            $availableItem->save();
        } else {
            return response()->json(['error' => 'Item not available'], 404);
        }

        return response()->json(['message' => 'Items distributed successfully'], 200);
    }
}
