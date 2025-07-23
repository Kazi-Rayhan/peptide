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
            'unit_price' => $product->getPrice('unit'),
            'kit_price' => $product->getPrice('kit'),
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
            'Unit Price',
            'Kit Price',
            'Stock',
            'Strength',
        ];
    }
} 