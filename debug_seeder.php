<?php
define('LARAVEL_START', microtime(true));

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    (new Database\Seeders\SofraDataSeeder())->run();
    echo "Success\n";
} catch (\Throwable $e) {
    echo 'Error: ' . $e->getMessage() . "\n";
    echo 'File: ' . $e->getFile() . ' on line ' . $e->getLine() . "\n";
    echo $e->getTraceAsString() . "\n";
}
