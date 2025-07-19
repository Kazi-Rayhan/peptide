<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BulkOrderService
{
    public function parseCsv($file)
    {
        Log::info('BulkOrderService@parseCsv started', [
            'filename' => $file->getClientOriginalName(),
            'filesize' => $file->getSize()
        ]);

        $handle = fopen($file->getRealPath(), 'r');
        $header = fgetcsv($handle);
        $products = [];
        $total = 0;
        $processedRows = 0;
        $errorCount = 0;

        Log::info('CSV header parsed', ['header' => $header]);

        while (($row = fgetcsv($handle)) !== false) {
            $processedRows++;
            [$sku, $quantity, $type] = $row;
            $quantity = (int) $quantity;
            
            Log::debug('Processing CSV row', [
                'row_number' => $processedRows,
                'sku' => $sku,
                'quantity' => $quantity,
                'type' => $type
            ]);

            $product = Product::where('sku', $sku)->first();
         
            if (!$product) {
                $errorCount++;
                Log::warning('Product not found in CSV', [
                    'sku' => $sku,
                    'row_number' => $processedRows
                ]);
                $products[] = [
                    'sku' => $sku,
                    'quantity' => $quantity,
                    'type' => $type,
                    'error' => 'Product not found',
                ];
                continue;
            }

            $price = $product->getPrice($type);
            $subtotal = $price * $quantity;
            $total += $subtotal;

            Log::debug('Product processed successfully', [
                'sku' => $sku,
                'product_name' => $product->name,
                'price' => $price,
                'quantity' => $quantity,
                'subtotal' => $subtotal
            ]);

            $products[] = [
                'sku' => $sku,
                'name' => $product->name,
                'price' => $price,
                'type' => $type,
                'quantity' => $quantity,
                'subtotal' => $subtotal,
            ];
        }
        fclose($handle);

        Log::info('BulkOrderService@parseCsv completed', [
            'total_rows_processed' => $processedRows,
            'products_found' => count($products) - $errorCount,
            'errors' => $errorCount,
            'total_amount' => $total
        ]);

        return [
            'products' => $products,
            'total' => $total,
        ];
    }

    public function createBulkOrder($user, $products, $billing, $shipping, $payment)
    {
        Log::info('BulkOrderService@createBulkOrder started', [
            'user_id' => $user->id,
            'products_count' => count($products),
            'payment_method' => $payment,
            'billing_keys' => array_keys($billing),
            'shipping_keys' => array_keys($shipping)
        ]);

        return DB::transaction(function () use ($user, $products, $billing, $shipping, $payment) {
            try {
                $total = collect($products)->sum('subtotal');
                
                Log::info('Creating order with calculated total', [
                    'total' => $total,
                    'products_summary' => collect($products)->map(function($p) {
                        return [
                            'sku' => $p['sku'],
                            'quantity' => $p['quantity'],
                            'subtotal' => $p['subtotal']
                        ];
                    })->toArray()
                ]);

                $order = Order::create([
                    'user_id' => $user->id,
                    'billing_address' => $billing,
                    'shipping_address' => $shipping,
                    'payment_method' => $payment,
                    'total' => $total,
                    'status' => 'pending',
                    'payment_status' => 'pending',
                    'currency' => 'USD',
                    'subtotal' => $total,
                    'tax_amount' => 0,
                    'shipping_amount' => 0,
                    'discount_amount' => 0,
                ]);

                Log::info('Order created successfully', [
                    'order_id' => $order->id,
                    'order_total' => $order->total,
                    'payment_method' => $order->payment_method,
                    'status' => $order->status
                ]);

                foreach ($products as $index => $item) {
                    Log::debug('Creating order line', [
                        'line_index' => $index,
                        'sku' => $item['sku'],
                        'quantity' => $item['quantity'],
                        'subtotal' => $item['subtotal']
                    ]);

                    $product = Product::where('sku', $item['sku'])->first();
                    if (!$product) {
                        Log::error('Product not found for order line', [
                            'sku' => $item['sku'],
                            'order_id' => $order->id
                        ]);
                        throw new \Exception("Product not found: {$item['sku']}");
                    }

                    $orderLine = $order->lines()->create([
                        'product_id' => $product->id,
                        'product_name' => $item['name'],
                        'sku' => $item['sku'],
                        'price' => $item['price'],
                        'quantity' => $item['quantity'],
                        'total' => $item['subtotal'],
                        'variant_info' => json_encode(['type' => $item['type']]),
                    ]);

                    Log::debug('Order line created', [
                        'order_line_id' => $orderLine->id,
                        'product_id' => $product->id
                    ]);
                }

                Log::info('BulkOrderService@createBulkOrder completed successfully', [
                    'order_id' => $order->id,
                    'total_lines' => $order->lines()->count(),
                    'total_amount' => $order->total
                ]);

                return $order;

            } catch (\Exception $e) {
                Log::error('BulkOrderService@createBulkOrder failed', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                    'user_id' => $user->id,
                    'payment_method' => $payment
                ]);
                throw $e;
            }
        });
    }
} 