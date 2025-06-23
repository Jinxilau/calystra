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
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Store the image file
        $path = $request->file('image')->store('images', 'public');
        $filename = basename($path);

        // Store in database    
        $image = Image::create([
            'image_type' => $validated['imageType'],
            'filename' => $filename,
        ]);

        return redirect()->route('images.index')->with('success', 'Image uploaded successfully!');
    }

    public function destroy($id)
    {
        $image = Image::findOrFail($id);

        if (Storage::disk('public')->exists('images/' . $image->filename)) {
            Storage::disk('public')->delete('images/' . $image->filename);
        }
        $image->delete();

        return redirect()->back()->with('success', 'Image deleted successfully.');
    }

    // Display images to users
    public function index(Request $request)
    {   
        $filterType = $request->get('type'); // Get type from dropdown

        $types = Image::select('image_type')->distinct()->pluck('image_type'); // For dropdown

        $images = Image::when($filterType, function ($query, $filterType) {
            return $query->where('image_type', $filterType);
        })->get();

        return view('admin.upload_image', compact('images', 'filterType', 'types'));
    }

    public function showWeddingGallery()
    {   
        $weddingImages = Image::where('image_type', 'wedding')->get();
        return view('wedding', compact('weddingImages')); // ⬅️ this makes $images available in the view
    }

    public function showEventGallery()
    {
        $eventImages = Image::where('image_type', 'event')->get();
        return view('corporate', compact('eventImages')); // ⬅️ this makes $images available in the view
    }

    public function showFashionGallery()
    {
        $fashionImages = Image::where('image_type', 'fashion')->get();
        return view('fashion', compact('fashionImages')); // ⬅️ this makes $images available in the view
    }

    public function showConvoGallery()
    {
        $convoImages = Image::where('image_type', 'convo')->get();
        return view('convo', compact('convoImages')); // ⬅️ this makes $images available in the view
    }
}
