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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('social_id', 255)->nullable();
            $table->string('name', 255);
            $table->string('avatar', 255)->nullable();
            $table->string('email', 255);
            $table->string('phone', 20);
            $table->string('password', 255);
            $table->string('remember_token', 255);
            $table->string('user_code', 255);
            $table->tinyInteger('type_social')->default(0)->comment('0: Unsocial, 1: Google');
            $table->boolean('active')->default(0);
            $table->boolean('status')->default(false);
            $table->string('address', 255);
            $table->foreignId('province_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('district_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('ward_id')->nullable()->constrained()->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};