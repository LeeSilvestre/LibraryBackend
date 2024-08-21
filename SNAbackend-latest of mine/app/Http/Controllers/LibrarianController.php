<?php

namespace App\Http\Controllers;

use App\Models\Librarian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LibrarianController extends Controller
{
    public function allLibrarian()
    {
        return response()->json(Librarian::all(), 200);
    }
}
