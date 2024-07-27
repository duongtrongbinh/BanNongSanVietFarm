<?php

use App\Enums\OrderStatus;
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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('voucher_id')->constrained()->onDelete('cascade')->nullable();
            $table->string('address');
            $table->string('name');
            $table->string('phone');
            $table->string('email');
            $table->boolean('payment_method')->default(0);
            $table->tinyInteger('payment_status')->default(0);
            $table->decimal('before_total_amount', 19, 4)->nullable();
            $table->decimal('shipping', 19, 4)->nullable();
            $table->decimal('after_total_amount', 19, 4)->nullable();
            $table->string('note', 255)->nullable();
            $table->tinyInteger('status')->default(0);
            $table->string('order_code', 255);
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::dropIfExists('orders');
    }
};
