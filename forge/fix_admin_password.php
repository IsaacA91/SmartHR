<?php

require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    // Generate fresh bcrypt hash for password '123456'
    $hash = password_hash('123456', PASSWORD_BCRYPT);
    
    // Update admin A001 with the new hash
    \Illuminate\Support\Facades\DB::update(
        'UPDATE admin SET password = ? WHERE adminID = ?',
        [$hash, 'A001']
    );
    
    echo "Admin A001 password updated successfully!\n";
    echo "New bcrypt hash: " . $hash . "\n\n";
    
    // Verify it works
    $admin = \App\Models\Admin::where('adminID', 'A001')->first();
    
    if (password_verify('123456', $admin->password)) {
        echo "✓ Password verification successful!\n";
        echo "\nLogin credentials:\n";
        echo "  Admin ID: A001\n";
        echo "  Password: 123456\n";
    } else {
        echo "✗ Password verification failed\n";
    }
    
} catch (\Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}
