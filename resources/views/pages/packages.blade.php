@extends('frontend.Master')

@section('content')
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="text-white">My Custom Packages</h2>
            <a href="{{ route('custom-packages.create') }}" class="btn btn-success">+ Create New Package</a>
        </div>

        @if($packages->isEmpty())
            <div class="alert alert-info text-center">
                You have not created any packages yet.
            </div>
        @else
            <div class="row">
                @foreach($packages as $package)
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card bg-dark text-white h-100 shadow">
                            <div class="card-body">
                                <h5 class="card-title">{{ $package->name }}</h5>

                                <p class="card-text"><strong>Quantity:</strong> {{ $package->quantity ?? '-' }}</p>
                                <p class="card-text"><strong>Price:</strong> Rs. {{ number_format($package->price, 2) }}</p>

                                <a href="{{ route('custom-packages.edit', $package->id) }}" class="btn btn-outline-light btn-sm">
                                    View & Add Instruments
                                </a>

                                <form action="{{ route('custom-packages.destroy', $package->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Are you sure you want to delete this package?')" class="btn btn-outline-danger btn-sm">
                                        Delete
                                    </button>
                                </form>

                                <!-- Rent Now Form -->
                                <hr class="border-secondary mt-4 mb-2">

                                <form action="{{ route('custom-packages.rent', $package->id) }}" method="POST">
                                    @csrf
                                    <div class="mb-2">
                                        <label class="form-label text-white">Start Date</label>
                                        <input type="date" name="rental_start_date" class="form-control" required>
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label text-white">End Date</label>
                                        <input type="date" name="rental_end_date" class="form-control" required>
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label text-white">Quantity</label>
                                        <input type="number" name="quantity" class="form-control" value="1" min="1" required>
                                    </div>
                                    <button type="submit" class="btn btn-warning btn-sm">Rent Now</button>
                                </form>

                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
