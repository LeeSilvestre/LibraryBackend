<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Medicine;

class MedicineController extends Controller
{
    public function allMedicines()
    {
        return response()->json(Medicine::all(), 200);
    }

    public function showAMedicine($id)
    {
        $medicine = Medicine::find($id);
        if (!$medicine) {
            return response()->json(['error' => 'Medicine not found'], 404);
        }
        return response()->json($medicine, 200);
    }

    public function createMedicine(Request $request)
    {
        $medicine = Medicine::create($request->all());
        return response()->json($medicine, 201);
    }

    public function updateMedicineP(Request $request, $id)
    {
        $medicine = Medicine::find($id);
        if (!$medicine) {
            return response()->json(['error' => 'Medicine not found'], 404);
        }
        $medicine->update($request->all());
        return response()->json(['message' => 'Medicine updated successfully'], 200);
    }

    public function deleteMedicineP($id)
    {
        $medicine = Medicine::find($id);
        if (!$medicine) {
            return response()->json(['error' => 'Medicine not found'], 404);
        }
        $medicine->delete();
        return response()->json(['message' => 'Medicine deleted successfully'], 200);
    }
}
