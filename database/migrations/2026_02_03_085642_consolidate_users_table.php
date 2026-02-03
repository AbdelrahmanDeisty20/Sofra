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
        echo "Starting migration...\n";
        Schema::disableForeignKeyConstraints();

        /*
         * // Drop existing foreign keys pointing to clients/restaurants
         * Schema::table('orders', function (Blueprint $table) {
         *     $table->dropForeign(['client_id']);
         *     $table->dropForeign(['restaurant_id']);
         * });
         * Schema::table('products', function (Blueprint $table) {
         *     $table->dropForeign(['restaurant_id']);
         * });
         * Schema::table('offers', function (Blueprint $table) {
         *     $table->dropForeign(['restaurant_id']);
         * });
         * Schema::table('comments', function (Blueprint $table) {
         *     $table->dropForeign(['client_id']);
         *     $table->dropForeign(['restaurant_id']);
         * });
         * Schema::table('tokens', function (Blueprint $table) {
         *     $table->dropForeign(['client_id']);
         *     $table->dropForeign(['restaurant_id']);
         * });
         * Schema::table('payments', function (Blueprint $table) {
         *     $table->dropForeign(['restaurant_id']);
         * });
         * Schema::table('category_restaurant', function (Blueprint $table) {
         *     $table->dropForeign(['restaurant_id']);
         * });
         */
        echo "Updating users table...\n";

        Schema::table('users', function (Blueprint $table) {
            $table->enum('type', ['client', 'restaurant', 'admin'])->default('client');
            $table->string('phone')->nullable();
            $table->integer('region_id')->unsigned()->nullable();
            $table->string('pin_code')->nullable();
            $table->string('image')->nullable();
            $table->boolean('status')->default(true);
            // Restaurant specific fields
            $table->decimal('minimum_order')->nullable();
            $table->decimal('delivery_fees')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('api_token', 60)->unique()->nullable();
        });
        echo "Users table updated.\n";

        /*
         * // Drop old tables
         * Schema::dropIfExists('clients');
         * Schema::dropIfExists('restaurants');
         *
         * // Re-create foreign keys pointing to users
         * Schema::table('orders', function (Blueprint $table) {
         *     $table->foreign('client_id')->references('id')->on('users')->onDelete('cascade');
         *     $table->foreign('restaurant_id')->references('id')->on('users')->onDelete('cascade');
         * });
         * Schema::table('products', function (Blueprint $table) {
         *     $table->foreign('restaurant_id')->references('id')->on('users')->onDelete('cascade');
         * });
         * Schema::table('offers', function (Blueprint $table) {
         *     $table->foreign('restaurant_id')->references('id')->on('users')->onDelete('cascade');
         * });
         * Schema::table('comments', function (Blueprint $table) {
         *     $table->foreign('client_id')->references('id')->on('users')->onDelete('cascade');
         *     $table->foreign('restaurant_id')->references('id')->on('users')->onDelete('cascade');
         * });
         * Schema::table('tokens', function (Blueprint $table) {
         *     $table->foreign('client_id')->references('id')->on('users')->onDelete('cascade');
         *     $table->foreign('restaurant_id')->references('id')->on('users')->onDelete('cascade');
         * });
         * Schema::table('payments', function (Blueprint $table) {
         *     $table->foreign('restaurant_id')->references('id')->on('users')->onDelete('cascade');
         * });
         * Schema::table('category_restaurant', function (Blueprint $table) {
         *     $table->foreign('restaurant_id')->references('id')->on('users')->onDelete('cascade');
         * });
         */
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
