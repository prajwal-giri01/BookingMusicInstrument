@extends('frontend.Master')

@section('content')
    <div class="container py-5">
        <h2 class="text-black mb-4">Create Custom Package</h2>

        <form action="{{ route('custom-packages.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label text-black">Package Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <div class="mb-4">
                <label class="form-label text-black">Select Instruments</label>
                <div class="row">
                    @foreach($instruments as $instrument)
                        <div class="col-md-4 mb-2">
                            <div class="form-check text-black">
                                <input class="form-check-input instrument-checkbox"
                                       type="checkbox"
                                       name="instrument_ids[]"
                                       value="{{ $instrument->id }}"
                                       id="instrument_{{ $instrument->id }}"
                                       data-price="{{ floatval($instrument->rental_price) }}">
                                <label class="form-check-label" for="instrument_{{ $instrument->id }}">
                                    {{ $instrument->name }} (Rs. {{ number_format($instrument->rental_price, 2) }})
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label text-black">Total Price</label>
                <input type="text" id="total_price_display" class="form-control" readonly>
                <input type="hidden" name="price" id="total_price">
            </div>

            <button type="submit" class="btn btn-primary">Create Package</button>
            <a href="{{ route('custom-packages.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const checkboxes = document.querySelectorAll('.instrument-checkbox');
            const totalPriceInput = document.getElementById('total_price');
            const totalPriceDisplay = document.getElementById('total_price_display');

            function calculateTotal() {
                let total = 0;
                checkboxes.forEach(cb => {
                    if (cb.checked) {
                        const price = parseFloat(cb.dataset.price);
                        if (!isNaN(price)) {
                            total += price;
                        }
                    }
                });
                totalPriceInput.value = total.toFixed(2);
                totalPriceDisplay.value = "Rs. " + total.toFixed(2);
            }

            checkboxes.forEach(cb => cb.addEventListener('change', calculateTotal));

            // Run on load in case any checkboxes are pre-checked
            calculateTotal();
        });
    </script>
@endsection
