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
        $drinks = Instruments::where('category_id', $id)->get();
        return view('pages.instruments', compact('drinks','category', 'categories'));
    }


}
