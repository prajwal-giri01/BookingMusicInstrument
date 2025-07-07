@extends('frontend.Master')
@section('content')
    <div class="container order-details-container" style="margin-top: 4rem;">
        <div class="order-header">
            <div>
                <h1 class="order-title">Order Details</h1>
                <p class="order-subtitle">Review your rental information below</p>
            </div>
            <div class="order-id-badge">
                <span>Order #{{ $order->id }}</span>
            </div>
        </div>

        <div class="row">
            <!-- Order Information -->
            <div class="col-lg-4 mb-4">
                <div class="info-card">
                    <div class="info-card-header">
                        <h2>Order Summary</h2>
                        <div class="order-date">
                            <i class="bi bi-calendar3"></i> {{ $order->created_at->format('M d, Y') }}
                        </div>
                    </div>

                    <div class="info-card-body">
                        <div class="info-item">
                            <div class="info-label">Payment Status</div>
                            <div class="info-value">
                            <span class="status-badge status-{{ strtolower($order->payment_status) }}">
                                <i class="bi bi-circle-fill"></i>
                                {{ ucfirst($order->payment_status) }}
                            </span>
                            </div>
                        </div>

                        <div class="info-item">
                            <div class="info-label">Rental Status</div>
                            <div class="info-value">
                            <span class="status-badge status-{{ strtolower($order->rental_status) }}">
                                <i class="bi bi-circle-fill"></i>
                                {{ ucfirst($order->rental_status) }}
                            </span>
                            </div>
                        </div>

                        <div class="info-item">
                            <div class="info-label">Transaction ID</div>
                            <div class="info-value">{{ $order->transaction_id ?? 'N/A' }}</div>
                        </div>

                        <div class="info-item">
                            <div class="info-label">Order Time</div>
                            <div class="info-value">{{ $order->created_at->format('h:i A') }}</div>
                        </div>

                        <div class="info-divider"></div>

                        <div class="info-item">
                            <div class="info-label">Delivery Address</div>
                            <div class="info-value address-value">
                                <i class="bi bi-geo-alt"></i>
                                {{ $order->delivery_address }}
                            </div>
                        </div>

                        <div class="info-divider"></div>

                        <div class="info-item total-item">
                            <div class="info-label">Total Rental Cost</div>
                            <div class="info-value total-value">Rs.{{ number_format($order->total_rental_cost, 2) }}</div>
                        </div>
                    </div>
                </div>

                <!-- Only Back Button -->
                <div class="action-buttons">
                    <a href="{{ route('orders.index') }}" class="btn btn-back">
                        <i class="bi bi-arrow-left"></i> Back to Orders
                    </a>
                </div>
            </div>

            <!-- Order Items -->
            <div class="col-lg-8 mb-4">
                <div class="items-card">
                    <div class="items-card-header">
                        <h2>Rented Instruments</h2>
                        <span class="items-count">{{ $order->orderItems->count() }} {{ Str::plural('item', $order->orderItems->count()) }}</span>
                    </div>

                    <div class="items-card-body">
                        @if($order->orderItems->isEmpty())
                            <div class="empty-state">
                                <i class="bi bi-cart-x"></i>
                                <p>No items in this order.</p>
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table order-items-table">
                                    <thead>
                                    <tr>
                                        <th>Instrument</th>
                                        <th>Details</th>
                                        <th>Rental Period</th>
                                        <th>Price</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($order->orderItems as $item)
                                        <tr>
                                            <td class="item-image">
                                                @if(isset($item->instrument->image_path))
                                                    <img src="{{ asset($item->instrument->image_path) }}" alt="{{ $item->instrument->name ?? 'Instrument' }}" class="instrument-image">
                                                @else
                                                    <div class="no-image">
                                                        <i class="bi bi-image"></i>
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="item-details">
                                                <h4>{{ $item->instrument->name ?? 'N/A' }}</h4>
                                                <div class="item-quantity">Quantity: {{ $item->quantity }}</div>
                                            </td>
                                            <td class="item-dates">
                                                <div class="date-range">
                                                    <div class="start-date">
                                                        <div class="date-label">From</div>
                                                        <div class="date-value">{{ \Carbon\Carbon::parse($item->rental_start_date)->format('M d, Y') }}</div>
                                                    </div>
                                                    <div class="date-divider">
                                                        <i class="bi bi-arrow-right"></i>
                                                    </div>
                                                    <div class="end-date">
                                                        <div class="date-label">To</div>
                                                        <div class="date-value">{{ \Carbon\Carbon::parse($item->rental_end_date)->format('M d, Y') }}</div>
                                                    </div>
                                                </div>
                                                <div class="rental-duration">
                                                    {{ \Carbon\Carbon::parse($item->rental_start_date)->diffInDays(\Carbon\Carbon::parse($item->rental_end_date)) + 1 }}
                                                    {{ Str::plural('day', \Carbon\Carbon::parse($item->rental_start_date)->diffInDays(\Carbon\Carbon::parse($item->rental_end_date)) + 1) }}
                                                </div>
                                            </td>
                                            <td class="item-price">
                                                <div class="price-per-unit">Rs.{{ number_format($item->price, 2) }} × {{ $item->quantity }}</div>
                                                <div class="price-subtotal">Rs.{{ number_format($item->price * $item->quantity, 2) }}</div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Order Details Page Styling */
        .order-details-container {
            padding: 3rem 1rem;
            max-width: 1200px;
        }

        /* Order Header */
        .order-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .order-title {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            color: #1A1A2E;
        }

        .order-subtitle {
            color: #666;
            margin-bottom: 0;
        }

        .order-id-badge {
            background-color: #1A1A2E;
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 50px;
            font-weight: 600;
            font-size: 1.1rem;
            box-shadow: 0 4px 12px rgba(26, 26, 46, 0.15);
        }

        /* Info Card */
        .info-card, .items-card {
            background-color: white;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            height: 100%;
        }

        .info-card-header, .items-card-header {
            background-color: #f8f9fa;
            padding: 1.5rem;
            border-bottom: 1px solid #eee;
        }

        .info-card-header h2, .items-card-header h2 {
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            color: #1A1A2E;
        }

        .order-date {
            color: #666;
            font-size: 0.9rem;
        }

        .order-date i {
            margin-right: 0.25rem;
        }

        .info-card-body {
            padding: 1.5rem;
        }

        .info-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 1rem;
        }

        .info-label {
            color: #666;
            font-size: 0.9rem;
        }

        .info-value {
            font-weight: 600;
            color: #333;
            text-align: right;
        }

        .address-value {
            max-width: 200px;
            word-wrap: break-word;
            line-height: 1.4;
        }

        .address-value i, .info-value i {
            margin-right: 0.25rem;
            color: #C7B299;
        }

        .info-divider {
            height: 1px;
            background-color: #eee;
            margin: 1rem 0;
        }

        .total-item {
            margin-top: 0.5rem;
        }

        .total-value {
            font-size: 1.25rem;
            font-weight: 700;
            color: #1A1A2E;
        }

        /* Status Badges */
        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.35rem 0.75rem;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .status-badge i {
            font-size: 0.6rem;
            margin-right: 0.4rem;
        }

        .status-paid {
            background-color: rgba(72, 187, 120, 0.1);
            color: #48bb78;
        }

        .status-pending {
            background-color: rgba(237, 137, 54, 0.1);
            color: #ed8936;
        }

        .status-cancelled {
            background-color: rgba(229, 62, 62, 0.1);
            color: #e53e3e;
        }

        .status-completed {
            background-color: rgba(66, 153, 225, 0.1);
            color: #4299e1;
        }

        .status-active {
            background-color: rgba(72, 187, 120, 0.1);
            color: #48bb78;
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            margin-top: 1.5rem;
        }

        .btn {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .btn i {
            margin-right: 0.5rem;
        }

        .btn-cancel {
            background-color: rgba(229, 62, 62, 0.1);
            color: #e53e3e;
        }

        .btn-cancel:hover {
            background-color: rgba(229, 62, 62, 0.2);
        }

        .btn-back {
            background-color: #f1f1f1;
            color: #333;
            text-decoration: none;
        }

        .btn-back:hover {
            background-color: #e5e5e5;
            color: #1A1A2E;
        }

        /* Items Card */
        .items-card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .items-count {
            background-color: #1A1A2E;
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .items-card-body {
            padding: 0;
        }

        /* Empty State */
        .empty-state {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 3rem;
            color: #666;
        }

        .empty-state i {
            font-size: 3rem;
            margin-bottom: 1rem;
            color: #ddd;
        }

        /* Order Items Table */
        .order-items-table {
            margin-bottom: 0;
        }

        .order-items-table th {
            background-color: #f8f9fa;
            font-weight: 600;
            color: #666;
            padding: 1rem 1.5rem;
            border-bottom: 1px solid #eee;
        }

        .order-items-table td {
            padding: 1.5rem;
            vertical-align: middle;
            border-bottom: 1px solid #eee;
        }

        .order-items-table tr:last-child td {
            border-bottom: none;
        }

        .item-image {
            width: 100px;
        }

        .instrument-image {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .no-image {
            width: 80px;
            height: 80px;
            background-color: #f1f1f1;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #aaa;
            font-size: 1.5rem;
        }

        .item-details h4 {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: #1A1A2E;
        }

        .item-quantity {
            color: #666;
            font-size: 0.9rem;
        }

        .date-range {
            display: flex;
            align-items: center;
            margin-bottom: 0.5rem;
        }

        .start-date, .end-date {
            text-align: center;
        }

        .date-label {
            font-size: 0.8rem;
            color: #666;
            margin-bottom: 0.25rem;
        }

        .date-value {
            font-weight: 600;
            color: #333;
        }

        .date-divider {
            margin: 0 0.75rem;
            color: #C7B299;
        }

        .rental-duration {
            text-align: center;
            font-size: 0.85rem;
            color: #666;
            background-color: #f8f9fa;
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            display: inline-block;
        }

        .price-per-unit {
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 0.25rem;
        }

        .price-subtotal {
            font-weight: 700;
            color: #1A1A2E;
            font-size: 1.1rem;
        }

        /* Responsive Adjustments */
        @media (max-width: 991.98px) {
            .order-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }

            .order-id-badge {
                align-self: flex-start;
            }
        }

        @media (max-width: 767.98px) {
            .order-details-container {
                padding: 2rem 1rem;
            }

            .item-dates {
                min-width: 200px;
            }
        }
    </style>
@endsection
