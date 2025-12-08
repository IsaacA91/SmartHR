<?php

require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    // Get current admin
    $admin = \Illuminate\Support\Facades\DB::table('admin')->where('adminID', 'A001')->first();
    echo "Current admin A001:\n";
    echo "  Password hash: " . $admin->password . "\n\n";
    
    // Generate a fresh hash
    $newHash = password_hash('123456', PASSWORD_BCRYPT);
    echo "New hash for '123456': " . $newHash . "\n\n";
    
    // Update using raw query
    \Illuminate\Support\Facades\DB::statement(
        "UPDATE admin SET password = ? WHERE adminID = ?",
        [$newHash, 'A001']
    );
    
    echo "Password updated!\n\n";
    
    // Verify it
    $admin = \Illuminate\Support\Facades\DB::table('admin')->where('adminID', 'A001')->first();
    echo "Updated hash: " . $admin->password . "\n";
    
    if (password_verify('123456', $admin->password)) {
        echo "✓ Password '123456' verified successfully!\n";
    } else {
        echo "✗ Password verification failed\n";
    }
    
} catch (\Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}
