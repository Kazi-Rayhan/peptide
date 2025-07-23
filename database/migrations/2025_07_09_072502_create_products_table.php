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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('thumbnail')->nullable();
            $table->json('gallery')->nullable();
            $table->enum('status', ['draft', 'active', 'archived'])->default('draft');
            $table->string('name');
            $table->string('sku');
            $table->foreignId('category_id')->constrained('categories');
            $table->json('price');
            $table->integer('stock');
            $table->boolean('track_quantity');
            $table->boolean('is_featured')->default(false);
            $table->json('attributes');
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->foreignId('tax_class_id')->nullable()->constrained('tax_classes')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
