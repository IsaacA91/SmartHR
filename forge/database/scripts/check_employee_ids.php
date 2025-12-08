<?php

require __DIR__ . '/../../vendor/autoload.php';

$app = require_once __DIR__ . '/../../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

// Get max employee ID
$maxId = DB::table('employee')->orderBy('employeeID', 'desc')->value('employeeID');
echo "Highest employee ID: " . $maxId . PHP_EOL;

// Get total count
$count = DB::table('employee')->count();
echo "Total employees: " . $count . PHP_EOL;

// Check if E501 exists
$exists = DB::table('employee')->where('employeeID', 'E501')->exists();
echo "E501 exists: " . ($exists ? 'YES' : 'NO') . PHP_EOL;

// Get last 5 employee IDs
echo "\nLast 5 employee IDs:" . PHP_EOL;
$lastFive = DB::table('employee')->orderBy('employeeID', 'desc')->limit(5)->pluck('employeeID');
foreach ($lastFive as $id) {
    echo "  - " . $id . PHP_EOL;
}
