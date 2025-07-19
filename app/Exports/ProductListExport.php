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
           $rows[] = [
            'id' => $product->id,
            'name' => $product->name,
            'sku' => $product->sku,
            'category' => $product->category->name,
            'wholesale_1_price' => $product->price['wholesale_1']['unit_price'],
            'wholesale_1_kit_price' => $product->price['wholesale_1']['kit_price'],
            'wholesale_2_price' => $product->price['wholesale_2']['unit_price'],
            'wholesale_2_kit_price' => $product->price['wholesale_2']['kit_price'],
            'distributor_1_price' => $product->price['distributor_1']['unit_price'],
            'distributor_1_kit_price' => $product->price['distributor_1']['kit_price'],
            'distributor_2_price' => $product->price['distributor_2']['unit_price'],
            'distributor_2_kit_price' => $product->price['distributor_2']['kit_price'],
            'stock' => $product->stock,
            'strength' => $product->attributes[0]['value'],
           ];
        }
        return $rows;
    }

    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'SKU',
            'Category',
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