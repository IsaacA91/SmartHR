<?php

require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    // Check if admin exists
    $admin = \Illuminate\Support\Facades\DB::table('admin')->where('adminID', 'A001')->first();
    
    if ($admin) {
        echo "Admin A001 exists:\n";
        print_r($admin);
        echo "\n";
        
        // Try to verify the password
        $hash = '$2y$10$YwzQKF34Gtr7AhA07ITqbujPopxkt9j6D7pLQB8aKgpxE6R34dTwS';
        $password = '123456';
        
        if (password_verify($password, $admin->password)) {
            echo "✓ Password 123456 is correct!\n";
        } else {
            echo "✗ Password does not match.\n";
            echo "Stored hash: " . $admin->password . "\n";
            echo "Generated hash: " . $hash . "\n";
        }
    } else {
        echo "No admin A001 found.\n";
    }
    
} catch (\Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}
