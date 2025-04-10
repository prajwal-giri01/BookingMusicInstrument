@extends('frontend.Master')
@section('content')
    <div class="container mt-4">
        <h1 class="mb-4">My Orders</h1>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if($orders->isEmpty())
            <p>You have not placed any orders yet.</p>
        @else
            <div class="table-responsive">
                <table class="table table-bordered table-hover text-center">
                    <thead class="thead-light">
                    <tr>
                        <th>Order ID</th>
                        <th>Total Rental Cost</th>
                        <th>Payment Status</th>
                        <th>Rental Status</th>
                        <th>Transaction ID</th>
                        <th>Order Date</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($orders as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>Rs. {{ number_format($order->total_rental_cost, 2) }}</td>
                            <td>{{ ucfirst($order->payment_status) }}</td>
                            <td>{{ ucfirst($order->rental_status) }}</td>
                            <td>{{ $order->transaction_id ?? 'N/A' }}</td>
                            <td>{{ $order->created_at->format('Y-m-d H:i') }}</td>
                            <td class="d-flex">
                                <div class="mb-4">
                                <a href="{{ route('order.show', $order->id) }}" class="btn btn-primary btn-sm">
                                    View
                                </a>
                                </div>
                                @if($order->rental_status !== 'cancelled')
                                    <div class="mb-4">
                                        <form action="{{ route('order.cancel', $order->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this order?');">
                                            @csrf
                                            <button type="submit" class="btn btn-danger">Cancel Order</button>
                                        </form>
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection
