<?php

require __DIR__ . '/../../vendor/autoload.php';

$app = require_once __DIR__ . '/../../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

// Find all duplicate emails
$duplicates = DB::select("
    SELECT email, COUNT(*) as count, GROUP_CONCAT(employeeID) as ids
    FROM employee 
    GROUP BY email 
    HAVING COUNT(*) > 1
");

echo "Duplicate emails found:\n";
foreach ($duplicates as $dup) {
    echo "  {$dup->email}: {$dup->count} times ({$dup->ids})\n";
}

echo "\nFixing duplicates...\n";
foreach ($duplicates as $dup) {
    $ids = explode(',', $dup->ids);
    foreach ($ids as $index => $id) {
        if ($index > 0) { // Keep first one, rename others
            $emailParts = explode('@', $dup->email);
            $newEmail = $emailParts[0] . '_' . $id . '@' . $emailParts[1];
            DB::update('UPDATE employee SET email = ? WHERE employeeID = ?', [$newEmail, $id]);
            echo "  Renamed {$id}: {$newEmail}\n";
        }
    }
}

echo "\nDone!\n";
