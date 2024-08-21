<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rental;
use App\Models\Book;

class RentalController extends Controller
{
    public function allRental()
    {
        return response()->json(Rental::all(), 200);
    }

    public function showARental($id)
    {
        $book = Rental::find($id);
        if (!$book) {
            return response()->json(['error' => 'Rental record not found'], 404);
        }
        return response()->json($book, 200);
    }

    public function createRental(Request $request)
    {
        $subjectFields = [
            'Araling_Panlipunan',
            'English',
            'Filipino',
            'MAPEH',
            'Mathematics',
            'Science',
            'TLE',
            'CL',
            'VE'
        ];

        foreach ($subjectFields as $field) {
            $bookTitle = $request->input($field);

            $book = Book::where('book_title', $bookTitle)->first();

            if (!$book) {
                return response()->json(['error' => "Book with title '$bookTitle' not found"], 404);
            }

            if ($book->book_qty <= 0) {
                return response()->json(['error' => "Book '$bookTitle' is out of stock"], 400);
            }

            if ($book->is_archived) {
                return response()->json(['error' => "Book '$bookTitle' is archived and cannot be rented"], 400);
            }

            $book->book_qty--;
            $book->save();
        }

        $rental = Rental::create($request->all());

        return response()->json($rental, 201);
    }

    public function updateRental(Request $request, $rental_id)
    {
        $rental = Rental::find($rental_id);
        if (!$rental) {
            return response()->json(['error' => 'Rental not found'], 404);
        }
        $data = $request->except('student_id');
        $rental->update($data);
        $rental->update(['status' => 2]);
        return response()->json(['message' => 'Rental updated successfully'], 200);
    }

    public function receiptRental($id)
    {
        $borrowStatus = Rental::find($id);
        if (!$borrowStatus) {
            return response()->json(['error' => 'Rental not found'], 404);
        }
        $borrowStatus->update(['status' => 2]);
        $book = $borrowStatus->book;
        //$book->increment('book_qty');
        return response()->json(['message' => 'Rental status updated successfully'], 200);
    }

    public function returnRental($id)
    {
        $rental = Rental::find($id);
        if (!$rental) {
            return response()->json(['error' => 'Rental not found'], 404);
        }

        $subjectFields = [
            'Araling_Panlipunan',
            'English',
            'Filipino',
            'MAPEH',
            'Mathematics',
            'Science',
            'TLE',
            'CL',
            'VE'
        ];

        foreach ($subjectFields as $field) {
            $bookTitle = $rental->$field;

            $book = Book::where('book_title', $bookTitle)->first();

            if ($book) {
                $book->book_qty++;
                $book->save();
            }
        }

        $rental->update(['status' => 1]);

        return response()->json(['message' => 'Rental returned successfully'], 200);
    }
}
