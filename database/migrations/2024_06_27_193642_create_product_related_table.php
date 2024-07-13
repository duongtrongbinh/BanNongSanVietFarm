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
        Schema::create('product_related', function (Blueprint $table) {
            $table->foreignId('related_id')->constrained()->onDelete('cascade')->onRestore('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade')->onRestore('cascade');
            $table->primary(['related_id','product_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_related', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::dropIfExists('product_related');
    }
};
