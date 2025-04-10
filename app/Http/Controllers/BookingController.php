<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order; // Assuming your Order model represents a booking

class BookingController extends Controller
{
    /**
     * Display all bookings for admin.
     */
    public function index()
    {
        // Retrieve all bookings with related user and order items.
        $bookings = Order::with('user', 'orderItems')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.bookings.index', compact('bookings'));
    }

    /**
     * Display the details of a specific booking.
     */
    public function show($id)
    {
        $booking = Order::with('user', 'orderItems')->findOrFail($id);
        return view('admin.bookings.show', compact('booking'));
    }

    /**
     * Show the form to edit a booking.
     */
    public function edit($id)
    {
        $booking = Order::findOrFail($id);
        return view('admin.bookings.edit', compact('booking'));
    }

    /**
     * Update a booking.
     */
    public function update(Request $request, $id)
    {
        $booking = Order::findOrFail($id);

        $validated = $request->validate([
            'payment_status' => 'required|string',
            'rental_status'  => 'required|string',
        ]);

        $booking->update($validated);

        return redirect()->route('admin.booking.show', $booking->id)
            ->with('success', 'Booking status updated successfully.');
    }


    /**
     * Delete a booking.
     */
    public function destroy($id)
    {
        $booking = Order::findOrFail($id);
        $booking->delete();

        return redirect()->route('admin.booking.index')
            ->with('success', 'Booking deleted successfully.');
    }
}
