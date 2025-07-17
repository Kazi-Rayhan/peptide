<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductListExport implements FromArray, WithHeadings
{
    public function array(): array
    {
        $products = Product::all();
        $rows = [];
        foreach ($products as $product) {
            $variants = is_array($product->variants) ? $product->variants : json_decode($product->variants, true);
    
            if (is_array($variants) && count($variants) > 0) {
                foreach ($variants as $variant) {
                    $rows[] = [
              $variant['name'],
                        $variant['sku'] ?? '',
          
                        $variant['price']['wholesale_1']['unit_price'] ?? '',
                        $variant['price']['wholesale_1']['kit_price'] ?? '',
                        $variant['price']['wholesale_2']['unit_price'] ?? '',
                        $variant['price']['wholesale_2']['kit_price'] ?? '',
                        $variant['price']['distributor_1']['unit_price'] ?? '',
                        $variant['price']['distributor_1']['kit_price'] ?? '',
                        $variant['price']['distributor_2']['unit_price'] ?? '',
                        $variant['price']['distributor_2']['kit_price'] ?? '',
                        $variant['stock'] ?? '',
                        $variant['attributes'][0]['value'] ?? '',
                    ];
                }
            } else {
                $rows[] = [
                    $product->id,
                    $product->name,
                    '', '', '', '', '', '', ''
                ];
            }
        }
        return $rows;
    }

    public function headings(): array
    {
        return [
        
            'Product Name',
            'SKU',
        
            'Wholesale 1 Price',
            'Wholesale 1 Kit Price',
            'Wholesale 2 Price',
            'Wholesale 2 Kit Price',
            'Distributor 1 Price',
            'Distributor 1 Kit Price',
            'Distributor 2 Price',
            'Distributor 2 Kit Price',
            'Stock',
            'Strength',
        ];
    }
} 