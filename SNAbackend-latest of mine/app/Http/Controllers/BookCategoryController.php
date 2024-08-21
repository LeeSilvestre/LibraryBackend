<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BookCategory;
use Illuminate\Support\Facades\DB;
use App\Models\Book;
use Illuminate\Support\Facades\Log; 
class BookCategoryController extends Controller

{
    public function allCategory()
    {
        return response()->json(BookCategory::all(), 200);
    }

    public function showACategory($categ_name)
    {
        $book = BookCategory::find($categ_name);
        if (!$book) {
            return response()->json(['error' => 'Category not found'], 404);
        }
        return response()->json($book, 200);
    }

    public function createCategory(Request $request)
    {
        $book = BookCategory::create($request->all());
        return response()->json($book, 201);
    }

    public function updateCategory(Request $request, $categ_name)
    {
        DB::beginTransaction();

        try {
            $category = BookCategory::where('categ_name', $categ_name)->first();

            if (!$category) {
                return response()->json(['error' => 'Category not found'], 404);
            }

            $new_categ_name = $request->input('categ_name');

            Book::where('categ_name', $categ_name)->update(['categ_name' => $new_categ_name]);

            $category->update($request->all());

            DB::commit();

            return response()->json(['message' => 'Category and related references updated successfully'], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json(['error' => 'An error occurred while updating the category'], 500);
        }
    }

    public function deleteCategory($categ_name)
    {
        $book = BookCategory::find($categ_name);
        if (!$book) {
            return response()->json(['error' => 'Category not found'], 404);
        }
        $book->delete();
        return response()->json(['message' => 'Category deleted successfully'], 200);
    }

    public function archiveCategory($categ_name)
    {
        $category = BookCategory::find($categ_name);
        if (!$category) {
            return response()->json(['error' => 'Category not found'], 404);
        }
        $category->is_archived = 1;
        $category->save();
        return response()->json(['message' => 'Category archived successfully'], 200);
    }

    public function unarchiveCategory($categ_name)
    {
        $category = BookCategory::find($categ_name);
        if (!$category) {
            return response()->json(['error' => 'Category not found'], 404);
        }
        $category->is_archived = 0;
        $category->save();
        return response()->json(['message' => 'Category unarchived successfully'], 200);
    }
}
