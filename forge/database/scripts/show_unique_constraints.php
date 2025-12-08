<?php

require __DIR__ . '/../../vendor/autoload.php';

$app = require_once __DIR__ . '/../../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

echo "All unique constraints on employee table:\n";
$result = DB::select('SHOW INDEX FROM employee');
foreach ($result as $row) {
    if ($row->Non_unique == 0) {
        echo "  - {$row->Key_name} on column {$row->Column_name}\n";
    }
}
