<?php

require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    // Get admin A001
    $admin = \Illuminate\Support\Facades\DB::table('admin')->where('adminID', 'A001')->first();
    echo "Admin A001:\n";
    echo "  Company ID: " . $admin->companyID . "\n\n";
    
    // Get all employees for that company
    $employees = \Illuminate\Support\Facades\DB::table('employee')
        ->where('companyID', $admin->companyID)
        ->get();
    
    echo "Employees in company " . $admin->companyID . ": " . count($employees) . "\n";
    
    if (count($employees) > 0) {
        echo "Sample employees:\n";
        foreach ($employees->take(5) as $emp) {
            echo "  - " . $emp->employeeID . ": " . $emp->firstName . " " . $emp->lastName . "\n";
        }
    }
    
    // Check how many companies exist
    $companies = \Illuminate\Support\Facades\DB::table('company')->get();
    echo "\nTotal companies: " . count($companies) . "\n";
    
    // Check total employees in all companies
    $totalEmps = \Illuminate\Support\Facades\DB::table('employee')->count();
    echo "Total employees in database: " . $totalEmps . "\n";
    
} catch (\Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}
