<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Order;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function process(Request $request, Order $order)
    {
        // Validate request data as needed
        $request->validate([
            'payment_method' => 'required|string',
            'amount' => 'required|numeric',
        ]);

        // Simulate payment processing (you can integrate with a payment gateway later)
        $payment = Payment::create([
            'order_id' => $order->id,
            'payment_method' => $request->payment_method,
            'amount' => $request->amount,
            'transaction_id' => 'TRANS' . time(), // Example transaction id
            'status' => 'completed', // Update based on real payment status
        ]);

        // Update the order's payment status if needed
        $order->update(['payment_status' => 'completed']);

        return redirect()->route('order.confirmation', $order->id)
            ->with('success', 'Payment processed successfully!');
    }
}
