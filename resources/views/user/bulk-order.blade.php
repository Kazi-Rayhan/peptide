@extends('frontend.layouts.app')

@section('title', 'Bulk Order - MyShop')

@section('content')
    <div class="container py-5">
        <!-- Page Header -->
        <div class="row mb-4">
            <div class="col-12">
                <h1 class="h3 mb-3">
                    <i class="bi bi-upload"></i> Bulk Order
                </h1>
                <p class="text-muted">Upload a CSV file with your products or manually select items for bulk ordering.</p>
            </div>
        </div>

        <!-- CSV Upload Section -->
        <div class="row mb-4">
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="bi bi-file-earmark-spreadsheet"></i> Upload CSV</h5>
                    </div>
                    <div class="card-body">
                        <form  method="post" action="{{route('bulk-order.parseCsv')}}"  enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="csv_file" class="form-label">Select CSV File</label>
                                <input type="file" class="form-control" id="csv_file" name="csv_file" accept=".csv"
                                    required>
                                <div class="form-text">CSV should contain: SKU, Quantity, Type (retail/wholesale)</div>
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-upload"></i> Upload & Preview
                            </button>
                            <a href="{{ route('bulk-order.downloadExampleCsv') }}" class="btn btn-danger ms-2">
                                <i class="bi bi-download"></i> Download Example CSV
                            </a>
                            <a href="{{ route('bulk-order.downloadProductList') }}" class="btn btn-warning ms-2">
                                <i class="bi bi-download"></i> Download Product List
                            </a>

                        </form>
                        <div id="csv-upload-message" class="mt-3"></div>
                    </div>
                </div>
            </div>
        </div>
        {{-- 
        <!-- Product Preview Table -->
        <div class="row mb-4" id="product-preview-section" style="display:none;">
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="bi bi-bag"></i> Products to Order</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table align-middle mb-0" id="product-preview-table">
                                <thead class="table-light">
                                    <tr>
                                        <th>SKU</th>
                                        <th>Name</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Subtotal</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-end p-3">
                            <h5>Total: $<span id="product-preview-total">0.00</span></h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bulk Order Checkout Form -->
        <div class="row" id="bulk-order-form-section" style="display:none;">
            <div class="col-lg-8">
                <form id="bulk-order-form">
                    @csrf
                    <input type="hidden" name="products" id="products-json">

                    <!-- Billing Information -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="bi bi-person"></i> Billing Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="billing_first_name" class="form-label">First Name *</label>
                                    <input type="text" class="form-control" id="billing_first_name"
                                        name="billing_address[first_name]" required
                                        value="{{ old('billing_address.first_name', $user->first_name ?? '') }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="billing_last_name" class="form-label">Last Name *</label>
                                    <input type="text" class="form-control" id="billing_last_name"
                                        name="billing_address[last_name]" required
                                        value="{{ old('billing_address.last_name', $user->last_name ?? '') }}">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="billing_email" class="form-label">Email Address *</label>
                                <input type="email" class="form-control" id="billing_email" name="billing_address[email]" required
                                    value="{{ old('billing_address.email', $user->email ?? '') }}">
                            </div>
                            <div class="mb-3">
                                <label for="billing_phone" class="form-label">Phone Number *</label>
                                <input type="tel" class="form-control" id="billing_phone" name="billing_address[phone]" required
                                    value="{{ old('billing_address.phone', $user->phone ?? '') }}">
                            </div>
                            <div class="mb-3">
                                <label for="billing_address" class="form-label">Address *</label>
                                <input type="text" class="form-control" id="billing_address" name="billing_address[address]"
                                    required value="{{ old('billing_address.address', $user->address ?? '') }}">
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="billing_city" class="form-label">City *</label>
                                    <input type="text" class="form-control" id="billing_city" name="billing_address[city]"
                                        required value="{{ old('billing_address.city', $user->city ?? '') }}">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="billing_state" class="form-label">State *</label>
                                    <select class="form-select" id="billing_state" name="billing_address[state]" required>
                                        <option value="">Select State</option>
                                        @foreach ($states as $state)
                                            <option value="{{ $state->id }}" data-country="{{ $countries->firstWhere('id', $state->country_id)->iso2 ?? '' }}" {{ old('billing_address.state', $user->state ?? '') == $state->id ? 'selected' : '' }}>{{ $state->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="billing_zip" class="form-label">ZIP Code *</label>
                                    <input type="text" class="form-control" id="billing_zip" name="billing_address[zip]"
                                        required value="{{ old('billing_address.zip', $user->zip ?? '') }}">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="billing_country" class="form-label">Country *</label>
                                <select class="form-select" id="billing_country" name="billing_address[country]" required>
                                    <option value="">Select Country</option>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->iso2 }}" {{ old('billing_address.country', $user->country ?? '') == $country->iso2 ? 'selected' : '' }}>{{ $country->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Shipping Information -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="bi bi-truck"></i> Shipping Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" id="same_as_billing" checked>
                                <label class="form-check-label" for="same_as_billing">
                                    Same as billing address
                                </label>
                            </div>
                            <div id="shipping-fields" style="display: none;">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="shipping_first_name" class="form-label">First Name *</label>
                                        <input type="text" class="form-control" id="shipping_first_name"
                                            name="shipping_address[first_name]">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="shipping_last_name" class="form-label">Last Name *</label>
                                        <input type="text" class="form-control" id="shipping_last_name"
                                            name="shipping_address[last_name]">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="shipping_address" class="form-label">Address *</label>
                                    <input type="text" class="form-control" id="shipping_address"
                                        name="shipping_address[address]">
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="shipping_city" class="form-label">City *</label>
                                        <input type="text" class="form-control" id="shipping_city"
                                            name="shipping_address[city]">
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label for="shipping_state" class="form-label">State *</label>
                                        <select class="form-select" id="shipping_state" name="shipping_address[state]">
                                            <option value="">Select State</option>
                                            @foreach ($states as $state)
                                                <option value="{{ $state->id }}" data-country="{{ $countries->firstWhere('id', $state->country_id)->iso2 ?? '' }}">{{ $state->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label for="shipping_zip" class="form-label">ZIP Code *</label>
                                        <input type="text" class="form-control" id="shipping_zip"
                                            name="shipping_address[zip]">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="shipping_country" class="form-label">Country *</label>
                                    <select class="form-select" id="shipping_country" name="shipping_address[country]">
                                        <option value="">Select Country</option>
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->iso2 }}">{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Information -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="bi bi-credit-card"></i> Payment Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="payment_method" class="form-label">Payment Method *</label>
                                <select class="form-select" id="payment_method" name="payment_method" required>
                                    <option value="">Select Payment Method</option>
                                    @foreach ($paymentMethodsArray as $id => $name)
                                        <option value="{{ $id }}">{{ $name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Stripe Card Element -->
                            <div id="stripe-fields" style="display: none;">
                                <div class="mb-3">
                                    <label for="card-element" class="form-label">Card Information *</label>
                                    <div id="card-element" class="form-control" style="height: 40px; padding: 10px;"></div>
                                    <div id="card-errors" class="invalid-feedback" role="alert"></div>
                                </div>
                                <input type="hidden" id="payment_token" name="payment_token">
                            </div>

                            <!-- Fallback payment fields when Stripe is not available -->
                            <div id="fallback-payment-fields" style="display: none;">
                                <div class="alert alert-warning">
                                    <i class="bi bi-exclamation-triangle"></i>
                                    Payment processing is temporarily unavailable. Please contact support or try again
                                    later.
                                </div>
                            </div>

                            <!-- PayPal Info Placeholder -->
                            <div id="paypal-fields" style="display: none;">
                                <div class="alert alert-info">
                                    <i class="bi bi-info-circle"></i> You will be redirected to PayPal to complete your
                                    payment securely.
                                </div>
                                <div class="text-center">
                                    <img src="https://www.paypalobjects.com/webstatic/en_US/i/buttons/PP_logo_h_100x26.png"
                                        alt="PayPal" class="mb-2">
                                    <p class="text-muted small">PayPal is a secure payment method that allows you to pay
                                        without sharing your financial information.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order Notes -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="bi bi-chat-text"></i> Order Notes</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="notes" class="form-label">Special Instructions</label>
                                <textarea class="form-control" id="notes" name="notes" rows="3"
                                    placeholder="Any special instructions for your bulk order...">{{ old('notes') }}</textarea>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Order Summary -->
            <div class="col-lg-4">
                <div class="card sticky-top" style="top: 20px;">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="bi bi-calculator"></i> Order Summary</h5>
                    </div>
                    <div class="card-body">
                        <!-- Order Items -->
                        <div id="order-items">
                            <div class="text-center text-muted">
                                <i class="bi bi-upload fs-1"></i>
                                <p>Upload a CSV file to see your order items</p>
                            </div>
                        </div>

                        <hr>

                        <!-- Totals -->
                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal:</span>
                            <span id="order-subtotal">$0.00</span>
                        </div>

                        <div class="d-flex justify-content-between mb-2">
                            <span>Tax:</span>
                            <span id="order-tax">$0.00</span>
                        </div>

                        <div class="d-flex justify-content-between mb-2">
                            <span>Shipping:</span>
                            <span id="order-shipping">$0.00</span>
                        </div>

                        <hr>

                        <div class="d-flex justify-content-between mb-3">
                            <strong>Total:</strong>
                            <strong class="price fs-5" id="order-total">$0.00</strong>
                        </div>

                        <!-- Place Order Button -->
                        <div class="d-grid">
                            <button type="submit" class="btn btn-success btn-lg" id="place-order-btn"
                                form="bulk-order-form" disabled>
                                <i class="bi bi-check-circle"></i> Place Bulk Order
                            </button>
                        </div>

                        <small class="text-muted text-center d-block mt-2">
                            By placing your order, you agree to our terms and conditions.
                        </small>
                    </div>
                </div>
            </div>
        </div> --}}
    </div>
@endsection
