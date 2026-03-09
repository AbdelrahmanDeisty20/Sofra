<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::disableForeignKeyConstraints();

        Schema::table('category_restaurant', function (Blueprint $table) {
            $table->unsignedBigInteger('restaurant_id')->change();
            $table->unsignedBigInteger('category_id')->change();
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->unsignedBigInteger('client_id')->change();
            $table->unsignedBigInteger('restaurant_id')->change();
        });

        Schema::table('products', function (Blueprint $table) {
            $table->unsignedBigInteger('restaurant_id')->change();
        });

        Schema::table('offers', function (Blueprint $table) {
            $table->unsignedBigInteger('restaurant_id')->change();
        });

        Schema::table('comments', function (Blueprint $table) {
            $table->unsignedBigInteger('client_id')->change();
            $table->unsignedBigInteger('restaurant_id')->change();
        });

        Schema::table('tokens', function (Blueprint $table) {
            $table->unsignedBigInteger('client_id')->nullable()->change();
            $table->unsignedBigInteger('restaurant_id')->nullable()->change();
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->unsignedBigInteger('restaurant_id')->change();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No need for down for this fix
    }
};
