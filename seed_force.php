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
    'notifications'
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
    echo $e->getTraceAsString() . "\n";
}

echo "Running DemoDataSeeder...\n";
try {
    (new DemoDataSeeder())->run();
    echo "DemoDataSeeder completed.\n";
} catch (\Throwable $e) {
    echo 'Error in DemoDataSeeder: ' . $e->getMessage() . "\n";
}

echo "Enabling Foreign Key Checks...\n";
DB::statement('SET FOREIGN_KEY_CHECKS=1;');

echo "Seeding finished.\n";
