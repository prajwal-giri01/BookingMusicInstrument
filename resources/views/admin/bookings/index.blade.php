@extends('admin.layout')

@section('content')
    <x-app-layout>
        <main id="main" class="main">
            <div class="container mt-4">
                <h1 class="mb-4 text-center">Booking List</h1>

                <div class="table-responsive" style="margin-top: 2rem;">
                    <table class="table table-bordered table-hover text-center">
                        <thead class="thead-dark">
                        <tr>
                            <th>Booking ID</th>
                            <th>User Name</th>
                            <th>Delivery Address</th>
                            <th>Total Cost (Rs.)</th>
                            <th>Payment Status</th>
                            <th>Rental Status</th>
                            <th>Transaction ID</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($bookings as $booking)
                            <tr>
                                <td>{{ $booking->id }}</td>
                                <td>{{ $booking->user->name ?? 'N/A' }}</td>
                                <td>{{ $booking->delivery_address }}</td>
                                <td>{{ number_format($booking->total_rental_cost, 2) }}</td>
                                <td>{{ ucfirst($booking->payment_status) }}</td>
                                <td>{{ ucfirst($booking->rental_status) }}</td>
                                <td>{{ $booking->transaction_id ?? 'N/A' }}</td>
                                <td>{{ $booking->created_at->format('Y-m-d H:i') }}</td>
                                <td>
                                    <div class="d-flex justify-content-center align-items-center gap-2">
                                        <a href="{{ route('admin.booking.show', $booking->id) }}" class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i> View
                                        </a>
{{--                                        <a href="{{ route('admin.booking.edit', $booking->id) }}" class="btn btn-warning btn-sm">--}}
{{--                                            <i class="fas fa-edit"></i> Edit--}}
{{--                                        </a>--}}
                                        <form action="{{ route('admin.booking.destroy', $booking->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this booking?')">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </x-app-layout>
@endsection
