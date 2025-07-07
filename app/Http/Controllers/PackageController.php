<?php

namespace App\Http\Controllers;

use App\Models\customPackages;
use App\Models\customPackagesItems;
use App\Models\Instruments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class PackageController extends Controller
{
    // List all packages for the logged-in user
    public function packages()
    {
        $packages = customPackages::with('items.instrument')->where('user_id', auth()->id())->get();
        return view('pages.packages', compact('packages'));
    }

    // Show the package creation form
    public function create()
    {
        $instruments = Instruments::all();
        return view('pages.create_package', compact('instruments'));
    }

    // Store the new package
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'instrument_ids' => 'required|array|min:1',
        ]);

        // Calculate total price from instrument prices
        $totalPrice = Instruments::whereIn('id', $request->instrument_ids)->sum('rental_price');

        $package = customPackages::create([
            'name' => $request->name,
            'user_id' => Auth::id(),
            'price' => $totalPrice,
        ]);

        foreach ($request->instrument_ids as $instrumentId) {
            customPackagesItems::create([
                'custom_package_id' => $package->id,
                'instrument_id' => $instrumentId
            ]);
        }

        return redirect()->route('custom-packages.index')->with('success', 'Custom package created successfully.');
    }

    // Show details of a package
    public function show($id)
    {
        $package = customPackages::with('items.instrument')
            ->where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $instruments = Instruments::all();
        return view('pages.show_package', compact('package', 'instruments'));
    }

    // Show the edit form
    public function edit($id)
    {
        $package = customPackages::with('items')->where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        $instruments = Instruments::all();
        return view('pages.edit_package', compact('package', 'instruments'));
    }

    // Update package details
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'instrument_ids' => 'required|array|min:1',
        ]);

        $package = customPackages::where('id', $id)->where('user_id', auth()->id())->firstOrFail();

        // Recalculate price
        $totalPrice = Instruments::whereIn('id', $request->instrument_ids)->sum('rental_price');

        $package->update([
            'name' => $request->name,
            'price' => $totalPrice,
        ]);

        // Sync instruments
        customPackagesItems::where('custom_package_id', $id)->delete();
        foreach ($request->instrument_ids as $instrumentId) {
            customPackagesItems::create([
                'custom_package_id' => $id,
                'instrument_id' => $instrumentId,
            ]);
        }

        return redirect()->route('custom-packages.index')->with('success', 'Package updated successfully.');
    }

    // Add more instruments to an existing package
    public function addInstruments(Request $request, $id)
    {
        $package = customPackages::where('id', $id)->where('user_id', auth()->id())->firstOrFail();

        foreach ($request->instrument_ids as $instrumentId) {
            if (!customPackagesItems::where('custom_package_id', $id)->where('instrument_id', $instrumentId)->exists()) {
                customPackagesItems::create([
                    'custom_package_id' => $id,
                    'instrument_id' => $instrumentId
                ]);
            }
        }

        // Update price after adding
        $totalPrice = Instruments::whereIn('id', customPackagesItems::where('custom_package_id', $id)->pluck('instrument_id'))->sum('rental_price');
        $package->update(['price' => $totalPrice]);

        return redirect()->back()->with('success', 'Instruments added to package.');
    }

    // Remove a specific instrument from a package
    public function removeInstrument($packageId, $itemId)
    {
        $package = customPackages::where('id', $packageId)->where('user_id', auth()->id())->firstOrFail();
        $item = customPackagesItems::where('id', $itemId)->where('custom_package_id', $packageId)->firstOrFail();
        $item->delete();

        // Recalculate total price
        $totalPrice = Instruments::whereIn('id', customPackagesItems::where('custom_package_id', $packageId)->pluck('instrument_id'))->sum('rental_price');
        $package->update(['price' => $totalPrice]);

        return redirect()->back()->with('success', 'Instrument removed from package.');
    }

    // Delete entire package
    public function destroy($id)
    {
        $package = customPackages::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        customPackagesItems::where('custom_package_id', $package->id)->delete();
        $package->delete();

        return redirect()->route('custom-packages.index')->with('success', 'Package deleted successfully.');
    }

    public function rentNow(Request $request, $id)
    {

        $request->validate([
            'rental_start_date' => 'required|date|after_or_equal:today',
            'rental_end_date' => 'required|date|after_or_equal:rental_start_date',
            'quantity' => 'required|integer|min:1'
        ]);
        $package = customPackages::with('items.instrument')
            ->where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        // Store package rental in session for direct checkout
        Session::put('direct_checkout', [
            'package_id' => $package->id,
            'package_name' => $package->name,
            'price' => $package->price,
            'quantity' => $request->quantity,
            'rental_start_date' => $request->rental_start_date,
            'rental_end_date' => $request->rental_end_date,
            'instruments' => $package->items->map(function ($item) {
                return [
                    'id' => $item->instrument->id,
                    'name' => $item->instrument->name,
                    'price' => $item->instrument->rental_price,
                ];
            })->toArray()
        ]);

        return redirect()->route('checkout.direct');
    }
}
