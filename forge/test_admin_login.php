<?php

require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    // Get admin A001
    $admin = \App\Models\Admin::where('adminID', 'A001')->first();
    
    if ($admin) {
        echo "Admin found:\n";
        echo "  Admin ID: " . $admin->adminID . "\n";
        echo "  Name: " . $admin->firstName . " " . $admin->lastName . "\n";
        echo "  Password hash: " . $admin->password . "\n\n";
        
        // Test password verification
        $password = '123456';
        
        if (\Illuminate\Support\Facades\Hash::check($password, $admin->password)) {
            echo "✓ Password '123456' matches!\n";
        } else {
            echo "✗ Password '123456' does NOT match\n";
        }
        
        // Try authentication
        $credentials = [
            'adminID' => 'A001',
            'password' => '123456'
        ];
        
        if (\Illuminate\Support\Facades\Auth::guard('admin')->attempt($credentials)) {
            echo "✓ Authentication successful!\n";
        } else {
            echo "✗ Authentication failed\n";
        }
        
    } else {
        echo "Admin A001 not found\n";
    }
    
} catch (\Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString() . "\n";
}
