<?php

require __DIR__ . '/../../vendor/autoload.php';

$app = require_once __DIR__ . '/../../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

// Check table structure
$result = DB::select('SHOW CREATE TABLE employee');
echo "Employee Table Structure:\n";
echo $result[0]->{'Create Table'} . "\n\n";

// Check for duplicate usernames
$duplicates = DB::select("
    SELECT username, COUNT(*) as count 
    FROM employee 
    GROUP BY username 
    HAVING COUNT(*) > 1
");

if (count($duplicates) > 0) {
    echo "Duplicate usernames found:\n";
    foreach ($duplicates as $dup) {
        echo "  - {$dup->username}: {$dup->count} employees\n";
    }
} else {
    echo "No duplicate usernames found.\n";
}
