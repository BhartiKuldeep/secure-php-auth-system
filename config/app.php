<?php

use App\Core\Env;

return [
    'name' => Env::get('APP_NAME', 'Secure PHP Auth System'),
    'url' => rtrim(Env::get('APP_URL', 'http://localhost:8000'), '/'),
    'env' => Env::get('APP_ENV', 'local'),
    'debug' => filter_var(Env::get('APP_DEBUG', 'true'), FILTER_VALIDATE_BOOLEAN),
    'timezone' => Env::get('APP_TIMEZONE', 'UTC'),
    'session_name' => Env::get('SESSION_NAME', 'secure_php_auth'),
    'mail_mode' => Env::get('MAIL_MODE', 'log'),
    'mail_from_address' => Env::get('MAIL_FROM_ADDRESS', 'noreply@example.com'),
    'mail_from_name' => Env::get('MAIL_FROM_NAME', 'Secure PHP Auth System'),
    'default_admin_name' => Env::get('DEFAULT_ADMIN_NAME', 'Admin User'),
    'default_admin_email' => Env::get('DEFAULT_ADMIN_EMAIL', 'admin@example.com'),
    'default_admin_password' => Env::get('DEFAULT_ADMIN_PASSWORD', 'ChangeMe123!'),
    'database_path' => base_path('storage/database/app.json'),
];
