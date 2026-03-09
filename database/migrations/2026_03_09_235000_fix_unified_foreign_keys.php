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

        // Fix orders table
        Schema::table('orders', function (Blueprint $table) {
            try {
                $table->dropForeign(['client_id']);
            } catch (\Exception $e) {
            }
            try {
                $table->dropForeign(['restaurant_id']);
            } catch (\Exception $e) {
            }
            $table->foreign('client_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('restaurant_id')->references('id')->on('users')->onDelete('cascade');
        });

        // Fix products table
        Schema::table('products', function (Blueprint $table) {
            try {
                $table->dropForeign(['restaurant_id']);
            } catch (\Exception $e) {
            }
            $table->foreign('restaurant_id')->references('id')->on('users')->onDelete('cascade');
        });

        // Fix offers table
        Schema::table('offers', function (Blueprint $table) {
            try {
                $table->dropForeign(['restaurant_id']);
            } catch (\Exception $e) {
            }
            $table->foreign('restaurant_id')->references('id')->on('users')->onDelete('cascade');
        });

        // Fix comments table
        Schema::table('comments', function (Blueprint $table) {
            try {
                $table->dropForeign(['client_id']);
            } catch (\Exception $e) {
            }
            try {
                $table->dropForeign(['restaurant_id']);
            } catch (\Exception $e) {
            }
            $table->foreign('client_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('restaurant_id')->references('id')->on('users')->onDelete('cascade');
        });

        // Fix tokens table
        Schema::table('tokens', function (Blueprint $table) {
            try {
                $table->dropForeign(['client_id']);
            } catch (\Exception $e) {
            }
            try {
                $table->dropForeign(['restaurant_id']);
            } catch (\Exception $e) {
            }
            $table->foreign('client_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('restaurant_id')->references('id')->on('users')->onDelete('cascade');
        });

        // Fix payments table
        Schema::table('payments', function (Blueprint $table) {
            try {
                $table->dropForeign(['restaurant_id']);
            } catch (\Exception $e) {
            }
            $table->foreign('restaurant_id')->references('id')->on('users')->onDelete('cascade');
        });

        // Fix category_restaurant table
        Schema::table('category_restaurant', function (Blueprint $table) {
            try {
                $table->dropForeign(['restaurant_id']);
            } catch (\Exception $e) {
            }
            $table->foreign('restaurant_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Reversing this is complex because we'd need to know if the old tables exist
    }
};
