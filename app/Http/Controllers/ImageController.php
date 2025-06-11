<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    // Admin upload form
    public function create()
    {
        return view('admin.upload_image');
    }

    // Store uploaded image
    public function store(Request $request)
    {
        $validated = $request->validate([
            'imageType' => 'required|string|max:50',
            'title' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Store the image file
        $path = $request->file('image')->store('public/images');
        $filename = basename($path);

        // Store in database    
        $image = Image::create([
            'image_type' => $validated['imageType'],
            'title' => $validated['title'],
            'filename' => $filename,
        ]);

        // return redirect()->route('images.index')->with('success', 'Image uploaded successfully!');
    }

    // public function destroy ($id)
    // {
    //     $image = Image::findOrFail($id);

    //     if(Storage::exists(''))
    // }

    // // Display images to users
    // public function index()
    // {
    //     $images = Image::latest()->get();
    //     return view('images.index', compact('images'));
    // }
}
