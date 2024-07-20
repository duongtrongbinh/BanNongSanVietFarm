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
            $table->string('phone', 20)->nullable();
            $table->string('password', 255)->nullable();
            $table->string('remember_token', 255)->nullable();
            $table->string('user_code', 255)->nullable();
            $table->tinyInteger('type_social')->default(0)->comment('0: Unsocial, 1: Google');
            $table->boolean('active')->default(0);
            $table->boolean('status')->default(false);
            $table->string('token', 50)->nullable();
            $table->string('address', 255)->nullable();
            $table->unsignedBigInteger('ProvinceID');
            $table->unsignedBigInteger('DistrictID');
            $table->unsignedBigInteger('Ward_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('ProvinceID')
                ->references('id')
                ->on('provinces')
                ->cascadeOnDelete();

            $table->foreign('DistrictID')
                ->references('id')
                ->on('districts')
                ->cascadeOnDelete();

            $table->foreign('Ward_id')
                ->references('id')
                ->on('wards')
                ->cascadeOnDelete();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::dropIfExists('users');
    }
};
