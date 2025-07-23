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
        Schema::create('shipping_zones', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->timestamps();
        });
        // Pivot table for many-to-many relation
        Schema::create('country_shipping_zone', function (Blueprint $table) {
            $table->unsignedBigInteger('country_id');
            $table->unsignedBigInteger('shipping_zone_id');
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
            $table->foreign('shipping_zone_id')->references('id')->on('shipping_zones')->onDelete('cascade');
            $table->primary(['country_id', 'shipping_zone_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipping_zones');
    }
};
