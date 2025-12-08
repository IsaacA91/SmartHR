<?php

require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    $hash = '$2y$10$YwzQKF34Gtr7AhA07ITqbujPopxkt9j6D7pLQB8aKgpxE6R34dTwS';
    
    \Illuminate\Support\Facades\DB::insert(
        'INSERT INTO admin (adminID, firstName, lastName, companyID, password) VALUES (?, ?, ?, ?, ?)',
        ['A001', 'Test', 'Admin', 'C001', $hash]
    );
    
    echo "Admin user created successfully!\n";
    echo "Login with:\n";
    echo "  Admin ID: A001\n";
    echo "  Password: 123456\n";
    
    // Verify the admin was created
    $admin = \Illuminate\Support\Facades\DB::table('admin')->where('adminID', 'A001')->first();
    if ($admin) {
        echo "\nAdmin record verified:\n";
        print_r($admin);
    }
    
} catch (\Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString() . "\n";
}
