<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->decimal('price', 10, 2)->default(0.00)->after('description');
            $table->decimal('sale_price', 10, 2)->default(0.00)->after('price');
            $table->boolean('is_active')->default(true)->after('sale_price');
            $table->boolean('is_featured')->default(false)->after('is_active');
            $table->boolean('is_on_sale')->default(false)->after('is_featured');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['price', 'sale_price', 'is_active', 'is_featured', 'is_on_sale']);
        });
    }
};
