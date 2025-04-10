@extends('frontend.Master')
@section('content')
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <section class="h-100 gradient-custom">
        <div class="container py-5">
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

                            <!-- Delivery Location Section -->
                            <form action="{{ route('checkout.store') }}" method="POST" class="mt-3">
                                @csrf
                                <div class="form-group mb-3">
                                    <label for="delivery_address">Delivery Address</label>
                                    <input type="text" name="delivery_address" id="delivery_address" class="form-control" placeholder="Enter your address" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="map">Select Delivery Location</label>
                                    <div id="map" style="height: 300px;"></div>
                                </div>
                                <!-- Hidden inputs to store latitude & longitude -->
                                <input type="hidden" name="latitude" id="latitude">
                                <input type="hidden" name="longitude" id="longitude">

                                <button type="submit" class="btn btn-primary btn-lg btn-block mt-3">
                                    Confirm Order
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        // Default location fallback (e.g., center of India)
        var defaultLat = 20.5937, defaultLng = 78.9629;
        var map = L.map('map').setView([defaultLat, defaultLng], 5);

        // Add OpenStreetMap tiles.
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
        }).addTo(map);

        // Create a draggable marker at the default location.
        var marker = L.marker([defaultLat, defaultLng], { draggable: true }).addTo(map);

        // Function to update the hidden inputs.
        function updatePosition(lat, lng) {
            document.getElementById('latitude').value = lat;
            document.getElementById('longitude').value = lng;
        }

        // Update hidden inputs when the marker is dragged.
        marker.on('dragend', function(e) {
            var position = marker.getLatLng();
            updatePosition(position.lat, position.lng);
        });

        // Update hidden inputs when the map is clicked (and move the marker).
        map.on('click', function(e) {
            marker.setLatLng(e.latlng);
            updatePosition(e.latlng.lat, e.latlng.lng);
        });

        // Attempt to get the user's current location.
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                var currentLat = position.coords.latitude;
                var currentLng = position.coords.longitude;
                // Set map view to user's location.
                map.setView([currentLat, currentLng], 13);
                marker.setLatLng([currentLat, currentLng]);
                updatePosition(currentLat, currentLng);
            }, function(error) {
                console.error("Error getting location: ", error);
                // If error occurs, fallback to default location.
                updatePosition(defaultLat, defaultLng);
            });
        } else {
            console.log("Geolocation is not supported by this browser.");
            updatePosition(defaultLat, defaultLng);
        }

        // Set initial hidden inputs to the default position.
        updatePosition(defaultLat, defaultLng);
    </script>

@endsection
