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
        Schema::create('tax_rates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tax_class_id')->constrained('tax_classes')->onDelete('cascade');
            $table->foreignId('country_id')->constrained('countries')->onDelete('cascade');
            $table->foreignId('state_id')->nullable()->constrained('states')->onDelete('cascade');
            $table->decimal('rate', 8, 4);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tax_rates');
    }
};
