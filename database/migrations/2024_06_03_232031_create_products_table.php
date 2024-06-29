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
            $table->foreignId('category_id')->constrained()->onDelete('cascade')->onRestore('cascade');
            $table->foreignId('brand_id')->constrained()->onDelete('cascade')->onRestore('cascade');
            $table->string('name', 255);
            $table->string('image', 255)->nullable();
            $table->string('slug', 255);
            $table->text('excerpt')->nullable();
            $table->decimal('price_regular', 19, 4);
            $table->decimal('price_sale', 19, 4)->nullable();
            $table->integer('quantity');
            $table->integer('length');
            $table->integer('width');
            $table->integer('height');
            $table->integer('weight');
            $table->boolean('is_home')->default(true);
            $table->boolean('is_active')->default(true);
            $table->text('description')->nullable();
            $table->longText('content')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::dropIfExists('products');
    }
};