<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

echo "🔧 Fixing password hashing...\n\n";

// Get all users
$users = User::all();

if ($users->count() == 0) {
    echo "❌ No users found in database.\n";
    echo "Creating a test user...\n";
    
    // Create a test user
    $user = User::create([
        'full_name' => 'Admin User',
        'username' => 'admin',
        'password_hash' => Hash::make('password'),
        'role_id' => 1,
        'is_active' => true,
    ]);
    
    echo "✅ Created test user: admin / password\n";
} else {
    echo "Found " . $users->count() . " users. Updating passwords...\n\n";
    
    foreach ($users as $user) {
        echo "Updating user: " . $user->username . "\n";
        
        // Hash the password properly
        $user->password_hash = Hash::make('password');
        $user->save();
        
        echo "✅ Updated password for " . $user->username . "\n";
    }
}

echo "\n🎉 Password fixing complete!\n";
echo "You can now login with:\n";
echo "- Username: admin\n";
echo "- Password: password\n";
