@extends('frontend.Master')
@section('content')
    <section class="h-100 gradient-custom">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card text-center mb-4">
                        <div class="card-header py-3">
                            <h5 class="mb-0">Order Confirmation</h5>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">Thank you for your order!</h5>
                            <p class="card-text">
                                Your order number is <strong>#{{ $order->id }}</strong>.
                            </p>
                            <p class="card-text">
                                Total Rental Cost: Rs. {{ number_format($order->total_rental_cost, 2) }}
                            </p>
                            <p class="card-text">
                                Payment Status: {{ ucfirst($order->payment_status) }}
                            </p>
                            <a href="{{ route('home') }}" class="btn btn-primary btn-lg">
                                Continue Shopping
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
