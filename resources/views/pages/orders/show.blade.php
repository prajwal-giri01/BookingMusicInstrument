@extends('frontend.Master')
@section('content')
    <div class="container mt-4">
        <h1 class="mb-4">Order Details</h1>

        <!-- Order Information -->
        <div class="card mb-4">
            <div class="card-header">
                Order #{{ $order->id }}
            </div>
            <div class="card-body">
                <p><strong>Total Rental Cost:</strong> Rs.{{ number_format($order->total_rental_cost, 2) }}</p>
                <p><strong>Payment Status:</strong> {{ ucfirst($order->payment_status) }}</p>
                <p><strong>Rental Status:</strong> {{ ucfirst($order->rental_status) }}</p>
                <p><strong>Transaction ID:</strong> {{ $order->transaction_id ?? 'N/A' }}</p>
                <p><strong>Order Date:</strong> {{ $order->created_at->format('Y-m-d H:i') }}</p>
                <p><strong>Delivery Address:</strong> {{ $order->delivery_address }}</p>
                @if($order->latitude && $order->longitude)
                    <p><strong>Location:</strong> ({{ $order->latitude }}, {{ $order->longitude }})</p>
                @endif
            </div>
        </div>

        <!-- Order Items -->
        <div class="card mb-4">
            <div class="card-header">
                Order Items
            </div>
            <div class="card-body">
                @if($order->orderItems->isEmpty())
                    <p>No items in this order.</p>
                @else
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover text-center">
                            <thead class="thead-light">
                            <tr>
                                <th>Instrument</th>
                                <th>Image</th>
                                <th>Quantity</th>
                                <th>Price per Unit</th>
                                <th>Rental Start Date</th>
                                <th>Rental End Date</th>
                                <th>Subtotal</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($order->orderItems as $item)
                                <tr>
                                    <td>{{ $item->instrument->name ?? 'N/A' }}</td>
                                    <td>
                                        @if(isset($item->instrument->image_path))
                                            <img src="{{ asset($item->instrument->image_path) }}" alt="{{ $item->instrument->name }}" class="img-thumbnail" width="100">
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>Rs.{{ number_format($item->price, 2) }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->rental_start_date)->format('Y-m-d') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->rental_end_date)->format('Y-m-d') }}</td>
                                    <td>Rs.{{ number_format($item->price * $item->quantity, 2) }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>

        <!-- Cancel Order Button (only show if not already cancelled) -->
        @if($order->rental_status !== 'cancelled')
            <div class="mb-4">
                <form action="{{ route('order.cancel', $order->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this order?');">
                    @csrf
                    <button type="submit" class="btn btn-danger">Cancel Order</button>
                </form>
            </div>
        @endif

        <!-- Back Button -->
        <div class="mt-4">
            <a href="{{ route('orders.index') }}" class="btn btn-secondary">Back to Orders</a>
        </div>
    </div>
@endsection
