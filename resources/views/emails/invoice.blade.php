@component('mail::message')
    # Invoice Confirmation

    Hello {{ $order->user->name ?? 'Customer' }},

    Thank you for your order! Here are your booking details:

    **Booking ID:** {{ $order->id }}
    **Total Cost:** Rs. {{ number_format($order->total_rental_cost, 2) }}
    **Delivery Address:**
    {{ $order->delivery_address }}, {{ $order->street }},
    Ward {{ $order->ward }}, {{ $order->city }}, {{ $order->district }},
    {{ $order->province }} - {{ $order->postal_code }}

    ## Ordered Items:
    @foreach ($order->orderItems as $item)
        - {{ $item->instrument->name }} (x{{ $item->quantity }})
        @ Rs.{{ number_format($item->price, 2) }} = Rs.{{ number_format($item->quantity * $item->price, 2) }}
    @endforeach

    Thanks for choosing BookingWebsite!

@endcomponent
