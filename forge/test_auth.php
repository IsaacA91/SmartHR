<?php

require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Test admin authentication flow:\n\n";

// Check if admin is currently authenticated
if (\Illuminate\Support\Facades\Auth::guard('admin')->check()) {
    $admin = \Illuminate\Support\Facades\Auth::guard('admin')->user();
    echo "✓ Admin is currently logged in: " . $admin->adminID . " (" . $admin->firstName . " " . $admin->lastName . ")\n";
} else {
    echo "✗ No admin is currently logged in\n";
}

echo "\nTo test logout:\n";
echo "1. Click the Logout button in the admin header\n";
echo "2. You should be redirected to /signinPage\n";
echo "3. Try accessing /admin/dashboard - you should be redirected back to /signinPage\n";
