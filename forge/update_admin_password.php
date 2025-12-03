<?php

require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    // Generate bcrypt hash for password '123456'
    $hash = password_hash('123456', PASSWORD_BCRYPT);

    // Update admin A001 with bcrypt hash
    \Illuminate\Support\Facades\DB::update(
        'UPDATE admin SET password = ? WHERE adminID = ?',
        [$hash, 'A001']
    );

    echo "Admin A001 password updated successfully!\n";
    echo "Login credentials:\n";
    echo "  Admin ID: A001\n";
    echo "  Password: 123456\n";
    echo "\nNew bcrypt hash: " . $hash . "\n";

    // Verify
    $admin = \Illuminate\Support\Facades\DB::table('admin')->where('adminID', 'A001')->first();
    echo "\nVerifying password hash...\n";
    if (password_verify('123456', $admin->password)) {
        echo "✓ Password verification successful!\n";
    }
} catch (\Exception $e) {
    echo 'ERROR: ' . $e->getMessage() . "\n";
}
