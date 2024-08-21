<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventory; // Import your Inventory model

class InventoryController extends Controller
{
    public function index()
    {
        return response()->json(Inventory::all());
    }

    public function store(Request $request)
    {
        // Validate incoming request
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'dosage' => 'required|string|max:255',
            'expirationDate' => 'required|date',
            'quantity' => 'required|integer',
            'unit' => 'required|string|max:255',
            'dateAcquisition' => 'required|date',
        ]);

        // Create new inventory record
        Inventory::create($validatedData);

        // Return a JSON response
        return response()->json(['message' => 'Product added successfully'], 201);
    }

    public function show($id)
    {
        return response()->json(Inventory::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        // Validate incoming request
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'dosage' => 'required|string|max:255',
            'expirationDate' => 'required|date',
            'quantity' => 'required|integer',
            'unit' => 'required|string|max:255',
            'dateAcquisition' => 'required|date',
        ]);

        // Find the inventory item and update
        $inventory = Inventory::findOrFail($id);
        $inventory->update($validatedData);

        return response()->json(['message' => 'Product updated successfully']);
    }

    public function destroy($id)
    {
        // Find the inventory item and delete
        $inventory = Inventory::findOrFail($id);
        $inventory->delete();

        return response()->json(['message' => 'Product deleted successfully']);
    }
}
