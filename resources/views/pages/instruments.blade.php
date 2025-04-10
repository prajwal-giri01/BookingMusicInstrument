@extends('frontend.Master')

@section('content')
    <div class="container py-5">
        <div class="row">
            <!-- Sidebar with filters -->
            <div class="col-md-3">
                <h2 class="mb-4">FILTERS</h2>
                <form action="{{ url('/search') }}" method="GET">
                    <!-- Category Filter Card -->
                    <div class="card shadow-sm border-0 p-3 mb-3">
                        <h4 class="filter-header mb-3">Instrument Categories</h4>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="all" id="all" value="1" {{ request('all') ? 'checked' : '' }}>
                            <label class="form-check-label" for="all">All</label>
                        </div>
                        @foreach($categories as $categoryItem)
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" name="categories[]" value="{{ $categoryItem->id }}" id="category-{{ $categoryItem->id }}"
                                    {{ in_array($categoryItem->id, request()->get('categories', [])) ? 'checked' : '' }}>
                                <label class="form-check-label" for="category-{{ $categoryItem->id }}">{{ $categoryItem->name }}</label>
                            </div>
                        @endforeach
                    </div>

                    <!-- Price Range Filter Card -->
                    <div class="card shadow-sm border-0 p-3 mb-3">
                        <h4 class="filter-header mb-3">Price Range</h4>
                        <div class="mb-2">
                            <label for="min_price" class="form-label">Min Price</label>
                            <input type="number" name="min_price" id="min_price" class="form-control" value="{{ request('min_price') }}">
                        </div>
                        <div class="mb-2">
                            <label for="max_price" class="form-label">Max Price</label>
                            <input type="number" name="max_price" id="max_price" class="form-control" value="{{ request('max_price') }}">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Apply Filters</button>
                </form>
            </div>

            <!-- Main content area -->
            <div class="col-md-9">
                <div class="mb-4 text-center">
                    <h1 class="display-6">{{ $category->name ?? 'All Instruments' }}</h1>
                    <p class="text-muted">{{ $instruments->count() }} items found for "{{ $category->name ?? 'All' }}"</p>
                </div>

                <div class="row row-cols-1 row-cols-md-3 g-4">
                    @forelse($instruments as $item)
                        <div class="col-md-6 col-lg-3">
                            <div class="card h-100 border-0 shadow-sm">
                                <img src="{{ asset($item->image_path) }}" class="card-img-top" alt="{{ $item->name }}">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $item->name }}</h5>
                                    <p class="card-text text-muted">{{ $item->category->name }}</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="text-primary fw-bold">Rs.{{ $item->rental_price }}/day</span>
                                        <a href="{{ route('detail', $item->id) }}" class="btn btn-sm btn-outline-primary">Book Now</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col text-center">No Instrument Found in this Category or within the selected price range.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
