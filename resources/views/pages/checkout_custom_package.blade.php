@extends('frontend.Master')
@section('content')
    <section class="h-100 gradient-custom">
        <div class="container" style="margin-top: 10rem">
            <div class="row d-flex justify-content-center">
                <!-- Order Details -->
                <div class="col-md-8">
                    <div class="card mb-4">
                        <div class="card-header py-3">
                            <h5 class="mb-0">Checkout - Review Your Package</h5>
                        </div>
                        <div class="card-body">
                            <p><strong>Package:</strong> {{ $checkoutData['package_name'] }}</p>
                            <p><strong>Rental Period:</strong> {{ $checkoutData['rental_start_date'] }} to {{ $checkoutData['rental_end_date'] }}</p>
                            <p><strong>Quantity:</strong> {{ $checkoutData['quantity'] }}</p>
                            <hr>
                            <h6>Instruments:</h6>
                            <ul>
                                @foreach($checkoutData['instruments'] as $instrument)
                                    <li>{{ $instrument['name'] }} — Rs. {{ number_format($instrument['price'], 2) }}</li>
                                @endforeach
                            </ul>
                            <hr>
                            <h5>Total Price: Rs. {{ number_format($checkoutData['price'] * $checkoutData['quantity'], 2) }}</h5>
                        </div>
                    </div>
                </div>

                <!-- Delivery Address + Khalti -->
                <div class="col-md-4">
                    <div class="card mb-4">
                        <div class="card-header py-3">
                            <h5 class="mb-0">Delivery Address</h5>
                        </div>
                        <div class="card-body">
                            <form id="khalti-payment-form">
                                @csrf

                                <div class="form-group mb-3">
                                    <label for="delivery_address">Full Address</label>
                                    <input type="text" name="delivery_address" id="delivery_address" class="form-control" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="street">Street</label>
                                    <input type="text" name="street" id="street" class="form-control" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="ward">Ward</label>
                                    <input type="text" name="ward" id="ward" class="form-control" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="city">City/Municipality</label>
                                    <input type="text" name="city" id="city" class="form-control" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="district">District</label>
                                    <input type="text" name="district" id="district" class="form-control" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="province">Province</label>
                                    <input type="text" name="province" id="province" class="form-control" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="postal_code">Postal Code</label>
                                    <input type="text" name="postal_code" id="postal_code" class="form-control" required>
                                </div>

                                <!-- Hidden values for Khalti -->
                                <input type="hidden" name="name" value="{{ $checkoutData['package_name'] }}">
                                <input type="hidden" name="amount" value="{{ $checkoutData['price'] * $checkoutData['quantity'] }}">
                                <input type="hidden" name="user" value="{{ auth()->id() }}">
                                <input type="hidden" name="package_id" value="{{ $checkoutData['package_id'] }}">

                                <button type="submit" class="btn btn-success btn-lg btn-block" id="khalti-btn">Pay with Khalti</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

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
                    } else {
                        alert(data.error || "Payment initiation failed.");
                        submitBtn.disabled = false;
                        submitBtn.innerText = "Pay with Khalti";
                    }
                });
        });
    </script>
@endsection
