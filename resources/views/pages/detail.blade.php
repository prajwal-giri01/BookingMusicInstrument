@extends('frontend.Master')

@section('content')
    <div class="container py-5 mt-4">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="#">{{ $instrument->category->name }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $instrument->name }}</li>
            </ol>
        </nav>

        <!-- Instrument Details -->
        <div class="row g-5">
            <!-- Instrument Images -->
            <div class="col-lg-6">
                <div class="instrument-gallery">
                    <div class="main-image-container mb-3 rounded-4 overflow-hidden shadow-sm">
                        <img src="{{ asset($instrument->image_path) }}" alt="{{ $instrument->name }}" class="img-fluid w-100" id="mainImage" style="height: 400px; object-fit: contain;">
                    </div>
                </div>
            </div>

            <!-- Instrument Info and Booking -->
            <div class="col-lg-6">
                <div class="instrument-details">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h1 class="mb-0">{{ $instrument->name }}</h1>
                        <span class="badge bg-success rounded-pill px-3 py-2">Available</span>
                    </div>

                    <div class="pricing mb-4">
                        <h3 class="text-primary fw-bold">Rs.{{ number_format($instrument->rental_price, 2) }} <span class="fs-6 text-muted fw-normal">/ day</span></h3>
                    </div>

                    <div class="description mb-4">
                        <h5 class="fw-bold">Description</h5>
                        <p>{{ $instrument->description }}</p>
                    </div>

                    <!-- Booking Form -->
                    <div class="booking-form p-4 rounded-4 bg-light">
                        <h5 class="fw-bold mb-3">Book This Instrument</h5>
                        <form action="{{route('cart.add', $instrument->id )}}" method="POST" id="bookingForm">
                            @csrf
                            <input type="hidden" name="instrument_id" value="{{ $instrument->id }}">

                            <!-- Date Range Picker -->
                            <div class="mb-3">
                                <label class="form-label fw-bold">Select Rental Period</label>
                                <div class="date-range-picker-container">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text bg-primary text-white"><i class="bi bi-calendar-range"></i></span>
                                        <input type="text" class="form-control" id="dateRangeDisplay" placeholder="Select start and end dates" readonly>
                                        <button class="btn btn-outline-secondary" type="button" id="datePickerToggle">
                                            <i class="bi bi-calendar"></i>
                                        </button>
                                    </div>

                                    <div class="date-picker-dropdown shadow rounded-3 bg-white p-3" id="datePickerDropdown" style="  display: block;">
                                        <div class="row">

                                            <!-- Calendar Column -->
                                            <div class="col-md-9">
                                                <div class="calendars-container">
                                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                                        <button type="button" class="btn btn-sm btn-link text-decoration-none" id="prevMonth">
                                                            <i class="bi bi-chevron-left"></i>
                                                        </button>
                                                        <div class="months-display d-flex justify-content-around w-100">
                                                            <div class="month-name" id="leftMonthDisplay"></div>
                                                            <div class="month-name" id="rightMonthDisplay"></div>
                                                        </div>
                                                        <button type="button" class="btn btn-sm btn-link text-decoration-none" id="nextMonth">
                                                            <i class="bi bi-chevron-right"></i>
                                                        </button>
                                                    </div>

                                                    <div class="calendars d-flex">
                                                        <div class="calendar-month me-3" id="leftCalendar"></div>
                                                        <div class="calendar-month" id="rightCalendar"></div>
                                                    </div>
                                                </div>

                                                <div class="d-flex justify-content-end mt-3">
                                                    <button type="button" class="btn btn-outline-secondary me-2" id="resetDates">Reset</button>
                                                    <button type="button" class="btn btn-primary" id="applyDates">Apply</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Selected Dates Display -->
                            <div class="selected-dates p-3 rounded bg-white mb-4">
                                <div class="row g-3">
                                    <div class="col-6">
                                        <label for="start_date_display" class="form-label">Start Date</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-primary text-white"><i class="bi bi-calendar-check"></i></span>
                                            <input type="text" class="form-control" id="start_date_display" readonly>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <label for="end_date_display" class="form-label">End Date</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-primary text-white"><i class="bi bi-calendar-check"></i></span>
                                            <input type="text" class="form-control" id="end_date_display" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Hidden fields for actual date values -->
                            <input type="hidden" id="start_date" name="start_date">
                            <input type="hidden" id="end_date" name="end_date">
                            <input type="hidden" id="total_days" name="total_days">

                            <!-- Booking Summary -->
                            <div class="booking-summary p-3 rounded bg-white mb-4">
                                <h6 class="fw-bold mb-3">Booking Summary</h6>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Base Rental (Daily Rate)</span>
                                    <span>Rs.{{ number_format($instrument->rental_price, 2) }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Rental Duration</span>
                                    <span id="duration">0 days</span>
                                </div>
                                <hr>
                                <div class="d-flex justify-content-between fw-bold">
                                    <span>Total</span>
                                    <span id="totalPrice">Rs.0.00</span>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 py-3 rounded-pill" id="bookNowBtn" disabled>
                                <i class="bi bi-calendar-check me-2"></i> Book Now
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Features -->
        <div class="features-section my-5">
            <h3 class="fw-bold mb-4">Why Rent With Us</h3>
            <div class="row g-4">
                <div class="col-md-3">
                    <div class="feature-card p-4 rounded-4 shadow-sm text-center h-100">
                        <div class="icon-circle bg-primary-subtle text-primary mx-auto mb-3 d-flex align-items-center justify-content-center">
                            <i class="bi bi-shield-check fs-3"></i>
                        </div>
                        <h5 class="fw-bold">Quality Guarantee</h5>
                        <p class="text-muted mb-0">All instruments are professionally maintained and in excellent condition</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="feature-card p-4 rounded-4 shadow-sm text-center h-100">
                        <div class="icon-circle bg-primary-subtle text-primary mx-auto mb-3 d-flex align-items-center justify-content-center">
                            <i class="bi bi-truck fs-3"></i>
                        </div>
                        <h5 class="fw-bold">Free Delivery</h5>
                        <p class="text-muted mb-0">Free delivery and pickup for rentals over $100</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="feature-card p-4 rounded-4 shadow-sm text-center h-100">
                        <div class="icon-circle bg-primary-subtle text-primary mx-auto mb-3 d-flex align-items-center justify-content-center">
                            <i class="bi bi-arrow-repeat fs-3"></i>
                        </div>
                        <h5 class="fw-bold">Flexible Returns</h5>
                        <p class="text-muted mb-0">Easy extension or early return options available</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="feature-card p-4 rounded-4 shadow-sm text-center h-100">
                        <div class="icon-circle bg-primary-subtle text-primary mx-auto mb-3 d-flex align-items-center justify-content-center">
                            <i class="bi bi-headset fs-3"></i>
                        </div>
                        <h5 class="fw-bold">24/7 Support</h5>
                        <p class="text-muted mb-0">Our team is always available to assist with any questions</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Instruments -->
        <div class="related-instruments my-5">
            <h3 class="fw-bold mb-4">You May Also Like</h3>
            <div class="row g-4">
                @foreach($relatedInstruments as $related)
                    <div class="col-md-6 col-lg-3">
                        <div class="card h-100 rounded-4 border-0 shadow-sm hover-lift overflow-hidden">
                            <img src="{{ asset('storage/'.$related->image_path) }}" class="card-img-top" alt="{{ $related->name }}" style="height: 200px; object-fit: cover;">
                            <div class="card-body">
                                <h5 class="card-title fw-bold">{{ $related->name }}</h5>
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <div class="rating text-warning">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $related->rating)
                                                <i class="bi bi-star-fill"></i>
                                            @elseif($i - 0.5 <= $related->rating)
                                                <i class="bi bi-star-half"></i>
                                            @else
                                                <i class="bi bi-star"></i>
                                            @endif
                                        @endfor
                                    </div>
                                    <span class="badge bg-{{ $related->in_stock ? 'success' : 'danger' }}">
                                        {{ $related->in_stock ? 'Available' : 'Unavailable' }}
                                    </span>
                                </div>
                                <p class="text-primary fw-bold mb-3">Rs.{{ number_format($related->daily_rate, 2) }} / day</p>
                                <a href="#" class="btn btn-outline-primary w-100">View Details</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>


        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
        <style>
            :root {
                --primary: #4a6cf7;
                --primary-dark: #2b3cf7;
                --primary-light: #eef2ff;
            }

            /* General Styles */
            body {
                font-family: 'Inter', sans-serif;
            }

            .bg-primary {
                background-color: var(--primary) !important;
            }

            .bg-primary-subtle {
                background-color: var(--primary-light) !important;
            }

            .text-primary {
                color: var(--primary) !important;
            }

            .btn-primary {
                background-color: var(--primary);
                border-color: var(--primary);
            }

            .btn-primary:hover {
                background-color: var(--primary-dark);
                border-color: var(--primary-dark);
            }

            /* Hover Effects */
            .hover-lift {
                transition: transform 0.3s ease, box-shadow 0.3s ease;
            }

            .hover-lift:hover {
                transform: translateY(-5px);
                box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
            }

            /* Icon Circles */
            .icon-circle {
                width: 60px;
                height: 60px;
                border-radius: 50%;
            }

            /* Date Picker Dropdown */
            .date-range-picker-container {
                position: relative;
                z-index: 1050; /* Higher than Bootstrap's modal */
            }


            .date-picker-dropdown {
                position: absolute;
                top: 100%;
                left: 0;
                right: 0;
                z-index: 1000;
                max-width: 700px;
                border: 1px solid #dee2e6;
            }

            /* Calendar Styling */
            .calendar-month {
                width: 100%;
            }

            .calendar-month table {
                width: 100%;
                border-collapse: collapse;
            }

            .calendar-month th {
                text-align: center;
                padding: 8px;
                font-size: 0.8rem;
                font-weight: 500;
                color: #6c757d;
            }

            .calendar-month td {
                text-align: center;
                padding: 8px;
                font-size: 0.9rem;
                cursor: pointer;
                border-radius: 50%;
                width: 40px;
                height: 40px;
            }

            .calendar-month td:hover:not(.disabled):not(.selected-start):not(.selected-end):not(.in-range) {
                background-color: var(--primary-light);
            }

            .calendar-month td.disabled {
                color: #dee2e6;
                cursor: not-allowed;
            }

            .calendar-month td.today {
                border: 1px solid var(--primary);
            }

            .calendar-month td.selected-start,
            .calendar-month td.selected-end {
                background-color: var(--primary);
                color: white;
            }

            .calendar-month td.in-range {
                background-color: var(--primary-light);
                color: var(--primary-dark);
            }


            /* Month Display */
            .month-name {
                font-weight: 500;
                font-size: 1rem;
            }
        </style>


        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // DOM Elements
                const datePickerToggle = document.getElementById('datePickerToggle');
                const datePickerDropdown = document.getElementById('datePickerDropdown');
                const dateRangeDisplay = document.getElementById('dateRangeDisplay');
                const startDateDisplay = document.getElementById('start_date_display');
                const endDateDisplay = document.getElementById('end_date_display');
                const startDateInput = document.getElementById('start_date');
                const endDateInput = document.getElementById('end_date');
                const totalDaysInput = document.getElementById('total_days');
                const durationDisplay = document.getElementById('duration');
                const totalPriceDisplay = document.getElementById('totalPrice');
                const bookNowBtn = document.getElementById('bookNowBtn');
                const leftCalendar = document.getElementById('leftCalendar');
                const rightCalendar = document.getElementById('rightCalendar');
                const leftMonthDisplay = document.getElementById('leftMonthDisplay');
                const rightMonthDisplay = document.getElementById('rightMonthDisplay');
                const prevMonthBtn = document.getElementById('prevMonth');
                const nextMonthBtn = document.getElementById('nextMonth');
                const resetDatesBtn = document.getElementById('resetDates');
                const applyDatesBtn = document.getElementById('applyDates');
                const presetBtns = document.querySelectorAll('.preset-btn');

                // Variables
                const dailyRate = {{ $instrument->rental_price ?? 0 }};
                let currentDate = new Date();
                let currentLeftMonth = new Date(currentDate.getFullYear(), currentDate.getMonth());
                let currentRightMonth = new Date(currentDate.getFullYear(), currentDate.getMonth() + 1);
                let startDate = null;
                let endDate = null;
                let selectedDates = [];

                // Toggle date picker dropdown
                datePickerToggle.addEventListener('click', function() {
                    if (datePickerDropdown.style.display === 'none' || datePickerDropdown.style.display === '') {
                        datePickerDropdown.style.display = 'block';
                    } else {
                        datePickerDropdown.style.display = 'none';
                    }
                });


                // Close dropdown when clicking outside
                document.addEventListener('click', function(event) {
                    if (!datePickerDropdown.contains(event.target) &&
                        event.target !== datePickerToggle &&
                        event.target !== dateRangeDisplay) {
                        datePickerDropdown.style.display = 'block';
                    }
                });

                // Initialize calendars
                initCalendars();

                // Previous month button
                prevMonthBtn.addEventListener('click', function() {
                    currentLeftMonth.setMonth(currentLeftMonth.getMonth() - 1);
                    currentRightMonth.setMonth(currentRightMonth.getMonth() - 1);
                    renderCalendars();
                });

                // Next month button
                nextMonthBtn.addEventListener('click', function() {
                    currentLeftMonth.setMonth(currentLeftMonth.getMonth() + 1);
                    currentRightMonth.setMonth(currentRightMonth.getMonth() + 1);
                    renderCalendars();
                });

                // Reset dates button
                resetDatesBtn.addEventListener('click', function() {
                    startDate = null;
                    endDate = null;
                    selectedDates = [];
                    renderCalendars();
                    updateDisplays();
                });

                // Apply dates button
                applyDatesBtn.addEventListener('click', function() {
                    if (startDate && endDate) {
                        updateDisplays();
                        datePickerDropdown.style.display = 'block';
                    }
                });

                // Preset buttons
                presetBtns.forEach(btn => {
                    btn.addEventListener('click', function() {
                        const preset = this.dataset.preset;
                        setPresetDates(preset);

                        // Update active state
                        presetBtns.forEach(b => b.classList.remove('active'));
                        this.classList.add('active');
                    });
                });

                // Initialize calendars
                function initCalendars() {
                    renderCalendars();
                }

                // Render both calendars
                function renderCalendars() {
                    renderCalendar(leftCalendar, currentLeftMonth);
                    renderCalendar(rightCalendar, currentRightMonth);

                    // Update month displays
                    leftMonthDisplay.textContent = formatMonth(currentLeftMonth);
                    rightMonthDisplay.textContent = formatMonth(currentRightMonth);
                }

                // Render a single calendar
                function renderCalendar(calendarElement, month) {
                    const today = new Date();
                    today.setHours(0, 0, 0, 0);

                    const firstDay = new Date(month.getFullYear(), month.getMonth(), 1);
                    const lastDay = new Date(month.getFullYear(), month.getMonth() + 1, 0);

                    let html = '<table class="calendar-table">';

                    // Header row with day names
                    html += '<thead><tr>';
                    ['M', 'T', 'W', 'T', 'F', 'S', 'S'].forEach(day => {
                        html += `<th>${day}</th>`;
                    });
                    html += '</tr></thead>';

                    // Start calendar body
                    html += '<tbody><tr>';

                    // Fill in empty cells for days before the first day of the month
                    let dayOfWeek = firstDay.getDay() || 7; // Convert Sunday (0) to 7
                    for (let i = 1; i < dayOfWeek; i++) {
                        html += '<td></td>';
                    }

                    // Fill in the days of the month
                    for (let day = 1; day <= lastDay.getDate(); day++) {
                        const date = new Date(month.getFullYear(), month.getMonth(), day);
                        date.setHours(0, 0, 0, 0);

                        const isDisabled = date < today;
                        const isToday = date.getTime() === today.getTime();
                        const isSelectedStart = startDate && date.getTime() === startDate.getTime();
                        const isSelectedEnd = endDate && date.getTime() === endDate.getTime();
                        const isInRange = startDate && endDate &&
                            date > startDate && date < endDate;

                        let classes = [];
                        if (isDisabled) classes.push('disabled');
                        if (isToday) classes.push('today');
                        if (isSelectedStart) classes.push('selected-start');
                        if (isSelectedEnd) classes.push('selected-end');
                        if (isInRange) classes.push('in-range');

                        html += `<td class="${classes.join(' ')}"
                                    data-date="${formatDateValue(date)}"
                                    ${isDisabled ? 'disabled' : ''}>${day}</td>`;

                        // Start a new row if it's the last day of the week
                        if (date.getDay() === 0) {
                            html += '</tr><tr>';
                        }
                    }

                    // Fill in empty cells for days after the last day of the month
                    let lastDayOfWeek = lastDay.getDay() || 7;
                    for (let i = lastDayOfWeek; i < 7; i++) {
                        html += '<td></td>';
                    }

                    html += '</tr></tbody></table>';

                    calendarElement.innerHTML = html;

                    // Add event listeners to date cells
                    calendarElement.querySelectorAll('td[data-date]').forEach(cell => {
                        if (!cell.hasAttribute('disabled')) {
                            cell.addEventListener('click', function() {
                                const dateValue = this.dataset.date;
                                const date = parseDate(dateValue);
                                selectDate(date);
                            });
                        }
                    });
                }

                // Select a date
                function selectDate(date) {
                    if (!startDate || (startDate && endDate) || date < startDate) {
                        // Start a new selection
                        startDate = date;
                        endDate = null;
                    } else {
                        // Complete the selection
                        endDate = date;
                    }

                    renderCalendars();

                    if (startDate && endDate) {
                        calculateDuration();
                    }
                }

                // Set preset dates
                function setPresetDates(preset) {
                    const today = new Date();
                    today.setHours(0, 0, 0, 0);

                    switch (preset) {
                        case 'current-week':
                            // Start of current week (Monday)
                            startDate = new Date(today);
                            const dayOfWeek = today.getDay() || 7;
                            startDate.setDate(today.getDate() - dayOfWeek + 1);

                            // End of current week (Sunday)
                            endDate = new Date(startDate);
                            endDate.setDate(startDate.getDate() + 6);
                            break;

                        case 'next-week':
                            // Start of next week (next Monday)
                            startDate = new Date(today);
                            const nextMonday = today.getDay() === 1 ? 7 : (8 - today.getDay());
                            startDate.setDate(today.getDate() + nextMonday);

                            // End of next week (next Sunday)
                            endDate = new Date(startDate);
                            endDate.setDate(startDate.getDate() + 6);
                            break;

                        case 'current-month':
                            // First day of current month
                            startDate = new Date(today.getFullYear(), today.getMonth(), 1);

                            // Last day of current month
                            endDate = new Date(today.getFullYear(), today.getMonth() + 1, 0);
                            break;

                        case 'next-month':
                            // First day of next month
                            startDate = new Date(today.getFullYear(), today.getMonth() + 1, 1);

                            // Last day of next month
                            endDate = new Date(today.getFullYear(), today.getMonth() + 2, 0);
                            break;

                        case 'custom':
                            // Reset selection for custom range
                            startDate = null;
                            endDate = null;
                            break;
                    }

                    // Ensure we're showing the correct months
                    if (startDate) {
                        currentLeftMonth = new Date(startDate.getFullYear(), startDate.getMonth());
                        currentRightMonth = new Date(startDate.getFullYear(), startDate.getMonth() + 1);
                    }

                    renderCalendars();

                    if (startDate && endDate) {
                        calculateDuration();
                    }
                }

                // Calculate duration between selected dates
                function calculateDuration() {
                    if (startDate && endDate) {
                        const diffTime = Math.abs(endDate - startDate);
                        const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1; // Include both start and end days

                        totalDaysInput.value = diffDays;

                        // Update displays
                        durationDisplay.textContent = diffDays + (diffDays === 1 ? ' day' : ' days');
                        totalPriceDisplay.textContent = 'Rs.' + (dailyRate * diffDays).toFixed(2);

                        // Enable book now button
                        bookNowBtn.disabled = false;
                    } else {
                        totalDaysInput.value = 0;
                        durationDisplay.textContent = '0 days';
                        totalPriceDisplay.textContent = 'Rs.0.00';
                        bookNowBtn.disabled = true;
                    }
                }

                // Update all displays with selected dates
                function updateDisplays() {
                    if (startDate && endDate) {
                        startDateInput.value = formatDateValue(startDate);
                        endDateInput.value = formatDateValue(endDate);
                        startDateDisplay.value = formatDateForDisplay(startDate);
                        endDateDisplay.value = formatDateForDisplay(endDate);
                        dateRangeDisplay.value = `${formatDateForDisplay(startDate)} - ${formatDateForDisplay(endDate)}`;
                        calculateDuration();
                    } else {
                        startDateInput.value = '';
                        endDateInput.value = '';
                        startDateDisplay.value = '';
                        endDateDisplay.value = '';
                        dateRangeDisplay.value = 'Select start and end dates';
                        calculateDuration();
                    }
                }

                // Helper function to format date as YYYY-MM-DD
                function formatDateValue(date) {
                    const year = date.getFullYear();
                    const month = String(date.getMonth() + 1).padStart(2, '0');
                    const day = String(date.getDate()).padStart(2, '0');
                    return `${year}-${month}-${day}`;
                }

                // Helper function to format date for display
                function formatDateForDisplay(date) {
                    const options = { weekday: 'short', month: 'short', day: 'numeric' };
                    return date.toLocaleDateString('en-US', options);
                }

                // Helper function to format month display
                function formatMonth(date) {
                    const options = { month: 'long', year: 'numeric' };
                    return date.toLocaleDateString('en-US', options);
                }

                // Helper function to parse date string
                function parseDate(dateString) {
                    const [year, month, day] = dateString.split('-').map(Number);
                    return new Date(year, month - 1, day);
                }

                // Image Gallery
                function changeMainImage(src, element) {
                    document.getElementById('mainImage').src = src;

                    // Update active state
                    document.querySelectorAll('.thumbnail-container').forEach(thumb => {
                        thumb.classList.remove('active');
                    });
                    element.classList.add('active');
                }
            });
        </script>

@endsection
