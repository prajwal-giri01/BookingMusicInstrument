<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Instruments;
use Illuminate\Http\Request;
use App\Models\Slider; // Import the Slider model
use App\Models\SliderImage; // Import the Slider model
use App\Http\Controllers\CategoryController;
use App\Models\Drinks;

class PageController extends Controller
{
    public function home()
    {

        $images = SliderImage::all();
        $Category = Category::all();
        $instruments = Instruments::with('category')->get();
        return view('pages.home', compact('images','Category', 'instruments' ));
    }
    public function instrumentDetail($id)
    {
        $instrument = Instruments::findorfail($id);
        $relatedInstruments = Instruments::where('category_id', $instrument->category_id)->get();
        return view('pages.detail', compact('instrument', 'relatedInstruments'));
    }
    public function instruments($id)
    {
        $categories = category::all();
        $category = Category::findorfail($id);
        $instruments = Instruments::where('category_id', $id)->get();
        return view('pages.instruments', compact('instruments','category', 'categories'));
    }
    public function search(Request $request)
    {
        // Optional text query (if provided)
        $query = $request->input('query');

        // Get an array of selected category IDs (if any)
        $selectedCategories = $request->input('categories');

        // Get price range filters
        $minPrice = $request->input('min_price');
        $maxPrice = $request->input('max_price');

        // Retrieve all categories to populate the filter dropdown.
        $allCategories = Category::all();

        $instruments = Instruments::with('category')
            ->when($query, function ($q) use ($query) {
                $q->where(function ($q2) use ($query) {
                    $q2->where('name', 'like', "%{$query}%")
                        ->orWhere('description', 'like', "%{$query}%");
                });
            })
            ->when($selectedCategories, function ($q) use ($selectedCategories) {
                $q->whereIn('category_id', $selectedCategories);
            })
            ->when($minPrice, function ($q) use ($minPrice) {
                $q->where('rental_price', '>=', $minPrice);
            })
            ->when($maxPrice, function ($q) use ($maxPrice) {
                $q->where('rental_price', '<=', $maxPrice);
            })

            ->get();

        return view('pages.instruments', [
            'instruments' => $instruments,
            'query' => $query,
            'categories' => $allCategories,
            'selectedCategories' => $selectedCategories,
            'minPrice' => $minPrice,
            'maxPrice' => $maxPrice,
        ]);
    }




}
