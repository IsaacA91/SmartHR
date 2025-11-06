<?php

require __DIR__ . '/../../vendor/autoload.php';
$app = require __DIR__ . '/../../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    \App\Models\LeaveRequest::unguard();
    $lr = \App\Models\LeaveRequest::create([
        'employeeID' => 'EE01',
        'start_date' => date('Y-m-d'),
        'end_date' => date('Y-m-d', strtotime('+1 day')),
        'reason' => 'automated test submission',
        'status' => 'pending'
    ]);

    echo "CREATED OK:\n";
    print_r($lr->toArray());
} catch (\Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString() . "\n";
}
