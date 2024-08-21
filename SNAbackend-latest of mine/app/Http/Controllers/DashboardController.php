<?php

namespace App\Http\Controllers;

use App\Models\borrowedItems;
use App\Models\damageItems;
use App\Models\items;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

    public function index()
    {
        // Calculate overall totals
        $totals = [
            'item_quantity' => items::sum('item_quantity'),
            'borrowed_items' => borrowedItems::sum('quantity'),
            'overdue_items' => borrowedItems::where('status', 'Overdue')->sum('quantity'),
            'damaged_items' => damageItems::sum('quantity'),
        ];

        // Calculate totals for Junior High School
        $juniorHighInventory = [
            'item_quantity' => items::where('school_level', 'Junior High School')->sum('item_quantity'),
            'borrowed_items' => borrowedItems::where('school_level', 'Junior High School')->sum('quantity'),
            'overdue_items' => borrowedItems::where('school_level', 'Junior High School')->where('status', 'Overdue')
            ->sum('quantity'),
            'damaged_items' => damageItems::where('school_level', 'Junior High School')->sum('quantity'),
        ];

        // Calculate totals for Senior High School
        $seniorHighInventory = [
            'item_quantity' => items::where('school_level', 'Senior High School')->sum('item_quantity'),
            'borrowed_items' => borrowedItems::where('school_level', 'Senior High School')->sum('quantity'),
            'overdue_items' => borrowedItems::where('school_level', 'Senior High School')->where('status', 'Overdue')
            ->sum('quantity'),
            'damaged_items' => damageItems::where('school_level', 'Senior High School')->sum('quantity'),
        ];

        // Get Most Borrowed Items
        $mostBorrowedItems = borrowedItems::select('item_id', 'item_name', DB::raw('SUM(quantity) as borrowed_quantity'))
            ->groupBy('item_id', 'item_name')
            ->orderBy('borrowed_quantity', 'DESC')
            ->limit(5)
            ->get();

        // Get Most Damaged Items
        $mostDamagedItems = damageItems::select('item_id', 'item_name', DB::raw('SUM(quantity) as damaged_quantity'))
            ->groupBy('item_id', 'item_name')
            ->orderBy('damaged_quantity', 'DESC')
            ->limit(5)
            ->get();

        return response()->json([
            'totals' => $totals,
            'juniorHighInventory' => $juniorHighInventory,
            'seniorHighInventory' => $seniorHighInventory,
            'mostBorrowedItems' => $mostBorrowedItems,
            'mostDamagedItems' => $mostDamagedItems,
        ]);
    }
}
