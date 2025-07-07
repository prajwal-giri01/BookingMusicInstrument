@extends('frontend.Master')
@section('content')
    <div class="container" style="margin-top: 7rem;">
        <h1 class="mb-4 text-center">My Orders</h1>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if($orders->isEmpty())
            <div class="alert alert-info text-center">
                You have not placed any orders yet.
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-striped table-hover text-center">
                    <thead class="table-dark">
                    <tr>
                        <th>Order ID</th>
                        <th>Total Cost</th>
                        <th>Payment</th>
                        <th>Rental</th>
                        <th>Order Date</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($orders as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>Rs. {{ number_format($order->total_rental_cost, 2) }}</td>
                            <td><span class="badge bg-success">{{ ucfirst($order->payment_status) }}</span></td>
                            <td><span class="badge bg-info text-dark">{{ ucfirst($order->rental_status) }}</span></td>

                            <td>{{ $order->created_at->format('Y-m-d H:i') }}</td>
                            <td>
                                <div class="d-flex justify-content-center gap-2 align-items-center">
                                    <a href="{{ route('order.show', $order->id) }}" class="btn btn-sm btn-outline-primary">
                                        View
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection
