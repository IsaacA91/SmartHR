<?php

require __DIR__ . '/../../vendor/autoload.php';

$app = require_once __DIR__ . '/../../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

echo "Adding unique constraint to email column...\n";
try {
    DB::statement('ALTER TABLE employee ADD UNIQUE (email)');
    echo "Success!\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

echo "\nVerifying constraints...\n";
$result = DB::select('SHOW INDEX FROM employee WHERE Key_name LIKE "%unique%"');
foreach ($result as $row) {
    echo "  - {$row->Key_name} on column {$row->Column_name}\n";
}
