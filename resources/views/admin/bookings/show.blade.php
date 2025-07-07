@extends('admin.layout')

@section('content')
    <x-app-layout>
        <main id="main" class="main">
            <div class="container mt-4">
                <h1 class="mb-4 text-center">Booking Details</h1>

                <!-- Booking Details Card -->
                <div class="card mb-4">
                    <div class="card-header">
                        Booking ID: {{ $booking->id }}
                    </div>
                    <div class="card-body">
                        <p><strong>User:</strong> {{ $booking->user->name ?? 'N/A' }}</p>
                        <p><strong>Delivery Address:</strong> {{ $booking->delivery_address }}</p>
                        <p><strong>Street:</strong> {{ $booking->street ?? 'N/A' }}</p>
                        <p><strong>Ward:</strong> {{ $booking->ward ?? 'N/A' }}</p>
                        <p><strong>City/Municipality:</strong> {{ $booking->city ?? 'N/A' }}</p>
                        <p><strong>District:</strong> {{ $booking->district ?? 'N/A' }}</p>
                        <p><strong>Province:</strong> {{ $booking->province ?? 'N/A' }}</p>
                        <p><strong>Postal Code:</strong> {{ $booking->postal_code ?? 'N/A' }}</p>
                        <p><strong>Total Rental Cost:</strong> Rs.{{ number_format($booking->total_rental_cost, 2) }}</p>
                        <p><strong>Payment Status:</strong> {{ ucfirst($booking->payment_status) }}</p>
                        <p><strong>Rental Status:</strong> {{ ucfirst($booking->rental_status) }}</p>
                        <p><strong>Transaction ID:</strong> {{ $booking->transaction_id ?? 'N/A' }}</p>
                        <p><strong>Created At:</strong> {{ $booking->created_at->format('Y-m-d H:i') }}</p>
                    </div>
                </div>

                <!-- Order Items Section -->
                <div class="card mb-4">
                    <div class="card-header">
                        Order Items
                    </div>
                    <div class="card-body">
                        @if($booking->orderItems->isEmpty())
                            <p>No items found for this booking.</p>
                        @else
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover text-center">
                                    <thead>
                                    <tr>
                                        <th>Instrument</th>
                                        <th>Image</th>
                                        <th>Quantity</th>
                                        <th>Rental Price</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Subtotal</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($booking->orderItems as $item)
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

                <!-- Form to Update Booking Status -->
                <div class="card mb-4">
                    <div class="card-header">
                        Update Booking Status
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.booking.update', $booking->id) }}" method="POST">
                            @csrf
                            @method('PUT')

{{--                            <div class="mb-3">--}}
{{--                                <label for="payment_status" class="form-label">Payment Status</label>--}}
{{--                                <select name="payment_status" id="payment_status" class="form-control">--}}
{{--                                    <option value="pending" {{ $booking->payment_status === 'pending' ? 'selected' : '' }}>Pending</option>--}}
{{--                                    <option value="completed" {{ $booking->payment_status === 'completed' ? 'selected' : '' }}>Completed</option>--}}
{{--                                    <option value="failed" {{ $booking->payment_status === 'failed' ? 'selected' : '' }}>Failed</option>--}}
{{--                                </select>--}}
{{--                            </div>--}}

                            <div class="mb-3">
                                <label for="rental_status" class="form-label">Rental Status</label>
                                <select name="rental_status" id="rental_status" class="form-control">
                                    <option value="ongoing" {{ $booking->rental_status === 'ongoing' ? 'selected' : '' }}>Ongoing</option>
                                    <option value="completed" {{ $booking->rental_status === 'completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="cancelled" {{ $booking->rental_status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary">Update Status</button>
                        </form>
                    </div>
                </div>

                <!-- Back Button -->
                <div class="mt-4">
                    <a href="{{ route('admin.booking.index') }}" class="btn btn-secondary">Back to Bookings</a>
                </div>
            </div>
        </main>
    </x-app-layout>
@endsection
