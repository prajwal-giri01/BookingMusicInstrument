@extends('frontend.Master')

@section('content')
    <div class="container py-5">
        <h2 class="text-black mb-4">Edit Package: {{ $package->name }}</h2>

        <form action="{{ route('custom-packages.update', $package->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label text-black">Package Name</label>
                <input type="text" name="name" class="form-control" value="{{ $package->name }}" required>
            </div>

            <hr class="border-secondary my-4">

            <h4 class="text-black">Update Instruments in this Package</h4>
            <div class="row">
                @foreach($instruments as $instrument)
                    <div class="col-md-4 mb-2">
                        <div class="form-check text-black">
                            <input type="checkbox" name="instrument_ids[]" value="{{ $instrument->id }}"
                                   class="form-check-input instrument-checkbox"
                                   id="instrument_{{ $instrument->id }}"
                                   data-price="{{ $instrument->rental_price }}"
                                {{ $package->items->contains('instrument_id', $instrument->id) ? 'checked' : '' }}>
                            <label class="form-check-label" for="instrument_{{ $instrument->id }}">
                                {{ $instrument->name }} (Rs. {{ number_format($instrument->rental_price, 2) }})
                            </label>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mb-3 mt-4">
                <label class="form-label text-black">Total Price</label>
                <input type="text" id="total_price_display" class="form-control" readonly>
                <input type="hidden" name="price" id="total_price">
            </div>

            <button type="submit" class="btn btn-primary">Update Package</button>
            <a href="{{ route('custom-packages.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>

    <script>
        const checkboxes = document.querySelectorAll('.instrument-checkbox');
        const totalPriceInput = document.getElementById('total_price');
        const totalPriceDisplay = document.getElementById('total_price_display');

        function calculateTotal() {
            let total = 0;
            checkboxes.forEach(cb => {
                if (cb.checked) {
                    total += parseFloat(cb.dataset.price);
                }
            });
            totalPriceInput.value = total.toFixed(2);
            totalPriceDisplay.value = "Rs. " + total.toFixed(2);
        }

        // Initialize on load
        calculateTotal();
        checkboxes.forEach(cb => cb.addEventListener('change', calculateTotal));
    </script>
@endsection
