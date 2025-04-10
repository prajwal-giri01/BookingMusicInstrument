<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Instruments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InstrumentsController extends Controller
{
    public function index()
    {
        $instruments = Instruments::all();  // Fetch all images from the database
        return view('admin.instruments.index', compact('instruments'));  // Returning the view with images
    }

    // Show the form to create a new image
    public function create()
    {
        $categories = Category::all();
        return view('admin.instruments.create', compact('categories'));
    }


    // Store the new image in the database
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image_path' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
        ]);

        // Upload the image using Storage facade
        $imagePath = $request->file('image_path')->store('photos', 'public');

        // Store the instrument details in the database
        Instruments::create([
            'name' => $request->name,
            'image_path' => 'storage/' . $imagePath,
            'description' => $request->description,
            'rental_price' => $request->price,
            'category_id' => $request->category_id,
        ]);
        return redirect()->route('admin.instruments.index')->with('success', 'instrument updated successfully!');
    }


    // Show the form to edit an image
    public function edit($id)
    {
        $categories = Category::all();
        $instrument = Instruments::findOrFail($id);
        return view('admin.instruments.edit', compact('instrument','categories'));
    }

    // Update an image
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $instrument = Instruments::findOrFail($id);

        if ($request->hasFile('image_path')) {
            $imagePath = $request->file('image_path')->store('photos', 'public');
            $instrument->image_path = 'storage/' . $imagePath;
        }

        $instrument->name = $request->name;
        $instrument->description = $request->description;
        $instrument->rental_price = $request->price;
        $instrument->category_id = $request->category_id;
        $instrument->save();

        return redirect()->route('admin.instruments.index')->with('success', 'Instrument updated successfully!');
    }


    // Delete an image
    public function destroy($id)
    {
        $image = Instruments::findOrFail($id);

        // Delete the image file from storage
        Storage::disk('public')->delete($image->image_path);  // Delete the image using Storage

        // Delete the image record from the database
        $image->delete();
        return redirect()->route('admin.instruments.index')->with('success', 'Instrument deleted successfully!');
    }
}
