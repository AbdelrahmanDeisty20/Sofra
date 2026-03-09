<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';

use Database\Seeders\AdminSeeder;
use Database\Seeders\EgyptLocationsSeeder;
use Database\Seeders\SofraDataSeeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Disabling Foreign Key Checks...\n";
DB::statement('SET FOREIGN_KEY_CHECKS=0;');

echo "Seeding Admin...\n";
(new AdminSeeder())->run();

echo "Seeding Locations...\n";
(new EgyptLocationsSeeder())->run();

echo "Seeding Sofra Data...\n";
(new SofraDataSeeder())->run();

DB::statement('SET FOREIGN_KEY_CHECKS=1;');
echo "DONE!\n";
