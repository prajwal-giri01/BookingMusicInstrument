<?php

// app/Http/Controllers/SliderImageController.php

namespace App\Http\Controllers;

use App\Models\SliderImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SliderImageController extends Controller
{
    // Display all images
    public function index()
    {
        $images = SliderImage::all();  // Fetch all images from the database
        return view('admin.sliders.index', compact('images'));  // Returning the view with images
    }

    // Show the form to create a new image
    public function create()
    {
        return view('admin.sliders.create');
    }

    // Store the new image in the database
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Upload the image using Storage facade
        $imagePath = $request->file('image')->store('photos', 'public');  // Store in 'storage/app/public/photos'

        // Store the image path in the database
        SliderImage::create([
            'image_path' => 'storage/' . $imagePath,  // Ensure it is prefixed with 'storage/'
        ]);

        // Fetch updated images and return the view with success message
        $images = SliderImage::all();
        return view('admin.sliders.index', compact('images'))->with('success', 'Image uploaded successfully!');
    }

    // Show the form to edit an image
    public function edit($id)
    {
        $image = SliderImage::findOrFail($id);
        return view('admin.sliders.edit', compact('image'));
    }

    // Update an image
    public function update(Request $request, $id)
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $image = SliderImage::findOrFail($id);

        if ($request->hasFile('image')) {
            // Delete the old image file from storage if a new one is uploaded
            Storage::disk('public')->delete($image->image_path);  // Delete the old image using Storage

            // Upload the new image and update the image path
            $imagePath = $request->file('image')->store('photos', 'public');
            $image->image_path = 'storage/' . $imagePath;  // Ensure it is prefixed with 'storage/'
        }

        $image->save();

        // Fetch updated images and return the view with success message
        $images = SliderImage::all();
        return view('admin.sliders.index', compact('images'))->with('success', 'Image updated successfully!');
    }

    // Delete an image
    public function destroy($id)
    {
        $image = SliderImage::findOrFail($id);

        // Delete the image file from storage
        Storage::disk('public')->delete($image->image_path);  // Delete the image using Storage

        // Delete the image record from the database
        $image->delete();

        // Fetch updated images and return the view with success message
        $images = SliderImage::all();
        return view('admin.sliders.index', compact('images'))->with('success', 'Image deleted successfully!');
    }
}
