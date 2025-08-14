<!DOCTYPE html>
<html>

<head>
    <title>Shipping Label #{{ $order->id }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Tailwind CSS for modern styling -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Define the color palette using CSS variables */
        :root {
            --primary-color: #0386cb;
            /* Bright Blue */
            --secondary-color: #044e75;
            /* Dark Blue */
            --text-dark: #000000;
            /* Black */
            --text-muted: #6d7582;
            /* Greyish Blue */
            --light-bg: #FFFFFF;
            /* White */
            --header-bg: #f5f8fa;
            /* Light grey for header */
            --border-color: #d4d8de;
            /* Lighter Grey */
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--header-bg);
            padding: 2rem;
            color: var(--text-dark);
        }

        .label-container {
            max-width: 600px;
            margin: auto;
            background-color: var(--light-bg);
            border: 1px solid var(--border-color);
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            padding: 2rem;
        }

        .label-header {
            border-bottom: 2px solid var(--primary-color);
            padding-bottom: 1rem;
            margin-bottom: 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
        }

        .label-title {
            color: var(--secondary-color);
            font-size: 1.5rem;
            font-weight: 700;
        }

        .section {
            margin-bottom: 1.5rem;
        }

        .section-title {
            font-weight: 600;
            color: var(--secondary-color);
            margin-bottom: 0.5rem;
        }

        .section-content {
            line-height: 1.5;
            color: var(--text-muted);
        }

        .barcode-placeholder {
            margin-top: 1.5rem;
            padding: 1rem;
            border: 1px dashed var(--border-color);
            border-radius: 0.25rem;
            text-align: center;
        }

        .barcode-image {
            display: block;
            margin: auto;
            width: 80%;
            height: 50px;
            background-image: linear-gradient(to right,
                    #000 0%, #000 5%,
                    #fff 5%, #fff 10%,
                    #000 10%, #000 15%,
                    #fff 15%, #fff 20%,
                    #000 20%, #000 25%,
                    #fff 25%, #fff 30%,
                    #000 30%, #000 35%,
                    #fff 35%, #fff 40%,
                    #000 40%, #000 45%,
                    #fff 45%, #fff 50%,
                    #000 50%, #000 55%,
                    #fff 55%, #fff 60%,
                    #000 60%, #000 65%,
                    #fff 65%, #fff 70%,
                    #000 70%, #000 75%,
                    #fff 75%, #fff 80%,
                    #000 80%, #000 85%,
                    #fff 85%, #fff 90%,
                    #000 90%, #000 95%,
                    #fff 95%, #fff 100%);
            background-size: 100% 100%;
            background-repeat: no-repeat;
        }
    </style>
</head>

<body>
    <div class="label-container">
        <div class="label-header">
            <h1 class="label-title">Shipping Label</h1>
            <span class="text-sm font-light text-gray-500">#{{ $order->id }}</span>
        </div>

        <div class="section">
            <h2 class="section-title">Customer & Address</h2>
            <div class="section-content">
                <strong>Name:</strong> {{ $order->user->name ?? 'Guest' }}<br>
                <strong>Shipping Address:</strong><br>
                <!-- Loop through shipping address details -->
                @if (isset($order->shipping_address) && is_array($order->shipping_address))
                    @foreach ($order->shipping_address as $key => $value)
                        @if ($value)
                            {{ ucfirst(str_replace('_', ' ', $key)) }}: {{ $value }}<br>
                        @endif
                    @endforeach
                @else
                    N/A
                @endif
            </div>
        </div>

        <div class="section">
            <h2 class="section-title">Shipping Details</h2>
            <div class="section-content">
                <strong>Method:</strong> {{ $order->shipping_method ?? 'N/A' }}<br>
                <strong>Tracking:</strong> {{ $order->tracking ?? 'N/A' }}
            </div>
        </div>

        <div class="barcode-placeholder">
            <div class="barcode-image"></div>
            <div class="mt-2 text-xs font-mono tracking-widest text-gray-700">
                {{ $order->tracking ?? 'N/A' }}
            </div>
        </div>
    </div>
</body>

</html>
