<?php

use App\Core\Database;
use App\Core\Env;
use App\Models\User;

require __DIR__ . '/bootstrap/autoload.php';

if (! file_exists(__DIR__ . '/.env') && file_exists(__DIR__ . '/.env.example')) {
    copy(__DIR__ . '/.env.example', __DIR__ . '/.env');
    echo "[OK] .env created from .env.example\n";
}

Env::load(__DIR__ . '/.env');
App\Core\Config::load([
    'app' => require __DIR__ . '/config/app.php',
]);
Database::initialize();

$email = config('app.default_admin_email');
$user = User::findByEmail($email);

if (! $user) {
    User::create([
        'name' => config('app.default_admin_name'),
        'email' => $email,
        'password' => config('app.default_admin_password'),
        'role' => 'admin',
        'verified' => true,
    ]);
    echo "[OK] Default admin created: {$email}\n";
} else {
    echo "[OK] Default admin already exists: {$email}\n";
}

echo "[OK] Data file: " . config('app.database_path') . "\n";
echo "[OK] Setup complete. Start the app with: php -S localhost:8000 -t public\n";
