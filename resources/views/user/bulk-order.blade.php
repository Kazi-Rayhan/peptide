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
                    <form id="csv-upload-form" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="csv_file" class="form-label">Select CSV File</label>
                            <input type="file" class="form-control" id="csv_file" name="csv_file" accept=".csv" required>
                            <div class="form-text">CSV should contain: SKU, Quantity, Type (retail/wholesale)</div>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-upload"></i> Upload & Preview
                        </button>
                        <a href="{{ route('bulk-order.downloadExampleCsv') }}" class="btn btn-outline-secondary ms-2">
                            <i class="bi bi-download"></i> Download Example CSV
                        </a>
                    </form>
                    <div id="csv-upload-message" class="mt-3"></div>
                </div>
            </div>
        </div>
    </div>

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
                                <input type="text" class="form-control" id="billing_first_name" name="billing[first_name]" required value="{{ old('billing.first_name', $user->first_name ?? '') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="billing_last_name" class="form-label">Last Name *</label>
                                <input type="text" class="form-control" id="billing_last_name" name="billing[last_name]" required value="{{ old('billing.last_name', $user->last_name ?? '') }}">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="billing_email" class="form-label">Email Address *</label>
                            <input type="email" class="form-control" id="billing_email" name="billing[email]" required value="{{ old('billing.email', $user->email ?? '') }}">
                        </div>
                        <div class="mb-3">
                            <label for="billing_phone" class="form-label">Phone Number *</label>
                            <input type="tel" class="form-control" id="billing_phone" name="billing[phone]" required value="{{ old('billing.phone', $user->phone ?? '') }}">
                        </div>
                        <div class="mb-3">
                            <label for="billing_address" class="form-label">Address *</label>
                            <input type="text" class="form-control" id="billing_address" name="billing[address]" required value="{{ old('billing.address', $user->address ?? '') }}">
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="billing_city" class="form-label">City *</label>
                                <input type="text" class="form-control" id="billing_city" name="billing[city]" required value="{{ old('billing.city', $user->city ?? '') }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="billing_state" class="form-label">State *</label>
                                <input type="text" class="form-control" id="billing_state" name="billing[state]" required value="{{ old('billing.state', $user->state ?? '') }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="billing_zip" class="form-label">ZIP Code *</label>
                                <input type="text" class="form-control" id="billing_zip" name="billing[zip]" required value="{{ old('billing.zip', $user->zip ?? '') }}">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="billing_country" class="form-label">Country *</label>
                            <select class="form-select" id="billing_country" name="billing[country]" required>
                                <option value="">Select Country</option>
                                <option value="US" {{ old('billing.country', $user->country ?? '') == 'US' ? 'selected' : '' }}>United States</option>
                                <option value="CA" {{ old('billing.country', $user->country ?? '') == 'CA' ? 'selected' : '' }}>Canada</option>
                                <option value="GB" {{ old('billing.country', $user->country ?? '') == 'GB' ? 'selected' : '' }}>United Kingdom</option>
                                <option value="AU" {{ old('billing.country', $user->country ?? '') == 'AU' ? 'selected' : '' }}>Australia</option>
                                <option value="EG" {{ old('billing.country', $user->country ?? '') == 'EG' ? 'selected' : '' }}>Egypt</option>
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
                                    <input type="text" class="form-control" id="shipping_first_name" name="shipping[first_name]">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="shipping_last_name" class="form-label">Last Name *</label>
                                    <input type="text" class="form-control" id="shipping_last_name" name="shipping[last_name]">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="shipping_address" class="form-label">Address *</label>
                                <input type="text" class="form-control" id="shipping_address" name="shipping[address]">
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="shipping_city" class="form-label">City *</label>
                                    <input type="text" class="form-control" id="shipping_city" name="shipping[city]">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="shipping_state" class="form-label">State *</label>
                                    <input type="text" class="form-control" id="shipping_state" name="shipping[state]">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="shipping_zip" class="form-label">ZIP Code *</label>
                                    <input type="text" class="form-control" id="shipping_zip" name="shipping[zip]">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="shipping_country" class="form-label">Country *</label>
                                <select class="form-select" id="shipping_country" name="shipping[country]">
                                    <option value="">Select Country</option>
                                    <option value="US">United States</option>
                                    <option value="CA">Canada</option>
                                    <option value="GB">United Kingdom</option>
                                    <option value="AU">Australia</option>
                                    <option value="EG">Egypt</option>
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
                            <select class="form-select" id="payment_method" name="payment" required>
                                <option value="">Select Payment Method</option>
                                @foreach($paymentMethodsArray as $id => $name)
                                    <option value="{{ $id }}">{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <!-- Stripe Card Element -->
                        <div id="stripe-fields" style="display: none;">
                            <div class="mb-3">
                                <label for="card-element" class="form-label">Card Information *</label>
                                <div id="card-element" class="form-control" style="height: 40px; padding: 10px;">
                                    <!-- Stripe Elements will be inserted here -->
                                </div>
                                <div id="card-errors" class="invalid-feedback" role="alert"></div>
                            </div>
                            <input type="hidden" id="payment_token" name="payment_token">
                        </div>
                        
                        <!-- Fallback payment fields when Stripe is not available -->
                        <div id="fallback-payment-fields" style="display: none;">
                            <div class="alert alert-warning">
                                <i class="bi bi-exclamation-triangle"></i> 
                                Payment processing is temporarily unavailable. Please contact support or try again later.
                            </div>
                        </div>
                        
                        <!-- PayPal Info Placeholder -->
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
                        <h5 class="mb-0"><i class="bi bi-chat-text"></i> Order Notes</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="notes" class="form-label">Special Instructions</label>
                            <textarea class="form-control" id="notes" name="notes" rows="3" placeholder="Any special instructions for your bulk order...">{{ old('notes') }}</textarea>
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
                        <button type="submit" class="btn btn-success btn-lg" id="place-order-btn" form="bulk-order-form" disabled>
                            <i class="bi bi-check-circle"></i> Place Bulk Order
                        </button>
                    </div>
                    
                    <small class="text-muted text-center d-block mt-2">
                        By placing your order, you agree to our terms and conditions.
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- Stripe.js -->
<script src="https://js.stripe.com/v3/"></script>
<script>
// Check if Stripe loaded properly
window.addEventListener('load', function() {
    if (typeof Stripe === 'undefined') {
        console.error('Stripe failed to load');
        $('#fallback-payment-fields').show();
    } else {
        console.log('Stripe loaded successfully');
    }
});

// Initialize Stripe with error handling
let stripe = null;
let elements = null;
let cardElement = null;

try {
    if (typeof Stripe !== 'undefined') {
        const stripeKey = '{{ setting('payments.stripe_publishable_key') }}';
        if (!stripeKey) {
            console.error('Stripe publishable key not configured');
            $('#fallback-payment-fields').show();
        } else {
            stripe = Stripe(stripeKey);
            elements = stripe.elements();
            cardElement = elements.create('card', {
                style: {
                    base: {
                        fontSize: '16px',
                        color: '#424770',
                        '::placeholder': { color: '#aab7c4' },
                    },
                    invalid: { color: '#9e2146' },
                },
            });
            cardElement.mount('#card-element');
            console.log('Stripe card element created and mounted');
        }
    } else {
        console.error('Stripe library not available');
        $('#fallback-payment-fields').show();
    }
} catch (error) {
    console.error('Failed to initialize Stripe:', error);
    $('#fallback-payment-fields').show();
}

// Handle real-time validation errors
if (cardElement) {
    cardElement.on('change', function(event) {
        const displayError = document.getElementById('card-errors');
        if (event.error) {
            displayError.textContent = event.error.message;
            displayError.style.display = 'block';
        } else {
            displayError.textContent = '';
            displayError.style.display = 'none';
        }
    });
}

// AJAX CSV upload and preview
$('#csv-upload-form').on('submit', function(e) {
    e.preventDefault();
    var formData = new FormData(this);
    var btn = $(this).find('button[type="submit"]');
    btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span>Uploading...');
    $('#csv-upload-message').html('');
    
    $.ajax({
        url: '{{ route('bulk-order.parseCsv') }}',
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            btn.prop('disabled', false).html('<i class="bi bi-upload"></i> Upload & Preview');
            if (response.products && response.products.length > 0) {
                var tbody = '';
                var total = 0;
                var validCount = 0;
                var validProducts = [];
                
                response.products.forEach(function(item) {
                    tbody += '<tr>' +
                        '<td>' + (item.sku || '') + '</td>' +
                        '<td>' + (item.name || '-') + '</td>' +
                        '<td>$' + (item.price ? item.price.toFixed(2) : '-') + '</td>' +
                        '<td>' + (item.quantity || '-') + '</td>' +
                        '<td>$' + (item.subtotal ? item.subtotal.toFixed(2) : '-') + '</td>' +
                        '<td>' + (item.error ? '<span class="text-danger">' + item.error + '</span>' : '<span class="text-success">OK</span>') + '</td>' +
                    '</tr>';
                    if (!item.error) {
                        total += item.subtotal;
                        validCount++;
                        validProducts.push(item);
                    }
                });
                
                $('#product-preview-table tbody').html(tbody);
                $('#product-preview-total').text(total.toFixed(2));
                $('#product-preview-section').show();
                $('#bulk-order-form-section').show();
                $('#products-json').val(JSON.stringify(validProducts));
                
                // Update order summary
                updateOrderSummary(validProducts);
                
                $('#csv-upload-message').html('<span class="text-success">Products loaded. Please review and complete your order below.</span>');
                $('#place-order-btn').prop('disabled', validCount === 0);
            } else {
                $('#csv-upload-message').html('<span class="text-danger">No valid products found in CSV.</span>');
                $('#product-preview-section').hide();
                $('#bulk-order-form-section').hide();
            }
        },
        error: function(xhr) {
            btn.prop('disabled', false).html('<i class="bi bi-upload"></i> Upload & Preview');
            $('#csv-upload-message').html('<span class="text-danger">Failed to parse CSV. Please check your file.</span>');
            $('#product-preview-section').hide();
            $('#bulk-order-form-section').hide();
        }
    });
});

// Update order summary
function updateOrderSummary(products) {
    var subtotal = products.reduce(function(sum, item) { return sum + item.subtotal; }, 0);
    var tax = subtotal * 0.08; // 8% tax
    var shipping = subtotal > 100 ? 0 : 10; // Free shipping over $100
    var total = subtotal + tax + shipping;
    
    var itemsHtml = '';
    products.forEach(function(item) {
        itemsHtml += '<div class="d-flex justify-content-between align-items-center mb-2">' +
            '<div><h6 class="mb-0">' + item.name + '</h6><small class="text-muted">Qty: ' + item.quantity + '</small></div>' +
            '<span>$' + item.subtotal.toFixed(2) + '</span></div>';
    });
    
    $('#order-items').html(itemsHtml);
    $('#order-subtotal').text('$' + subtotal.toFixed(2));
    $('#order-tax').text('$' + tax.toFixed(2));
    $('#order-shipping').text('$' + shipping.toFixed(2));
    $('#order-total').text('$' + total.toFixed(2));
}

// Same as billing toggle
$('#same_as_billing').on('change', function() {
    if (this.checked) {
        $('#shipping-fields').hide();
        copyBillingToShipping();
    } else {
        $('#shipping-fields').show();
    }
});

// Copy billing to shipping
function copyBillingToShipping() {
    $('#shipping_first_name').val($('#billing_first_name').val());
    $('#shipping_last_name').val($('#billing_last_name').val());
    $('#shipping_address').val($('#billing_address').val());
    $('#shipping_city').val($('#billing_city').val());
    $('#shipping_state').val($('#billing_state').val());
    $('#shipping_zip').val($('#billing_zip').val());
    $('#shipping_country').val($('#billing_country').val());
}

// On billing field change, update shipping if same as billing
$('#bulk-order-form input').on('input', function() {
    if ($('#same_as_billing').is(':checked')) {
        copyBillingToShipping();
    }
});

// Payment method toggle
$('#payment_method').change(function() {
    const method = $(this).val();
    $('#stripe-fields, #paypal-fields, #fallback-payment-fields').hide();
    
    if (method === 'stripe') {
        if (stripe && cardElement) {
            $('#stripe-fields').show();
        } else {
            $('#fallback-payment-fields').show();
        }
    } else if (method === 'paypal') {
        $('#paypal-fields').show();
    }
});

// Form validation and submission
$('#bulk-order-form').submit(function(e) {
    e.preventDefault();
    
    const submitBtn = $('#place-order-btn');
    const originalText = submitBtn.html();
    const paymentMethod = $('#payment_method').val();
    
    // Show loading state
    submitBtn.html('<i class="bi bi-hourglass-split"></i> Processing...');
    submitBtn.prop('disabled', true);
    
    // Basic validation
    const requiredFields = [
        'billing_first_name', 'billing_last_name', 'billing_email', 'billing_phone',
        'billing_address', 'billing_city', 'billing_state', 'billing_zip', 'billing_country',
        'payment_method'
    ];
    
    let isValid = true;
    requiredFields.forEach(field => {
        const value = $(`#${field}`).val().trim();
        if (!value) {
            $(`#${field}`).addClass('is-invalid');
            isValid = false;
        } else {
            $(`#${field}`).removeClass('is-invalid');
        }
    });
    
    // Check if shipping is different from billing
    if (!$('#same_as_billing').is(':checked')) {
        const shippingFields = [
            'shipping_first_name', 'shipping_last_name', 'shipping_address',
            'shipping_city', 'shipping_state', 'shipping_zip', 'shipping_country'
        ];
        
        shippingFields.forEach(field => {
            const value = $(`#${field}`).val().trim();
            if (!value) {
                $(`#${field}`).addClass('is-invalid');
                isValid = false;
            } else {
                $(`#${field}`).removeClass('is-invalid');
            }
        });
    }
    
    if (!isValid) {
        showToast('Please fill in all required fields', 'warning');
        submitBtn.html(originalText);
        submitBtn.prop('disabled', false);
        return false;
    }
    
    // If same as billing, copy billing to shipping
    if ($('#same_as_billing').is(':checked')) {
        copyBillingToShipping();
    }

    // Handle payment based on method
    if (paymentMethod === 'stripe') {
        if (!stripe || !cardElement) {
            showToast('Stripe payment is not available. Please try another payment method.', 'error');
            submitBtn.html(originalText);
            submitBtn.prop('disabled', false);
            return false;
        }
        
        // Create payment method with Stripe
        stripe.createPaymentMethod({
            type: 'card',
            card: cardElement,
            billing_details: {
                name: $('#billing_first_name').val() + ' ' + $('#billing_last_name').val(),
                email: $('#billing_email').val(),
                phone: $('#billing_phone').val(),
                address: {
                    line1: $('#billing_address').val(),
                    city: $('#billing_city').val(),
                    state: $('#billing_state').val(),
                    postal_code: $('#billing_zip').val(),
                    country: $('#billing_country').val()
                }
            }
        }).then(function(result) {
            if (result.error) {
                const errorElement = document.getElementById('card-errors');
                errorElement.textContent = result.error.message;
                errorElement.style.display = 'block';
                
                submitBtn.html(originalText);
                submitBtn.prop('disabled', false);
                showToast('Payment error: ' + result.error.message, 'error');
            } else {
                $('#payment_token').val(result.paymentMethod.id);
                submitBulkOrder();
            }
        }).catch(function(error) {
            console.error('Stripe payment method creation failed:', error);
            showToast('Payment method creation failed: ' + error.message, 'error');
            submitBtn.html(originalText);
            submitBtn.prop('disabled', false);
        });
    } else {
        // For PayPal and other payment methods
        $('#payment_token').val('paypal_payment');
        submitBulkOrder();
    }
});

// Submit bulk order
function submitBulkOrder() {
    const formData = new FormData($('#bulk-order-form')[0]);
    
    $.ajax({
        url: '{{ route('bulk-order.submit') }}',
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            console.log('=== BULK ORDER SUBMISSION DEBUG ===');
            console.log('Response:', response);
            console.log('Response type:', typeof response);
            console.log('Response keys:', Object.keys(response));
            console.log('redirect_required:', response.redirect_required);
            console.log('redirect_url:', response.redirect_url);
            console.log('=== END DEBUG ===');
            
            if (response.redirect_required && response.redirect_url) {
                console.log('PayPal redirect required, URL:', response.redirect_url);
                showToast('Redirecting to PayPal...', 'info');
                setTimeout(function() {
                    window.location.href = response.redirect_url;
                }, 1000);
            } else if (response.redirect_url) {
                showToast('Order placed successfully!', 'success');
                setTimeout(function() {
                    window.location.href = response.redirect_url;
                }, 1500);
            } else {
                showToast('Order placed successfully!', 'success');
                setTimeout(function() {
                    location.reload();
                }, 1500);
            }
        },
        error: function(xhr, status, error) {
            console.error('=== BULK ORDER SUBMISSION ERROR ===');
            console.error('Status:', status);
            console.error('Error:', error);
            console.error('Response Text:', xhr.responseText);
            console.error('Response JSON:', xhr.responseJSON);
            console.error('=== END ERROR DEBUG ===');
            
            let message = 'Failed to place order. Please check your details and try again.';
            if (xhr.responseJSON && xhr.responseJSON.message) {
                message = xhr.responseJSON.message;
            }
            
            showToast(message, 'error');
            $('#place-order-btn').html('<i class="bi bi-check-circle"></i> Place Bulk Order');
            $('#place-order-btn').prop('disabled', false);
        }
    });
}

// Toast notification function
function showToast(message, type = 'info') {
    const toastClass = type === 'success' ? 'bg-success' : 
                      type === 'error' ? 'bg-danger' : 
                      type === 'warning' ? 'bg-warning' : 'bg-info';
    
    const toast = `
        <div class="toast align-items-center text-white ${toastClass} border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    ${message}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    `;
    
    // Remove existing toasts
    $('.toast').remove();
    
    // Add new toast
    $('body').append(toast);
    
    // Show toast
    const toastElement = new bootstrap.Toast(document.querySelector('.toast'));
    toastElement.show();
}

// Initialize form
$(document).ready(function() {
    // Copy billing to shipping on page load if user has address data
    @if($user && $user->address)
        copyBillingToShipping();
    @endif
    
    // Show/hide payment fields based on selected method
    const selectedMethod = $('#payment_method').val();
    if (selectedMethod === 'stripe') {
        if (stripe && cardElement) {
            $('#stripe-fields').show();
        } else {
            $('#fallback-payment-fields').show();
        }
    } else if (selectedMethod === 'paypal') {
        $('#paypal-fields').show();
    }
    
    // If user is logged in and has address data, show a notification
    @if($user && $user->address)
        showToast('Your billing information has been pre-filled from your profile.', 'info');
    @endif
});
</script>
@endpush 