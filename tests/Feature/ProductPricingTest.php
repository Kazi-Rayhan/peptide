<?php

namespace Tests\Feature;

use App\Enums\Level;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductPricingTest extends TestCase
{
    use RefreshDatabase;

    public function test_wholesaler_can_see_both_unit_and_kit_pricing()
    {
        // Create a wholesaler user
        $user = User::factory()->create([
            'is_wholesaler' => true,
            'current_level' => Level::WHOLESALER_ONE
        ]);

        // Create a product with both unit and kit pricing
        $product = Product::create([
            'name' => 'Test Product',
            'slug' => 'test-product',
            'description' => 'Test description',
            'price' => [
                'wholesaler_1' => [
                    'unit_price' => 10.00,
                    'kit_price' => 25.00
                ]
            ],
            'sku' => 'TEST001',
            'status' => 'active'
        ]);

        $this->actingAs($user);

        // Test that the product has both pricing types
        $this->assertTrue($product->hasBothPricingTypes());
        $this->assertTrue($product->isWholesalerUser());

        // Test pricing methods
        $this->assertEquals(10.00, $product->getUnitPrice());
        $this->assertEquals(25.00, $product->getKitPrice());
        $this->assertEquals(10.00, $product->getMinPrice());
        $this->assertEquals(25.00, $product->getMaxPrice());

        // Test display methods
        $this->assertEquals('$10.00', $product->getDisplayPrice('unit'));
        $this->assertEquals('$25.00', $product->getDisplayPrice('kit'));
    }

    public function test_retailer_only_sees_default_pricing()
    {
        // Create a retailer user
        $user = User::factory()->create([
            'is_wholesaler' => false,
            'current_level' => Level::RETAILER
        ]);

        // Create a product with both unit and kit pricing
        $product = Product::create([
            'name' => 'Test Product',
            'slug' => 'test-product',
            'description' => 'Test description',
            'price' => [
                'retailer' => [
                    'unit_price' => 15.00
                ],
                'wholesaler_1' => [
                    'unit_price' => 10.00,
                    'kit_price' => 25.00
                ]
            ],
            'sku' => 'TEST001',
            'status' => 'active'
        ]);

        $this->actingAs($user);

        // Test that the product doesn't have both pricing types for retailer
        $this->assertFalse($product->hasBothPricingTypes());
        $this->assertFalse($product->isWholesalerUser());

        // Test pricing methods
        $this->assertEquals(15.00, $product->getPrice());
        $this->assertEquals(15.00, $product->getUnitPrice());
        $this->assertEquals(0, $product->getKitPrice());
    }

    public function test_product_without_pricing_returns_zero()
    {
        $user = User::factory()->create([
            'is_wholesaler' => true,
            'current_level' => Level::WHOLESALER_ONE
        ]);

        $product = Product::create([
            'name' => 'Test Product',
            'slug' => 'test-product',
            'description' => 'Test description',
            'price' => [],
            'sku' => 'TEST001',
            'status' => 'active'
        ]);

        $this->actingAs($user);

        $this->assertEquals(0, $product->getUnitPrice());
        $this->assertEquals(0, $product->getKitPrice());
        $this->assertFalse($product->hasBothPricingTypes());
    }
} 