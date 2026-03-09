<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';

use Database\Seeders\AdminSeeder;
use Database\Seeders\DemoDataSeeder;
use Database\Seeders\EgyptLocationsSeeder;
use Database\Seeders\SofraDataSeeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Fixing Schema for Users...\n";
if (!Schema::hasColumn('users', 'pin_code')) {
    DB::statement('ALTER TABLE users ADD pin_code VARCHAR(255) NULL AFTER remember_token;');
    echo "Added pin_code column to users.\n";
}

echo "Fixing Schema for Orders...\n";
if (!Schema::hasColumn('orders', 'total_price')) {
    DB::statement('ALTER TABLE orders ADD total_price DECIMAL(10,2) DEFAULT 0 AFTER commission;');
    echo "Added total_price column to orders.\n";
}
if (!Schema::hasColumn('orders', 'net')) {
    DB::statement('ALTER TABLE orders ADD net DECIMAL(10,2) DEFAULT 0 AFTER total_price;');
    echo "Added net column to orders.\n";
}
if (!Schema::hasColumn('orders', 'note')) {
    DB::statement('ALTER TABLE orders ADD note TEXT NULL AFTER address;');
    echo "Added note column to orders.\n";
}

echo "Fixing Schema for Payments...\n";
if (!Schema::hasColumn('payments', 'amount')) {
    DB::statement('ALTER TABLE payments ADD amount DECIMAL(10,2) DEFAULT 0 AFTER pay;');
    echo "Added amount column to payments.\n";
}

echo "Disabling Foreign Key Checks...\n";
DB::statement('SET FOREIGN_KEY_CHECKS=0;');

$tables = [
    'category_restaurant',
    'order_product',
    'comments',
    'offers',
    'products',
    'orders',
    'users',
    'categories',
    'streets',
    'cities',
    'contacts',
    'settings',
    'payments',
    'tokens',
    'notifications',
    'model_has_roles',
    'model_has_permissions',
    'role_has_permissions'
];

foreach ($tables as $table) {
    if (Schema::hasTable($table)) {
        echo "Truncating $table...\n";
        DB::table($table)->truncate();
    }
}

echo "Running AdminSeeder...\n";
(new AdminSeeder())->run();

echo "Running EgyptLocationsSeeder...\n";
(new EgyptLocationsSeeder())->run();

echo "Running SofraDataSeeder...\n";
try {
    (new SofraDataSeeder())->run();
    echo "SofraDataSeeder completed.\n";
} catch (\Throwable $e) {
    echo 'Error in SofraDataSeeder: ' . $e->getMessage() . "\n";
}

echo "Running DemoDataSeeder...\n";
try {
    (new DemoDataSeeder())->run();
    echo "DemoDataSeeder completed.\n";
} catch (\Throwable $e) {
    echo 'Error in DemoDataSeeder: ' . $e->getMessage() . "\n";
}

DB::statement('SET FOREIGN_KEY_CHECKS=1;');
echo "DONE! Statistics should work now.\n";
