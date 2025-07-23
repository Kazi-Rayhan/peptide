<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use App\Models\TaxClass;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {


        // Load products from JSON file
        $jsonPath = public_path('json/products.json');
        if (!file_exists($jsonPath)) {
            $this->command->error('Products JSON file not found at: ' . $jsonPath);
            return;
        }

        $productsData = json_decode(file_get_contents($jsonPath), true);

        if (!$productsData) {
            $this->command->error('Failed to parse products JSON file');
            return;
        }

        $this->command->info('Seeding ' . count($productsData) . ' products...');

        foreach ($productsData as $productData) {
            foreach ($productData['variants'] as $variant) {
                $product = Product::create([
                    'name' => $variant['name'],
                    'slug' => Str::slug($variant['name']),
                    'sku' => $variant['sku'],
                    'category_id' => 1,
                    'price' => $variant['price'],
                    'stock' => $variant['stock'],
                    'track_quantity' => $variant['track_quantity'],
                    'attributes' => $variant['attributes'],
                    'meta_title' => $variant['name'],
                    'meta_description' => $productData['description'],
                    'meta_keywords' => str_replace(' ', ',', $productData['description']),
                    'status' => 'active',
                    'thumbnail' => $variant['thumbnail'],
                    'is_featured' => rand(0, 1),
                    'description' => $productData['description'],
                    'tax_class_id' => TaxClass::inRandomOrder()->first()->id,
                    
                ]);
            }
            // Create the product


            $this->command->info("Created product: {$product->name} with " . count($productData['variants']) . " variants");
        }

        $this->command->info('Product seeding completed successfully!');
    }
}
