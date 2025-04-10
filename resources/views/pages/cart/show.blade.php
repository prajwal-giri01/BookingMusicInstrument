@extends('frontend.Master')
@section('content')
    <section class="h-100 gradient-custom">
        <div class="container py-5">
            <div class="row d-flex justify-content-center my-4">
                <div class="col-md-8">
                    <div class="card mb-4">
                        <div class="card-header py-3">
                            <h5 class="mb-0">Cart - {{ count($cartItems) }} items</h5>
                        </div>
                        <div class="card-body">
                            @foreach($cartItems as $item)
                                <!-- Single item -->
                                <div class="row align-items-center mb-4">
                                    <div class="col-lg-3 col-md-12 mb-4 mb-lg-0">
                                        <!-- Image -->
                                        <div class="bg-image hover-overlay hover-zoom ripple rounded" data-mdb-ripple-color="light">
                                            <img src="{{ asset($item->instrument->image_path) }}" class="w-100" alt="{{ $item->instrument->name }}" />
                                            <a href="#!">
                                                <div class="mask" style="background-color: rgba(251, 251, 251, 0.2)"></div>
                                            </a>
                                        </div>
                                    </div>

                                    <div class="col-lg-5 col-md-6 mb-4 mb-lg-0">
                                        <!-- Data -->
                                        <p><strong>{{ $item->instrument->name }}</strong></p>
                                        <p>rental_price: Rs. {{ number_format($item->instrument->rental_price, 2) }}</p>

                                        <!-- Date Controls -->
                                        <!-- Date Controls -->
                                        <form action="{{ route('cart.updateDate', $item->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')

                                            <label for="start_date_{{ $item->id }}" class="form-label">Start Date:</label>
                                            <input type="date" name="start_date" id="start_date_{{ $item->id }}"
                                                   value="{{ old('start_date', $item->rental_start_date ? date('Y-m-d', strtotime($item->rental_start_date)) : '') }}"
                                                   class="form-control mb-2" style="max-width: 200px;">

                                            <label for="end_date_{{ $item->id }}" class="form-label">End Date:</label>
                                            <input type="date" name="end_date" id="end_date_{{ $item->id }}"
                                                   value="{{ old('end_date', $item->rental_end_date ? date('Y-m-d', strtotime($item->rental_end_date)) : '') }}"
                                                   class="form-control mb-2" style="max-width: 200px;">

                                            <button type="submit" class="btn btn-primary btn-sm">Update Dates</button>
                                        </form>


                                        <button type="button" class="btn btn-danger btn-sm me-1 mb-2" title="Remove item"
                                                onclick="event.preventDefault(); document.getElementById('remove-item-{{ $item->id }}').submit();">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                        <form id="remove-item-{{ $item->id }}" action="{{ route('cart.remove', $item->id) }}" method="POST" style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </div>

                                    <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
                                        <!-- Quantity -->
                                        <div class="d-flex mb-4" style="max-width: 300px">
                                            <form action="{{ route('cart.update', $item->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <button class="btn btn-primary px-3 me-2" onclick="this.parentNode.querySelector('input[type=number]').stepDown();">
                                                    <i class="fas fa-minus"></i>
                                                </button>

                                                <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" class="form-control d-inline" style="width: 60px; text-align: center;" />

                                                <button class="btn btn-primary px-3 ms-2" onclick="this.parentNode.querySelector('input[type=number]').stepUp();">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </form>
                                        </div>
                                        <!-- rental_price -->
                                        <p class="text-start text-md-center">
                                            <strong>Total: Rs. {{ number_format($item->instrument->rental_price * $item->quantity, 2) }}</strong>
                                        </p>
                                    </div>
                                </div>
                                <hr class="my-4" />
                            @endforeach
                        </div>

                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card mb-4">
                        <div class="card-header py-3">
                            <h5 class="mb-0">Summary</h5>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                    Instruments
                                    <span>Rs. {{ number_format($cartItems->sum(function($item) {
                                        return $item->instrument->rental_price * $item->quantity;
                                    }), 2) }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                    Shipping
                                    <span>Free</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                    <strong>Total Amount</strong>
                                    <strong>Rs. {{ number_format($cartItems->sum(function($item) {
                                        return $item->instrument->rental_price * $item->quantity;
                                    }), 2) }}</strong>
                                </li>
                            </ul>

                            <a href="{{ route('checkout') }}" class="btn btn-primary btn-lg btn-block">Go to Checkout</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
