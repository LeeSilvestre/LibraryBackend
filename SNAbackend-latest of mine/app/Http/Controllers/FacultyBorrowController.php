<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FacultyBorrow;
use App\Models\Book;

class FacultyBorrowController extends Controller
{
    public function allFacultyBorrows()
    {
        return response()->json(FacultyBorrow::all(), 200);
    }

    public function createFacultyBorrow(Request $request)
    {
        $bookId = $request->input('book_title');
        $book = Book::find($bookId);
        if (!$book) {
            return response()->json(['error' => 'Book not found'], 404);
        }
        if ($book->book_qty <= 0) {
            return response()->json(['error' => 'Book is out of stock'], 400);
        }
        if ($book->is_archived) {
            return response()->json(['error' => 'Book is archived and cannot be borrowed'], 400);
        }
        $book->book_qty--;
        $book->save();
        $facultyBorrow = FacultyBorrow::create($request->all());
        return response()->json($facultyBorrow, 201);
    }

    public function getFacultyBorrow($id)
    {
        $facultyBorrow = FacultyBorrow::find($id);
        if (!$facultyBorrow) {
            return response()->json(['error' => 'Faculty borrow not found'], 404);
        }
        return response()->json($facultyBorrow, 200);
    }

    public function updateFacultyBorrowStatus($id)
    {
        $facultyBorrow = FacultyBorrow::find($id);
        if (!$facultyBorrow) {
            return response()->json(['error' => 'Faculty borrow not found'], 404);
        }
        $facultyBorrow->update(['borrow_status' => 2]);
        $book = $facultyBorrow->book;
        $book->increment('book_qty');
        return response()->json(['message' => 'Faculty borrow status updated successfully'], 200);
    }

    public function damagedFacultyBorrowStatus($id)
    {
        $facultyBorrow = FacultyBorrow::find($id);
        if (!$facultyBorrow) {
            return response()->json(['error' => 'Faculty borrowed book not found'], 404);
        }
        $facultyBorrow->update(['borrow_status' => 3]);
        $book = $facultyBorrow->book;
        $book->increment('book_qty');
        return response()->json(['message' => 'Faculty borrow status updated successfully'], 200);
    }

    public function lostFacultyBorrowStatus($id)
    {
        $facultyBorrow = FacultyBorrow::find($id);
        if (!$facultyBorrow) {
            return response()->json(['error' => 'Faculty borrowed book not found'], 404);
        }
        $facultyBorrow->update(['borrow_status' => 4]);
        $book = $facultyBorrow->book;
        //$book->increment('book_qty');
        return response()->json(['message' => 'Faculty borrow status updated successfully'], 200);
    }

    public function dPayFacultyBorrowStatus($id)
    {
        $facultyBorrow = FacultyBorrow::find($id);
        if (!$facultyBorrow) {
            return response()->json(['error' => 'Faculty borrowed book not found'], 404);
        }
        $facultyBorrow->update(['borrow_status' => 5]);
        $book = $facultyBorrow->book;
        $book->increment('book_qty');
        return response()->json(['message' => 'Faculty borrow status updated successfully'], 200);
    }

    public function lPayFacultyBorrowStatus($id)
    {
        $facultyBorrow = FacultyBorrow::find($id);
        if (!$facultyBorrow) {
            return response()->json(['error' => 'Faculty borrowed book not found'], 404);
        }
        $facultyBorrow->update(['borrow_status' => 6]);
        $book = $facultyBorrow->book;
        //$book->increment('book_qty');
        return response()->json(['message' => 'Faculty borrow status updated successfully'], 200);
    }

    public function oPayFacultyBorrowStatus($id)
    {
        $facultyBorrow = FacultyBorrow::find($id);
        if (!$facultyBorrow) {
            return response()->json(['error' => 'Faculty borrowed book not found'], 404);
        }
        $facultyBorrow->update(['borrow_status' => 6]);
        $book = $facultyBorrow->book;
        //$book->increment('book_qty');
        return response()->json(['message' => 'Faculty borrow status updated successfully'], 200);
    }

    public function cancelFacultyBorrowStatus($id)
    {
        $facultyBorrow = FacultyBorrow::find($id);
        if (!$facultyBorrow) {
            return response()->json(['error' => 'Faculty borrow not found'], 404);
        }
        $facultyBorrow->update(['borrow_status' => 0]);
        return response()->json(['message' => 'Faculty borrow status canceled successfully'], 200);
    }
}
