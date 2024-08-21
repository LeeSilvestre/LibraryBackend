<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;
use Illuminate\Support\Facades\Auth;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $images = Image::all();

        // Construct the full URLs for each image and add file type to each item
           $imageUrls = $images->map(function ($image) {
               return [
                   'url' => 'http://26.81.173.255:8000/uploads/profile/' . $image->image,
                   'file_type' => $image->file_type
               ];
           });

           // Prepare the response data
           $data = [
               'status' => 200,
               'images' => $imageUrls
           ];
        return response()->json($data, 200);
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeStudIMG(Request $request)
    {
        // Validate the request
            // $request->validate([
            //     'student_lrn' => 'required|integer',
            //     'image' => 'required|max:2048', // Adjust validation rules as needed
            // ]);

        $image = new Image();
        $image->student_lrn = $request->student_lrn;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move(public_path('uploads/profile'), $filename); // Ensure the path is correct and writable
            $image->image = $filename;

            $image->save();

            return response()->json([
                'status' => 200,
                'image' => $image->image,
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => "No image has been passed",
            ], 404);
        }
    }

    public function storeFacultyIMG(Request $request)
    {
        //

        $image = new Image();
        $image->student_id = $request->student_id;
        if($request->hasFile('image')){
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = time(). '.' . $extension;
            $file->move('uploads/profile', $filename);
            $image->image = $filename;
        } else {
            return $request;
            $image->image ='';
        }

        $image->save();
        $data = [
            'status' => 200,
            'image' => $image
        ];
        return response()->json($data, 200);
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Retrieve all image paths and file types associated with the given student_lrn
        $images = Image::where('student_lrn', $id)->get(['image', 'file_type']);

        // Construct the full URLs for each image and add file type to each item
        $imageUrls = $images->map(function ($image) {
            return [
                'url' => 'http://26.81.173.255:8000/uploads/profile/' . $image->image,
                'file_type' => $image->file_type
            ];
        });

        // Prepare the response data
        $data = [
            'status' => 200,
            'images' => $imageUrls
        ];

        // Return the data as a JSON response
        return response()->json($data, 200);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Find the image record by student_id
        $image = Image::where('student_id', $id)->first();

        // Check if the image record exists
        if (!$image) {
            $image = new Image();
            $image->student_id = $id;
        }

        // Update the image if a new file is provided
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move('uploads/profile', $filename);
            $image->image = $filename;
            $image->save();
        }

        // Return the updated image data
        return response()->json($image, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
