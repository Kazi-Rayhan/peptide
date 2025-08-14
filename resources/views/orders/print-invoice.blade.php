<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $order->id }} - American Peptide</title>
    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=Inter:wght@400;500;700&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <style>
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

        .print-button {
            position: fixed;
            top: 24px;
            right: 24px;
            background: var(--primary-color);
            color: var(--light-bg);
            border: none;
            padding: 12px 28px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1em;
            font-family: 'Inter', sans-serif;
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.10);
            transition: all 0.3s cubic-bezier(.4, 0, .2, 1);
            z-index: 1000;
        }

        .invoice-main {
            max-width: 800px;
            margin: 40px auto;
            background: var(--light-bg);
            border-radius: 18px;
            box-shadow: 0 2px 16px rgba(0, 0, 0, 0.08);
            border: 1px solid var(--border-color);
            padding: 0 0 32px 0;
        }

        .invoice-header {
            padding: 20px;
            background: var(--header-bg);
        }

        .brand-title {
            font-family: 'Playfair Display', serif;
            font-size: 2.1rem;
            font-weight: 700;
            letter-spacing: 1px;
            margin-bottom: 0.2em;
            color: var(--primary-color);
        }

        .brand-contact {
            color: var(--text-muted);
            font-size: 1em;
            margin-bottom: 0.2em;
        }



        .header-right .business-address {
            margin-bottom: 0.2em;
        }

        .header-right .tax-id {
            font-size: 0.97em;
        }

        .invoice-card {
            margin: 24px 48px 0 48px;
            background: var(--light-bg);
            border-radius: 14px;
            border: 1px solid var(--border-color);
            box-shadow: 0 1px 6px rgba(0, 0, 0, 0.04);
            padding: 0;
        }

        .invoice-meta {
            display: grid;
            grid-template-columns: 1.5fr 1fr 1fr;
            gap: 24px;
            padding: 24px 24px 0 24px;
        }

        .meta-block {
            font-size: 1em;
        }

        .meta-block strong {
            font-weight: 600;
            color: var(--primary-color);
        }

        .meta-block .meta-label {
            color: var(--text-muted);
            font-size: 0.97em;
        }

        .meta-block .meta-value {
            font-weight: 600;
            color: var(--text-dark);
            font-size: 1.05em;
        }

        .meta-block .meta-accent {
            color: var(--primary-color);
            font-size: 1.3em;
            font-weight: 700;
        }

        .meta-block .meta-right {
            text-align: right;
        }

        .invoice-table {
            width: 100%;
            border-collapse: collapse;
            margin: 24px 0 0 0;
        }

        .invoice-table th {
            font-family: 'Inter', sans-serif;
            font-size: 0.98em;
            font-weight: 600;
            color: var(--text-muted);
            background: var(--header-bg);
            border-bottom: 1.5px solid var(--border-color);
            padding: 8px 8px;
            /* Reduced padding */
            text-align: left;
        }

        .invoice-table td {
            padding: 8px 8px;
            /* Reduced padding */
            font-size: 1em;
            color: var(--text-dark);
            border-bottom: 1px solid var(--border-color);
            vertical-align: top;
        }

        .invoice-table tr:last-child td {
            border-bottom: none;
        }

        .item-name {
            font-weight: 600;
            color: var(--secondary-color);
            font-family: 'Playfair Display', serif;
        }

        .item-desc {
            color: var(--text-muted);
            font-size: 0.97em;
        }

        .text-right {
            text-align: right;
        }

        .summary {
            margin: 24px 48px 0 0;
            float: right;
            min-width: 260px;
        }

        .summary-table {
            width: 100%;
        }

        .summary-table td {
            padding: 7px 0;
            font-size: 1em;
        }

        .summary-table .label {
            color: var(--text-muted);
            font-weight: 500;
        }

        .summary-table .value {
            text-align: right;
            color: var(--primary-color);
            font-weight: 600;
        }

        .summary-table .total-row {
            font-size: 1.2em;
            font-weight: 700;
            color: var(--primary-color);
        }

        .thanks {
            margin: 48px 48px 0 48px;
            font-weight: 600;
            color: var(--primary-color);
            font-size: 1.05em;
        }

        .terms {
            margin: 32px 48px 0 48px;
            color: var(--text-muted);
            font-size: 0.97em;
            border-top: 1px solid var(--border-color);
            padding-top: 16px;
        }

        @media (max-width: 900px) {

            .invoice-main,
            .invoice-header,
            .invoice-card,
            .thanks,
            .terms {
                margin-left: 0 !important;
                margin-right: 0 !important;
                padding-left: 16px !important;
                padding-right: 16px !important;
            }

            .invoice-meta {
                grid-template-columns: 1fr;
                gap: 18px;
                padding: 24px 0 0 0;
            }

            .summary {
                margin-right: 0;
            }
        }

        @media print {

            html,
            body {
                background: #fff !important;
                color: #222 !important;
                font-size: 12px;
                margin: 0 !important;
                padding: 0 !important;
            }

            .invoice-main {
                box-shadow: none !important;
                border: none !important;
                margin: 0 !important;
                border-radius: 0 !important;
                padding: 0 !important;
                width: 100% !important;
                max-width: 100% !important;
            }

            .invoice-header {
                border-radius: 0 !important;
                background: #fff !important;
                color: #222 !important;
                border-bottom: 1px solid #ccc !important;
                -webkit-print-color-adjust: exact;
                color-adjust: exact;
                padding: 24px 16px 12px 16px !important;
            }

            .invoice-card,
            .summary,
            .thanks,
            .terms {
                background: #fff !important;
                box-shadow: none !important;
                border-radius: 0 !important;
                border: none !important;
                margin: 0 !important;
                padding: 0 16px !important;
            }

            .invoice-meta,
            .summary-table,
            .invoice-table {
                width: 100% !important;
                max-width: 100% !important;
                padding: 0 !important;
            }

            .invoice-table th,
            .invoice-table td {
                background: #fff !important;
                color: #222 !important;
                border-color: #ccc !important;
                -webkit-print-color-adjust: exact;
                color-adjust: exact;
            }

            /* This rule ensures the print button is hidden during print mode */
            .print-button,
            .no-print,
            nav,
            .pagination,
            .footer,
            .header-right .tax-id {
                display: none !important;
            }

            .brand-title,
            .item-name,
            .thanks {
                color: #222 !important;
            }

            .meta-block .meta-accent,
            .summary-table .total-row,
            .summary-table .value {
                color: #222 !important;
            }

            .terms {
                border-top: 1px solid #ccc !important;
                color: #555 !important;
                padding-top: 8px !important;
            }
        }
    </style>
    <script>
        window.onload = function() {
            setTimeout(function() {
                window.print();
            }, 1200);
        };

        function printInvoice() {
            window.print();
        }
    </script>
</head>

<body>

    <div class="invoice-main">
        <div class="invoice-header">
            <div class="row">
                <div class="brand-title col-md-8">American Peptide</div>
                {{-- <button onclick="printInvoice()" class="print-button col-md-4 no-print">🖨️
        Print Invoice</button> --}}
            </div>
            <div class="row">
                <div class="header-left col-md-8">
                    <div class="brand-contact">www.americanpeptide.com</div>
                    <div class="brand-contact">info@americanpeptide.com</div>
                    <div class="brand-contact">+1 (800) 555-0199</div>
                </div>
                <div class="header-right text-secondary col-md-4">
                    <div class="business-address">456 Research Drive, Biotech Valley</div>
                    <div class="business-address">State, City, TX - 77001</div>
                    <div class="tax-id">TAX ID 99XXXX5678XXX</div>
                </div>
            </div>

        </div>
        <div class="invoice-card">
            <div class="invoice-meta">
                <div class="meta-block">
                    <div class="meta-label">Billed to,</div>
                    <div class="meta-value"><strong>{{ $order->user->name ?? 'Guest Customer' }}</strong></div>
                    <div class="meta-label">{{ $order->shipping_address['address_line_1'] ?? '' }}</div>
                    <div class="meta-label">{{ $order->shipping_address['city'] ?? '' }},
                        {{ $order->shipping_address['country'] ?? '' }}</div>
                    <div class="meta-label">{{ $order->shipping_address['phone'] ?? '' }}</div>
                </div>
                <div class="meta-block">
                    <div class="meta-label">Invoice number</div>
                    <div class="meta-value"><strong>#{{ $order->id }}</strong></div>
                    <div class="meta-label">Reference</div>
                    <div class="meta-value">INV-{{ str_pad($order->id, 3, '0', STR_PAD_LEFT) }}</div>
                </div>
                <div class="meta-block meta-right">
                    <div class="meta-label">Invoice of ({{ strtoupper($order->currency) }})</div>
                    <div class="meta-accent">${{ number_format($order->total, 2) }}</div>
                </div>
            </div>
            <div class="invoice-meta" style="padding-top:18px;">
                <div class="meta-block">
                    <div class="meta-label">Subject</div>
                    <div class="meta-value">Order #{{ $order->id }}</div>
                </div>
                <div class="meta-block">
                    <div class="meta-label">Invoice date</div>
                    <div class="meta-value">{{ $order->created_at->format('d M, Y') }}</div>
                </div>
                <div class="meta-block">
                    <div class="meta-label">Due date</div>
                    <div class="meta-value">{{ $order->created_at->addDays(15)->format('d M, Y') }}</div>
                </div>
            </div>
            <table class="invoice-table">
                <thead>
                    <tr>
                        <th>Item Detail</th>
                        <th>Qty</th>
                        <th>Rate</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->lines as $line)
                        <tr>
                            <td>
                                <div class="item-name">{{ $line->product_name }}</div>
                                <div class="item-desc">SKU: {{ $line->sku }}</div>
                            </td>
                            <td>{{ $line->quantity }}</td>
                            <td>${{ number_format($line->price, 2) }}</td>
                            <td>${{ number_format($line->total, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="summary">
                <table class="summary-table">
                    <tr>
                        <td class="label">Subtotal</td>
                        <td class="value">${{ number_format($order->subtotal ?? $order->total, 2) }}</td>
                    </tr>
                    @if ($order->total_discount > 0)
                        <tr>
                            <td class="label">Discounts</td>
                            <td class="value">-${{ number_format($order->total_discount, 2) }}</td>
                        </tr>
                    @endif
                    <tr class="total-row">
                        <td class="label">Total</td>
                        <td class="value">${{ number_format($order->total, 2) }}</td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="thanks">Thanks for your business!</div>
        <div class="terms">
            <div><strong>Terms & Conditions</strong></div>
            <div>Payment is due within 15 days of the invoice date.</div>
        </div>
    </div>
</body>

</html>
