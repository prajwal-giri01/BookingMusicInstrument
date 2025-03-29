@extends('frontend.Master')

@section('content')
    <div class="container py-5">
        <div class="row">
            <!-- Sidebar with filters -->
            <div class="col-md-3">
                <h2 class="mb-4">FILTERS</h2>
                <div class="card shadow-sm border-0 p-3">
                    <h4 class="filter-header mb-3">DRINKS CATEGORIES</h4>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" id="all">
                        <label class="form-check-label" for="all">All</label>
                    </div>
                    @foreach($categories as $categoryItem)
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" id="category-{{$categoryItem->id}}"
                                {{ $categoryItem->id == $category->id ? 'checked' : '' }}>
                            <label class="form-check-label" for="category-{{$categoryItem->id}}">{{$categoryItem->name}}</label>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Main content area -->
            <div class="col-md-9">
                <div class="mb-4 text-center">
                    <h1 class="display-6">{{$category->name}}</h1>
                    <p class="text-muted">{{ $drinks->count() }} items found for "{{$category->name}}"</p>
                </div>

                <div class="row row-cols-1 row-cols-md-3 g-4">
                    @forelse($drinks as $drink)
                        <div class="col">
                            <div class="card h-100 shadow-sm border-0">
                                <div class="product-image position-relative" style="height: 250px; overflow: hidden;">
                                    <img src="{{ asset($drink->image_path) }}" class="card-img-top" alt="{{ $drink->name }}" style="object-fit: cover; transition: transform 0.3s;">
                                </div>
                                <div class="card-body text-center">
                                    <div class="rating mb-2">
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if($i <= $drink->rating)
                                                <i class="fas fa-star text-warning"></i>
                                            @else
                                                <i class="far fa-star text-muted"></i>
                                            @endif
                                        @endfor
                                    </div>
                                    <h4 class="card-title">{{ $drink->name }}</h4>
                                    <p class="card-text fw-bold">Rs. {{ number_format($drink->price, 2) }}</p>
                                    <div class="stock-status mb-2">
                                        <span class="badge bg-success">{{ $drink->in_stock ? 'In Stock' : 'Out of Stock' }}</span>
                                    </div>
                                    <form action="{{ route('cart.add', ['id' => $drink->id]) }}" method="POST" class="d-inline">
                                        @csrf
                                        <div class="mb-2">
                                            <label for="rental_start_date_{{ $drink->id }}" class="form-label">Rental Start Date:</label>
                                            <input type="date" id="rental_start_date_{{ $drink->id }}" name="rental_start_date" class="form-control" required>
                                        </div>
                                        <div class="mb-2">
                                            <label for="rental_end_date_{{ $drink->id }}" class="form-label">Rental End Date:</label>
                                            <input type="date" id="rental_end_date_{{ $drink->id }}" name="rental_end_date" class="form-control" required>
                                        </div>
                                        <button type="submit" class="btn btn-outline-primary mt-2">Add to Cart</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col text-center">No Instrument Found In This Category.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
