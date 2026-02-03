<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

Schema::disableForeignKeyConstraints();

try {
    Schema::table('users', function (Blueprint $table) {
        if (!Schema::hasColumn('users', 'type')) {
            $table->enum('type', ['client', 'restaurant', 'admin'])->default('client');
        }
        if (!Schema::hasColumn('users', 'phone')) {
            $table->string('phone')->nullable();
        }
        if (!Schema::hasColumn('users', 'region_id')) {
            $table->integer('region_id')->unsigned()->nullable();
        }
        if (!Schema::hasColumn('users', 'pin_code')) {
            $table->string('pin_code')->nullable();
        }
        if (!Schema::hasColumn('users', 'image')) {
            $table->string('image')->nullable();
        }
        if (!Schema::hasColumn('users', 'status')) {
            $table->boolean('status')->default(true);
        }
        if (!Schema::hasColumn('users', 'minimum_order')) {
            $table->decimal('minimum_order')->nullable();
        }
        if (!Schema::hasColumn('users', 'delivery_fees')) {
            $table->decimal('delivery_fees')->nullable();
        }
        if (!Schema::hasColumn('users', 'whatsapp')) {
            $table->string('whatsapp')->nullable();
        }
        if (!Schema::hasColumn('users', 'api_token')) {
            $table->string('api_token', 60)->unique()->nullable();
        }
    });
    echo "Users table updated successfully.\n";

    Schema::dropIfExists('clients');
    Schema::dropIfExists('restaurants');
    echo "Old tables dropped.\n";
} catch (\Exception $e) {
    echo 'Error updating users table: ' . $e->getMessage() . "\n";
}

Schema::enableForeignKeyConstraints();
