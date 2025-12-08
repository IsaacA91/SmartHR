<?php

require __DIR__ . '/../../vendor/autoload.php';

$app = require_once __DIR__ . '/../../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

// Find employees with username 'test'
$employees = DB::select('SELECT employeeID, username, firstName, lastName FROM employee WHERE username = ?', ['test']);

echo "Employees with username 'test':\n";
foreach ($employees as $emp) {
    echo "  {$emp->employeeID} - {$emp->firstName} {$emp->lastName} - {$emp->username}\n";
}

// Rename duplicate usernames by appending employee ID
echo "\nRenaming duplicates...\n";
foreach ($employees as $index => $emp) {
    if ($index > 0) { // Keep first one as 'test', rename others
        $newUsername = $emp->username . '_' . $emp->employeeID;
        DB::update('UPDATE employee SET username = ? WHERE employeeID = ?', [$newUsername, $emp->employeeID]);
        echo "  Renamed {$emp->employeeID} to: {$newUsername}\n";
    }
}

echo "\nDone!\n";
