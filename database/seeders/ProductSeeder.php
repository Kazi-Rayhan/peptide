<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable foreign key constraints
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Clear existing products
        DB::table('products')->truncate();
        
        // Re-enable foreign key constraints
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Create a default category if none exists
        $category = Category::firstOrCreate(
            ['name' => 'Peptides'],
            [
                'name' => 'Peptides',
                'slug' => 'peptides',
                'description' => 'Peptide products for various applications'
            ]
        );

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
            // Create the product
            $product = Product::create([
                'name' => $productData['name'],
                'slug' => $productData['slug'],
                'description' => $productData['description'],
                'category_id' => $category->id,
          
                'thumbnail' => $productData['thumbnail'],
                'status' => $productData['status'],
                'views' => $productData['views'] ?? 0,
                'variants' => $productData['variants'],
            ]);

            $this->command->info("Created product: {$product->name} with " . count($productData['variants']) . " variants");
        }

        $this->command->info('Product seeding completed successfully!');
    }
}
