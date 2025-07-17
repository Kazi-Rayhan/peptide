@extends('frontend.layouts.app')

@section('title', 'Bulk Order - MyShop')

@section('content')
<div class="container">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="h3 mb-3">
                <i class="fas fa-boxes"></i> Bulk Order (Wholesalers Only)
            </h1>
        </div>
    </div>

    <!-- CSV Upload Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0 fw-bold text-dark">
                        <i class="fas fa-upload me-2 text-primary"></i>
                        Upload Bulk Order CSV
                    </h5>
                </div>
                <div class="card-body">
                    <a href="{{ route('bulk-order.downloadProductList') }}" class="btn btn-primary me-2 mb-2">
                        <i class="fas fa-file-excel me-1"></i> Product List (Excel)
                    </a>
                    <a href="{{ route('bulk-order.downloadExampleCsv') }}" class="btn btn-secondary mb-2">
                        <i class="fas fa-file-csv me-1"></i> Example CSV
                    </a>
                    <form id="csv-upload-form" enctype="multipart/form-data" class="mt-3">
                        @csrf
                        <div class="mb-3">
                            <label for="csv_file" class="form-label">Upload CSV (sku, quantity, type):</label>
                            <input type="file" name="csv_file" id="csv_file" class="form-control" accept=".csv">
                        </div>
                        <button type="submit" class="btn btn-success">Preview Order</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('bulk-order.submit') }}" method="POST" id="bulk-order-form">
        @csrf
        <div class="row">
            <!-- Checkout Form -->
            <div class="col-lg-8 mb-4">
                <!-- Billing Information -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="bi bi-person"></i> Billing Information
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="billing_first_name" class="form-label">First Name *</label>
                                <input type="text" class="form-control" id="billing_first_name" name="billing_address[first_name]" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="billing_last_name" class="form-label">Last Name *</label>
                                <input type="text" class="form-control" id="billing_last_name" name="billing_address[last_name]" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="billing_email" class="form-label">Email Address *</label>
                            <input type="email" class="form-control" id="billing_email" name="billing_address[email]" required>
                        </div>
                        <div class="mb-3">
                            <label for="billing_phone" class="form-label">Phone Number *</label>
                            <input type="tel" class="form-control" id="billing_phone" name="billing_address[phone]" required>
                        </div>
                        <div class="mb-3">
                            <label for="billing_address" class="form-label">Address *</label>
                            <input type="text" class="form-control" id="billing_address" name="billing_address[address]" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="billing_city" class="form-label">City *</label>
                                <input type="text" class="form-control" id="billing_city" name="billing_address[city]" required>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="billing_state" class="form-label">State *</label>
                                <input type="text" class="form-control" id="billing_state" name="billing_address[state]" required>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="billing_zip" class="form-label">ZIP Code *</label>
                                <input type="text" class="form-control" id="billing_zip" name="billing_address[zip]" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="billing_country" class="form-label">Country *</label>
                            <select class="form-select" id="billing_country" name="billing_address[country]" required>
                                <option value="">Select Country</option>
                                <option value="US">United States</option>
                                <option value="CA">Canada</option>
                                <option value="GB">United Kingdom</option>
                                <option value="AU">Australia</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Shipping Information -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="bi bi-truck"></i> Shipping Information
                        </h5>
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
                                    <input type="text" class="form-control" id="shipping_first_name" name="shipping_address[first_name]">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="shipping_last_name" class="form-label">Last Name *</label>
                                    <input type="text" class="form-control" id="shipping_last_name" name="shipping_address[last_name]">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="shipping_address" class="form-label">Address *</label>
                                <input type="text" class="form-control" id="shipping_address" name="shipping_address[address]">
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="shipping_city" class="form-label">City *</label>
                                    <input type="text" class="form-control" id="shipping_city" name="shipping_address[city]">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="shipping_state" class="form-label">State *</label>
                                    <input type="text" class="form-control" id="shipping_state" name="shipping_address[state]">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="shipping_zip" class="form-label">ZIP Code *</label>
                                    <input type="text" class="form-control" id="shipping_zip" name="shipping_address[zip]">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="shipping_country" class="form-label">Country *</label>
                                <select class="form-select" id="shipping_country" name="shipping_address[country]">
                                    <option value="">Select Country</option>
                                    <option value="US">United States</option>
                                    <option value="CA">Canada</option>
                                    <option value="GB">United Kingdom</option>
                                    <option value="AU">Australia</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment Information -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="bi bi-credit-card"></i> Payment Information
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="payment_method" class="form-label">Payment Method *</label>
                            <select class="form-select" id="payment_method" name="payment_method" required>
                                <option value="">Select Payment Method</option>
                                <option value="cod">Cash on Delivery</option>
                                <option value="bank">Bank Transfer</option>
                                <option value="stripe">Credit/Debit Card (Stripe)</option>
                                <option value="paypal">PayPal</option>
                            </select>
                        </div>
                        <div id="stripe-fields" style="display: none;">
                            <div class="mb-3">
                                <label for="card-element" class="form-label">Card Information *</label>
                                <div id="card-element" class="form-control" style="height: 40px; padding: 10px;"></div>
                                <div id="card-errors" class="invalid-feedback" role="alert"></div>
                            </div>
                            <input type="hidden" id="payment_token" name="payment_token">
                        </div>
                        <div id="paypal-fields" style="display: none;">
                            <div class="alert alert-info">
                                <i class="bi bi-info-circle"></i> You will be redirected to PayPal to complete your payment securely.
                            </div>
                            <div class="text-center">
                                <img src="https://www.paypalobjects.com/webstatic/en_US/i/buttons/PP_logo_h_100x26.png" alt="PayPal" class="mb-2">
                                <p class="text-muted small">PayPal is a secure payment method that allows you to pay without sharing your financial information.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Notes -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="bi bi-chat-text"></i> Order Notes
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="notes" class="form-label">Special Instructions</label>
                            <textarea class="form-control" id="notes" name="notes" rows="3" placeholder="Any special instructions for your order..."></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="col-lg-4">
                <div class="card sticky-top" style="top: 20px;">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="bi bi-calculator"></i> Order Summary
                        </h5>
                    </div>
                    <div class="card-body">
                        <!-- Order Items -->
                        <div id="bulk-order-summary-items"></div>
                        <hr>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal:</span>
                            <span id="bulk-order-subtotal">$0.00</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Tax:</span>
                            <span id="bulk-order-tax">$0.00</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Shipping:</span>
                            <span id="bulk-order-shipping">$0.00</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2 text-success">
                            <span>Discount:</span>
                            <span id="bulk-order-discount">$0.00</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-3">
                            <strong>Total:</strong>
                            <strong class="price fs-5" id="bulk-order-total">$0.00</strong>
                        </div>
                        <div class="row">
                            <div class="col-12 text-end">
                                <button type="submit" class="btn btn-primary btn-lg w-100" id="place-order-btn">
                                    <i class="bi bi-check-circle"></i> Place Order
                                </button>
                            </div>
                        </div>
                        <small class="text-muted text-center d-block mt-2">
                            By placing your order, you agree to our terms and conditions.
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<script src="{{ asset('js/bulk-order.js') }}"></script>
@endsection 