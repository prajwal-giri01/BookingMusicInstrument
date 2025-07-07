@extends('frontend.Master')
@section('content')
    <section class="h-100 gradient-custom">
        <div class="container " style="margin-top: 10rem">
            <div class="row d-flex justify-content-center">
                <!-- Order Details -->
                <div class="col-md-8">
                    <div class="card mb-4">
                        <div class="card-header py-3">
                            <h5 class="mb-0">Checkout - Review Your Order</h5>
                        </div>
                        <div class="card-body">
                            @foreach($cart->items as $item)
                                <div class="row align-items-center mb-4">
                                    <div class="col-lg-3 col-md-12 mb-4 mb-lg-0">
                                        <div class="bg-image hover-overlay hover-zoom ripple rounded">
                                            <img src="{{ asset($item->instrument->image_path) }}" class="w-100" alt="{{ $item->instrument->name }}" />
                                        </div>
                                    </div>
                                    <div class="col-lg-5 col-md-6 mb-4 mb-lg-0">
                                        <p><strong>{{ $item->instrument->name }}</strong></p>
                                        <p>Rental Price: Rs. {{ number_format($item->instrument->rental_price, 2) }}</p>
                                        <p>
                                            Rental Dates:
                                            @if($item->rental_start_date && $item->rental_end_date)
                                                {{ date('M d, Y', strtotime($item->rental_start_date)) }} -
                                                {{ date('M d, Y', strtotime($item->rental_end_date)) }}
                                            @else
                                                <span class="text-danger">Not set</span>
                                            @endif
                                        </p>
                                    </div>
                                    <div class="col-lg-4 col-md-6 mb-4 mb-lg-0 text-end">
                                        <p>Quantity: <strong>{{ $item->quantity }}</strong></p>
                                        <p>Total: Rs. {{ number_format($item->instrument->rental_price * $item->quantity, 2) }}</p>
                                    </div>
                                </div>
                                <hr class="my-4" />
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Order Summary & Delivery Location -->
                <div class="col-md-4">
                    <div class="card mb-4">
                        <div class="card-header py-3">
                            <h5 class="mb-0">Order Summary</h5>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Instruments
                                    <span>
                                        Rs. {{ number_format($cart->items->sum(function($item) {
                                            return $item->instrument->rental_price * $item->quantity;
                                        }), 2) }}
                                    </span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Shipping
                                    <span>Free</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <strong>Total Amount</strong>
                                    <strong>
                                        Rs. {{ number_format($cart->items->sum(function($item) {
                                            return $item->instrument->rental_price * $item->quantity;
                                        }), 2) }}
                                    </strong>
                                </li>
                            </ul>

                            <!-- Delivery Location Form -->
                            <form id="khalti-payment-form">
                                @csrf

                                <div class="form-group mb-3">
                                    <label for="delivery_address">Full Address</label>
                                    <input type="text" name="delivery_address" id="delivery_address" class="form-control" placeholder="E.g. House 101, Near City Mall" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="street">Street</label>
                                    <input type="text" name="street" id="street" class="form-control" placeholder="Street or Tole Name" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="ward">Ward</label>
                                    <input type="text" name="ward" id="ward" class="form-control" placeholder="E.g. Ward 5" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="city">City/Municipality</label>
                                    <input type="text" name="city" id="city" class="form-control" placeholder="E.g. Kathmandu" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="district">District</label>
                                    <input type="text" name="district" id="district" class="form-control" placeholder="E.g. Lalitpur" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="province">Province</label>
                                    <input type="text" name="province" id="province" class="form-control" placeholder="E.g. Bagmati Province" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="postal_code">Postal Code</label>
                                    <input type="text" name="postal_code" id="postal_code" class="form-control" placeholder="E.g. 44600" required>
                                </div>

                                <input type="hidden" name="name" value="Instrument Rental">
                                <input type="hidden" name="amount" value="{{ $item->instrument->rental_price * $item->quantity }}">
                                <input type="hidden" name="user" value="{{ auth()->id() }}">

                                <button type="submit" class="btn btn-success btn-lg btn-block" id="khalti-btn">Pay with Khalti</button>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Khalti Payment Script -->
    <script>
        document.getElementById('khalti-payment-form').addEventListener('submit', function(e) {
            e.preventDefault();
            const form = this;
            const formData = new FormData(form);
            const submitBtn = document.getElementById('khalti-btn');
            submitBtn.disabled = true;
            submitBtn.innerText = "Redirecting...";

            fetch("{{ route('khalti.purchase') }}", {
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': form.querySelector('input[name="_token"]').value
                },
                body: formData
            })
                .then(async res => {
                    const data = await res.json();

                    if (res.ok && data.khalti_url) {
                        window.location.href = data.khalti_url;
                    } else if (data.error) {
                        alert(data.error);  // Show the actual backend error like "Not enough stock"
                        submitBtn.disabled = false;
                        submitBtn.innerText = "Pay with Khalti";
                    } else {
                        alert("Error initiating payment. Please try again.");
                        submitBtn.disabled = false;
                        submitBtn.innerText = "Pay with Khalti";
                    }
                })

        });
    </script>
@endsection

