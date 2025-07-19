<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Payment Debug Test</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        // Check if Stripe loaded properly
        window.addEventListener('load', function() {
            if (typeof Stripe === 'undefined') {
                console.error('Stripe failed to load');
                document.getElementById('result-log').innerHTML += '<span class="error">[ERROR] Stripe library failed to load</span>\n';
            } else {
                console.log('Stripe loaded successfully');
            }
        });
    </script>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .container { max-width: 1200px; margin: 0 auto; }
        .section { margin: 20px 0; padding: 20px; border: 1px solid #ddd; border-radius: 5px; }
        button { padding: 10px 20px; margin: 5px; background: #007bff; color: white; border: none; border-radius: 3px; cursor: pointer; }
        button:hover { background: #0056b3; }
        pre { background: #f8f9fa; padding: 15px; border-radius: 3px; overflow-x: auto; }
        .error { color: red; }
        .success { color: green; }
        .info { color: blue; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Payment Debug Test</h1>
        
        <div class="section">
            <h2>Configuration Check</h2>
            <p><strong>Stripe Publishable Key:</strong> <span id="stripe-key">{{ config('services.stripe.publishable_key') ? 'Set' : 'Not Set' }}</span></p>
            <p><strong>PayPal Client ID:</strong> <span id="paypal-key">{{ config('services.paypal.client_id') ? 'Set' : 'Not Set' }}</span></p>
            <p><strong>CSRF Token:</strong> <span id="csrf-token">{{ csrf_token() ? 'Set' : 'Not Set' }}</span></p>
        </div>

        <div class="section">
            <h2>Test Order Details</h2>
            <p>Order ID: <span id="order-id">N/A</span></p>
            <p>Total: <span id="order-total">N/A</span></p>
            <p>Payment Method: <span id="payment-method">N/A</span></p>
            <p>Status: <span id="order-status">N/A</span></p>
        </div>

        <div class="section">
            <h2>Test Payment Processing</h2>
            <button onclick="testStripeConfig()">Test Stripe Config</button>
            <button onclick="testStripePayment()">Test Stripe Payment</button>
            <button onclick="testPayPalPayment()">Test PayPal Payment</button>
            <button onclick="testBulkOrderSubmit()">Test Bulk Order Submit</button>
            <button onclick="clearLog()">Clear Log</button>
        </div>

        <div class="section">
            <h2>Results Log</h2>
            <pre id="result-log"></pre>
        </div>
    </div>

    <script>
        // Initialize Stripe with error handling
        let stripe = null;
        try {
            if (typeof Stripe !== 'undefined') {
                stripe = Stripe('{{ config('services.stripe.publishable_key') }}');
                log('Stripe initialized successfully', null, 'success');
            } else {
                log('Stripe library not available', null, 'error');
            }
        } catch (error) {
            log('Failed to initialize Stripe:', error, 'error');
        }
        
        function log(message, data = null, type = 'info') {
            const timestamp = new Date().toISOString();
            const logEntry = `<span class="${type}">[${timestamp}] ${message}</span>${data ? '\n' + JSON.stringify(data, null, 2) : ''}\n`;
            document.getElementById('result-log').innerHTML += logEntry;
            console.log(message, data);
        }

        function testStripeConfig() {
            log('Testing Stripe configuration...', null, 'info');
            
            fetch('/stripe/test')
                .then(response => response.json())
                .then(data => {
                    log('Stripe configuration test result:', data, 'success');
                })
                .catch(error => {
                    log('Stripe configuration test error:', error, 'error');
                });
        }

        function testStripePayment() {
            log('Testing Stripe payment...', null, 'info');
            
            if (!stripe) {
                log('Stripe not initialized. Cannot test payment.', null, 'error');
                return;
            }
            
            // Create a test payment method
            stripe.createPaymentMethod({
                type: 'card',
                card: {
                    number: '4242424242424242',
                    exp_month: 12,
                    exp_year: 2024,
                    cvc: '123'
                },
                billing_details: {
                    name: 'Test User',
                    email: 'test@example.com'
                }
            }).then(function(result) {
                log('Stripe payment method result:', result, result.error ? 'error' : 'success');
                
                if (result.error) {
                    log('Stripe error:', result.error, 'error');
                } else {
                    log('Payment method created successfully:', result.paymentMethod.id, 'success');
                }
            }).catch(function(error) {
                log('Stripe error:', error, 'error');
            });
        }

        function testPayPalPayment() {
            log('Testing PayPal payment...', null, 'info');
            
            // Test PayPal configuration
            fetch('/paypal/test')
                .then(response => response.json())
                .then(data => {
                    log('PayPal test result:', data, 'success');
                })
                .catch(error => {
                    log('PayPal test error:', error, 'error');
                });
        }

        function testBulkOrderSubmit() {
            log('Testing bulk order submit...', null, 'info');
            
            const testData = {
                products: JSON.stringify([
                    {
                        sku: 'TEST001',
                        name: 'Test Product',
                        price: 10.00,
                        quantity: 2,
                        subtotal: 20.00,
                        type: 'retail'
                    }
                ]),
                billing: {
                    first_name: 'Test',
                    last_name: 'User',
                    email: 'test@example.com',
                    phone: '1234567890',
                    address: '123 Test St',
                    city: 'Test City',
                    state: 'TS',
                    zip: '12345',
                    country: 'US'
                },
                shipping: {
                    first_name: 'Test',
                    last_name: 'User',
                    address: '123 Test St',
                    city: 'Test City',
                    state: 'TS',
                    zip: '12345',
                    country: 'US'
                },
                payment: 'stripe'
            };

            log('Submitting test bulk order with data:', testData, 'info');

            fetch('/user/bulk-order/submit', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(testData)
            })
            .then(response => {
                log('Response status:', response.status, 'info');
                return response.json();
            })
            .then(data => {
                log('Bulk order submit result:', data, 'success');
            })
            .catch(error => {
                log('Bulk order submit error:', error, 'error');
            });
        }

        function clearLog() {
            document.getElementById('result-log').innerHTML = '';
        }

        // Load test order details
        function loadTestOrder() {
            const urlParams = new URLSearchParams(window.location.search);
            const orderId = urlParams.get('order_id');
            
            if (orderId) {
                log('Loading order details for ID:', orderId, 'info');
                
                fetch(`/test-bulk-order-payment/${orderId}`)
                    .then(response => response.json())
                    .then(data => {
                        log('Order details loaded:', data, 'success');
                        
                        document.getElementById('order-id').textContent = data.order_id;
                        document.getElementById('order-total').textContent = '$' + data.total;
                        document.getElementById('payment-method').textContent = data.payment_method;
                        document.getElementById('order-status').textContent = data.status;
                    })
                    .catch(error => {
                        log('Error loading order details:', error, 'error');
                    });
            }
        }

        // Initialize on page load
        $(document).ready(function() {
            log('Payment debug test page loaded', null, 'info');
            loadTestOrder();
        });
    </script>
</body>
</html> 