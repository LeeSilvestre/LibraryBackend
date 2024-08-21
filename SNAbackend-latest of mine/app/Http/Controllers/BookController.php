<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;

class BookController extends Controller
{
    public function allBooks()
    {
        $books = Book::with('category')->get();
        return response()->json($books, 200);
    }

    public function showABook($book_title)
    {
        $book = Book::find($book_title);
        if (!$book) {
            return response()->json(['error' => 'Book not found'], 404);
        }
        return response()->json($book, 200);
    }

    public function createBook(Request $request)
    {
        $book = Book::create($request->all());
        return response()->json($book, 201);
    }

    public function updateBookP(Request $request, $book_title)
    {
        $book = Book::find($book_title);
        if (!$book) {
            return response()->json(['error' => 'Book not found'], 404);
        }
        $book->update($request->all());
        return response()->json(['message' => 'Book updated successfully'], 200);
    }

    public function deleteBookP($book_title)
    {
        $book = Book::find($book_title);
        if (!$book) {
            return response()->json(['error' => 'Book not found'], 404);
        }
        $book->delete();
        return response()->json(['message' => 'Book deleted successfully'], 200);
    }

    public function archiveBook(Request $request, $book_title)
    {
        $book = Book::find($book_title);
        if (!$book) {
            return response()->json(['error' => 'Book not found'], 404);
        }
        $book->is_archived = 1;
        $book->reason = $request->input('reason', '');
        $book->save();
        return response()->json(['message' => 'Book archived successfully'], 200);
    }

    public function unarchiveBook($book_title)
    {
        $book = Book::find($book_title);
        if (!$book) {
            return response()->json(['error' => 'Book not found'], 404);
        }
        $book->is_archived = 0;
        $book->save();
        return response()->json(['message' => 'Book unarchived successfully'], 200);
    }
}

