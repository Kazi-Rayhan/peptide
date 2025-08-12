<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info(' Starting Category Seeder...');

        try {
            $jsonPath = public_path('json/categories.json');

            if (file_exists($jsonPath)) {
                $jsonContent = file_get_contents($jsonPath);
                $apiCategories = json_decode($jsonContent, true);

                if (json_last_error() !== JSON_ERROR_NONE || empty($apiCategories)) {
                    throw new \Exception('Invalid or empty JSON: ' . json_last_error_msg());
                }

                $this->command->info("📁 Found " . count($apiCategories) . " categories in JSON file");

                $createdCount = 0;
                $existingCount = 0;

                foreach ($apiCategories as $index => $apiCategory) {
                    $this->command->line("🔄 Processing category " . ($index + 1) . "/" . count($apiCategories) . ": {$apiCategory['name']}");

                    $slug = Str::slug($apiCategory['name']);

                    $category = Category::firstOrCreate(
                        ['slug' => $slug],
                        [
                            'name' => $apiCategory['name'],
                            'slug' => $slug,
                            'description' => $apiCategory['description'] ?? $this->generateDescription($apiCategory['name']),
                            'image' => $apiCategory['image'] ?? "{$slug}.jpg",
                        ]
                    );

                    if ($category->wasRecentlyCreated) {
                        $createdCount++;
                    } else {
                        $existingCount++;
                    }
                }

                $this->command->info("✅ Categories seeded from JSON successfully!");
                $this->command->info("📊 Created: {$createdCount}, Already existed: {$existingCount}");
            } else {
                $this->command->warn("⚠️ JSON file not found at: {$jsonPath}");
                $this->command->info("🔄 Falling back to default categories...");
                $this->seedDefaultCategories();
            }
        } catch (\Exception $e) {
            $this->command->error("❌ Error processing categories from JSON: " . $e->getMessage());
            $this->command->info("🔄 Falling back to default categories...");
            $this->seedDefaultCategories();
        }
    }

    /**
     * Seed fallback categories with full contextual data
     */
    private function seedDefaultCategories(): void
    {
        $categories = [
            [
                'name' => 'GHRP',
                'description' => 'GHRPs (Growth Hormone Releasing Peptides) are synthetic peptides that stimulate the natural release of growth hormone, supporting recovery, muscle growth, and anti-aging.',
            ],
            [
                'name' => 'GHS',
                'description' => 'GHS (Growth Hormone Secretagogues) promote the body’s natural production of growth hormone, improving metabolism, energy, and muscle repair.',
            ],
            [
                'name' => 'Anti-aging',
                'description' => 'Anti-aging compounds are formulated to reduce signs of aging, improve skin elasticity, enhance cellular repair, and support longevity.',
            ],
            [
                'name' => 'Healing/Repair',
                'description' => 'Healing and repair products accelerate tissue regeneration, reduce inflammation, and support recovery from injuries or surgeries.',
            ],
            [
                'name' => 'Weight Loss',
                'description' => 'Weight loss supplements aid in fat burning, appetite suppression, and metabolic enhancement to support healthy body composition.',
            ],
            [
                'name' => 'Cognitive',
                'description' => 'Cognitive enhancers are designed to improve memory, focus, mental clarity, and overall brain performance.',
            ],
            [
                'name' => 'Muscle Growth',
                'description' => 'Muscle growth supplements help stimulate protein synthesis, enhance strength, and accelerate lean muscle development.',
            ],
            [
                'name' => 'Immune',
                'description' => 'Immune support products boost the body’s natural defenses, enhance resilience against illness, and support overall immune function.',
            ],
            [
                'name' => 'Metabolic',
                'description' => 'Metabolic health products regulate energy production, improve insulin sensitivity, and optimize cellular metabolism.',
            ],
            [
                'name' => 'Antimicrobial',
                'description' => 'Antimicrobial agents help combat bacteria, viruses, and other pathogens, supporting internal and external immune defenses.',
            ],
        ];

        $createdCount = 0;
        $existingCount = 0;

        foreach ($categories as $categoryData) {
            $slug = Str::slug($categoryData['name']);

            $category = Category::firstOrCreate(
                ['slug' => $slug],
                [
                    'name' => $categoryData['name'],
                    'slug' => $slug,
                    'description' => $categoryData['description'],
                    'image' => "{$slug}.jpg",
                ]
            );

            if ($category->wasRecentlyCreated) {
                $createdCount++;
            } else {
                $existingCount++;
            }
        }

        $this->command->info("✅ Default categories seeded successfully!");
        $this->command->info("📊 Created: {$createdCount}, Already existed: {$existingCount}");
    }

    /**
     * Optional: Generate default description
     */
    private function generateDescription(string $categoryName): string
    {
        return "Explore our premium collection of {$categoryName} products. Scientifically formulated to support your specific health and wellness goals.";
    }
}
