<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class BulkOrderService
{
    public function parseCsv($file)
    {
        $handle = fopen($file->getRealPath(), 'r');
        $header = fgetcsv($handle);
        $products = [];
        $total = 0;

        while (($row = fgetcsv($handle)) !== false) {
            [$sku, $quantity, $type] = $row;
            $quantity = (int) $quantity;
            $product = Product::whereJsonContains('variants', ['sku' => $sku])->first();
         
            if (!$product) {
                $products[] = [
                    'sku' => $sku,
                    'quantity' => $quantity,
                    'type' => $type,
                    'error' => 'Product not found',
                ];
                continue;
            }
            $subtotal = $product->price * $quantity;
            $total += $subtotal;
            $products[] = [
                'sku' => $sku,
                'name' => $product->name,
                'price' => $product->getVariantBySku($sku)['price']['wholesale_1']['kit_price'],
                'quantity' => $quantity,
                'subtotal' => $subtotal,
            ];
        }
        fclose($handle);

        return [
            'products' => $products,
            'total' => $total,
        ];
    }

    public function createBulkOrder($user, $products, $billing, $shipping, $payment)
    {
        return DB::transaction(function () use ($user, $products, $billing, $shipping, $payment) {
            $order = Order::create([
                'user_id' => $user->id,
                'billing_address' => $billing,
                'shipping_address' => $shipping,
                'payment_method' => $payment,
                'total' => collect($products)->sum('subtotal'),
                'status' => 'pending',
            ]);
            foreach ($products as $item) {
                $order->orderLines()->create([
                    'product_id' => Product::where('sku', $item['sku'])->first()->id,
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'subtotal' => $item['subtotal'],
                ]);
            }
            // Payment logic here (if needed)
            return $order;
        });
    }
} 