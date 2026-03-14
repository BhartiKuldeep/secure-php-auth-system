<?php

use App\Core\Flash;
use App\Core\View;

$router = require __DIR__ . '/../bootstrap/app.php';

header('X-Frame-Options: SAMEORIGIN');
header('X-Content-Type-Options: nosniff');
header('Referrer-Policy: strict-origin-when-cross-origin');
header('X-XSS-Protection: 1; mode=block');
header('Permissions-Policy: geolocation=(), microphone=(), camera=()');

try {
    $router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
} catch (Throwable $exception) {
    http_response_code(500);

    if (config('app.debug', false)) {
        echo '<pre>' . htmlspecialchars((string) $exception, ENT_QUOTES, 'UTF-8') . '</pre>';
    } else {
        Flash::error('Something went wrong. Please try again.');
        View::render('errors/500', ['title' => 'Server Error']);
    }
}
