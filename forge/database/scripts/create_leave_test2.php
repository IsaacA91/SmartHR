<?php

require __DIR__ . '/../../vendor/autoload.php';
$app = require __DIR__ . '/../../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    \Illuminate\Support\Facades\DB::enableQueryLog();

    $last = \Illuminate\Support\Facades\DB::table('leaverequests')
        ->orderBy('leaveRecordID', 'desc')
        ->value('leaveRecordID');

    $newId = 'L0001';
    if ($last) {
        if (preg_match('/(\d+)$/', $last, $m)) {
            $num = intval($m[1]) + 1;
            // leaveRecordID has max length 5; use 1 letter + 4 digits (e.g. L0001)
            $newId = 'L' . str_pad($num, 4, '0', STR_PAD_LEFT);
        } else {
            // fallback
            $newId = $last . '_1';
        }
    }

    \App\Models\LeaveRequest::unguard();
    $lr = \App\Models\LeaveRequest::create([
        'leaveRecordID' => $newId,
        'employeeID' => 'EE01',
        'start_date' => date('Y-m-d'),
        'end_date' => date('Y-m-d', strtotime('+1 day')),
        'reason' => 'automated test submission 2',
        'status' => 'pending'
    ]);

    echo "CREATED OK:\n";
    print_r($lr->toArray());

    // Show latest rows for EE01
    $rows = \Illuminate\Support\Facades\DB::select("SELECT * FROM leaverequests WHERE employeeID = 'EE01' ORDER BY leaveRecordID DESC LIMIT 5");
    echo "\nLATEST ROWS:\n";
    print_r($rows);

    // Print query log for debugging
    $log = \Illuminate\Support\Facades\DB::getQueryLog();
    echo "\nQUERY LOG:\n";
    print_r($log);
} catch (\Exception $e) {
    echo 'ERROR: ' . $e->getMessage() . "\n";
    echo $e->getTraceAsString() . "\n";
}
