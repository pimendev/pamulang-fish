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
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('sku')->unique();
            $table->decimal('price', 12, 2);
            $table->decimal('discount_price', 12, 2)->nullable();
            $table->integer('stock')->default(1);
            $table->string('status')->default('available'); // available, sold_out, reserved, coming_soon
            $table->string('gender')->default('male'); // male, female, pair, unsexed
            $table->string('betta_type')->default('halfmoon'); // halfmoon, plakat, crowntail, double_tail, giant, koi, nemo, avatar, galaxy, fancy, accessories, food, equipment
            $table->string('color_pattern')->nullable();
            $table->decimal('size_cm', 4, 1)->nullable();
            $table->decimal('age_months', 4, 1)->nullable();
            $table->string('care_level')->default('beginner'); // beginner, intermediate, advanced
            $table->text('description')->nullable();
            $table->text('care_guide')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->unsignedBigInteger('views_count')->default(0);
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
