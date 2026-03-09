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
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'type')) {
                $table->enum('type', ['client', 'restaurant', 'admin'])->default('client')->after('password');
            }
            if (!Schema::hasColumn('users', 'phone')) {
                $table->string('phone')->nullable()->after('email');
            }
            if (!Schema::hasColumn('users', 'region_id')) {
                $table->unsignedBigInteger('region_id')->nullable()->after('phone');
            }
            if (!Schema::hasColumn('users', 'image')) {
                $table->string('image')->nullable()->after('region_id');
            }
            if (!Schema::hasColumn('users', 'status')) {
                $table->boolean('status')->default(true)->after('image');
            }
            if (!Schema::hasColumn('users', 'whatsapp')) {
                $table->string('whatsapp')->nullable();
            }
            if (!Schema::hasColumn('users', 'minimum_order')) {
                $table->decimal('minimum_order', 8, 2)->nullable();
            }
            if (!Schema::hasColumn('users', 'delivery_fees')) {
                $table->decimal('delivery_fees', 8, 2)->nullable();
            }
            if (!Schema::hasColumn('users', 'commission_details')) {
                $table->text('commission_details')->nullable();
            }
            if (!Schema::hasColumn('users', 'facebook_link')) {
                $table->string('facebook_link')->nullable();
            }
            if (!Schema::hasColumn('users', 'instagram_link')) {
                $table->string('instagram_link')->nullable();
            }
            if (!Schema::hasColumn('users', 'twitter_link')) {
                $table->string('twitter_link')->nullable();
            }
            if (!Schema::hasColumn('users', 'youtube_link')) {
                $table->string('youtube_link')->nullable();
            }
        });

        // Add foreign key constraint if regions table exists and not already present
        if (Schema::hasTable('regions')) {
            try {
                Schema::table('users', function (Blueprint $table) {
                    $table->foreign('region_id')->references('id')->on('regions')->onDelete('set null');
                });
            } catch (\Exception $e) {
                // Ignore if foreign key already exists or table is not ready
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            try {
                $table->dropForeign(['region_id']);
            } catch (\Exception $e) {
            }

            $table->dropColumn([
                'type', 'phone', 'region_id', 'image', 'status', 'whatsapp',
                'minimum_order', 'delivery_fees', 'commission_details',
                'facebook_link', 'instagram_link', 'twitter_link', 'youtube_link'
            ]);
        });
    }
};
