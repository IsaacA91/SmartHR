<?php
require __DIR__ . '/../../vendor/autoload.php';
$app = require __DIR__ . '/../../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$rows = \Illuminate\Support\Facades\DB::select("SELECT * FROM leaverequests WHERE employeeID = 'EE01' ORDER BY leaveRecordID DESC LIMIT 10");
echo "FOUND: " . count($rows) . " rows\n";
print_r($rows);
