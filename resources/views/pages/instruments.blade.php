@extends('frontend.Master')

@section('content')

    <div class="instruments-page" style="margin-top: 2rem;">
        <div class="container py-5">
            <!-- Mobile Filter Toggle -->
            <div class="d-lg-none mb-3">
                <button class="btn btn-filter w-100" type="button" data-bs-toggle="collapse" data-bs-target="#filterSidebar" aria-expanded="false" aria-controls="filterSidebar">
                    <i class="bi bi-funnel-fill me-2"></i> Show Filters
                    <span class="filter-count">{{ count(request()->get('categories', [])) + (request('min_price') ? 1 : 0) + (request('max_price') ? 1 : 0) }}</span>
                </button>
            </div>

            <div class="row">
                <!-- Sidebar with filters -->
                <div class="col-lg-3 mb-4">
                    <div class="filter-sidebar collapse d-lg-block" id="filterSidebar">
                        <div class="filter-header">
                            <h2>Filters</h2>
                            @if(request()->has('categories') || request('min_price') || request('max_price'))
                                <a href="{{ url()->current() }}" class="clear-filters">Clear All</a>
                            @endif
                        </div>

                        <form action="{{ url('/search') }}" method="GET" id="filterForm">
                            <!-- Category Filter Card -->
                            <div class="filter-card">
                                <h4 class="filter-card-title">
                                    <span>Instrument Categories</span>
                                    <i class="bi bi-chevron-down"></i>
                                </h4>
                                <div class="filter-card-body">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="all" id="all" value="1"
                                               {{ request('all') ? 'checked' : '' }} onchange="document.getElementById('filterForm').submit()">
                                        <label class="form-check-label" for="all">All Categories</label>
                                    </div>
                                    <div class="category-list">
                                        @foreach($categories as $categoryItem)
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="categories[]"
                                                       value="{{ $categoryItem->id }}" id="category-{{ $categoryItem->id }}"
                                                       {{ in_array($categoryItem->id, request()->get('categories', [])) ? 'checked' : '' }}
                                                       onchange="document.getElementById('filterForm').submit()">
                                                <label class="form-check-label" for="category-{{ $categoryItem->id }}">
                                                    {{ $categoryItem->name }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <!-- Price Range Filter Card -->
                            <div class="filter-card">
                                <h4 class="filter-card-title">
                                    <span>Price Range</span>
                                    <i class="bi bi-chevron-down"></i>
                                </h4>
                                <div class="filter-card-body">
                                    <div class="price-inputs">
                                        <div class="price-input">
                                            <label for="min_price">Min Price</label>
                                            <div class="input-with-icon">
                                                <span class="currency-symbol">Rs.</span>
                                                <input type="number" name="min_price" id="min_price"
                                                       class="form-control" value="{{ request('min_price') }}"
                                                       placeholder="0">
                                            </div>
                                        </div>
                                        <div class="price-divider">-</div>
                                        <div class="price-input">
                                            <label for="max_price">Max Price</label>
                                            <div class="input-with-icon">
                                                <span class="currency-symbol">Rs.</span>
                                                <input type="number" name="max_price" id="max_price"
                                                       class="form-control" value="{{ request('max_price') }}"
                                                       placeholder="Any">
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-apply-price mt-3">Apply Price</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Main content area -->
                <div class="col-lg-9">
                    <div class="instruments-header">
                        <div>
                            <h1>{{ $category->name ?? 'All Instruments' }}</h1>
                            <p class="results-count">
                                <span>{{ $instruments->count() }}</span> instruments found
                                @if(request()->has('categories') || request('min_price') || request('max_price'))
                                    <span class="filtered-text">• Filtered Results</span>
                                @endif
                            </p>
                        </div>
                    </div>

                    @if($instruments->isEmpty())
                        <div class="empty-state">
                            <div class="empty-state-icon">
                                <i class="bi bi-search"></i>
                            </div>
                            <h3>No Instruments Found</h3>
                            <p>We couldn't find any instruments matching your criteria.</p>
                            <a href="{{ url()->current() }}" class="btn btn-reset-search">Reset Filters</a>
                        </div>
                    @else
                        <div class="instruments-grid" id="instrumentsContainer">
                            @foreach($instruments as $item)
                                <div class="instrument-card {{ $item->stock_quantity <= 0 ? 'out-of-stock' : '' }}">
                                    <div class="instrument-image position-relative">
                                        <img src="{{ asset($item->image_path) }}" alt="{{ $item->name }}">

                                        @if($item->stock_quantity <= 0)
                                            <div class="stock-badge">Out of Stock</div>
                                        @else
                                            <div class="instrument-actions">
                                                <a href="{{ route('detail', $item->id) }}" class="btn-quick-view">
                                                    <i class="bi bi-eye"></i>
                                                    <span>Quick View</span>
                                                </a>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="instrument-info">
                                        <div class="instrument-category">{{ $item->category->name }}</div>
                                        <h3 class="instrument-name">{{ $item->name }}</h3>
                                        <div class="instrument-price">
                                            <span class="price-value">Rs.{{ $item->rental_price }}</span>
                                            <span class="price-period">/day</span>
                                        </div>

                                        @if($item->stock_quantity > 0)
                                            <a href="{{ route('detail', $item->id) }}" class="btn btn-book">Add To Cart</a>
                                        @else
                                            <button class="btn btn-secondary" disabled>Out of Stock</button>
                                        @endif
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>



    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle between grid and list view
            const viewButtons = document.querySelectorAll('.btn-view');
            const instrumentsContainer = document.getElementById('instrumentsContainer');

            viewButtons.forEach(button => {
                button.addEventListener('click', function() {
                    viewButtons.forEach(btn => btn.classList.remove('active'));
                    this.classList.add('active');

                    const viewType = this.getAttribute('data-view');
                    if (viewType === 'list') {
                        instrumentsContainer.classList.add('list-view');
                    } else {
                        instrumentsContainer.classList.remove('list-view');
                    }
                });
            });

            // Auto-submit form when "All" checkbox changes
            const allCheckbox = document.getElementById('all');
            if (allCheckbox) {
                allCheckbox.addEventListener('change', function() {
                    if (this.checked) {
                        // Uncheck all category checkboxes
                        const categoryCheckboxes = document.querySelectorAll('input[name="categories[]"]');
                        categoryCheckboxes.forEach(checkbox => {
                            checkbox.checked = false;
                        });
                    }
                });
            }

            // Close filter sidebar when clicking outside on mobile
            const filterSidebar = document.querySelector('.filter-sidebar');
            if (filterSidebar) {
                document.addEventListener('click', function(event) {
                    const isClickInside = filterSidebar.contains(event.target);
                    const isClickOnToggle = event.target.closest('.btn-filter');

                    if (!isClickInside && !isClickOnToggle && window.innerWidth < 992 && filterSidebar.classList.contains('show')) {
                        // Using Bootstrap's collapse API
                        bootstrap.Collapse.getInstance(filterSidebar).hide();
                    }
                });
            }
        });
    </script>
@endsection
