<?php

namespace Database\Seeders;

use App\Enums\Level;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Only create admin if not exists
        $adminEmail = 'thisiskazi@gmail.com';
        if (!\App\Models\User::where('email', $adminEmail)->exists()) {
            \App\Models\User::create([
                'name' => 'Admin',
                'email' => $adminEmail,
                'role_id' => 1, // Admin
                'password' => bcrypt('password'),
            ]);
        }

        // Create 5 retailer customers
        \App\Models\User::factory()->count(5)->create([
            'role_id' => 2, // Retailer
            'is_wholesaler' => false,
            'details' => null,
            'current_level' => Level::RETAILER,
        ]);

        // Create 3 wholesaler customers with fake company details
        for ($i = 0; $i < 10; $i++) {
            $faker = \Faker\Factory::create();
            \App\Models\User::create([
                'name' => $faker->name(),
                'email' => $faker->unique()->safeEmail(),
                'role_id' => 2, // Wholesaler
                'password' => bcrypt('password'),
                'is_wholesaler' => true,
                'current_level' => [Level::WHOLESALER_ONE, Level::WHOLESALER_TWO, Level::DISTRIBUTOR_ONE, Level::DISTRIBUTOR_TWO][rand(0, 3)],
                'details' => json_encode([
                    'company_name' => $faker->company(),
                    'company_registration' => $faker->uuid(),
                    'company_address' => $faker->address(),
                    'company_phone' => $faker->phoneNumber(),
                    'company_website' => $faker->url(),
                    'business_type' => $faker->randomElement(['pharmaceutical', 'biotechnology', 'research_institute', 'university', 'hospital', 'laboratory', 'distributor', 'other']),
                    'industry' => $faker->randomElement(['healthcare', 'life_sciences', 'academic', 'clinical_research', 'drug_development', 'biomedical', 'other']),
                    'expected_volume' => $faker->randomElement(['small', 'medium', 'large', 'enterprise']),
                ]),
            ]);
        }
    }
}
