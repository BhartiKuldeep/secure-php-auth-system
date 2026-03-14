<?php

use App\Controllers\AdminController;
use App\Controllers\AuthController;
use App\Controllers\DashboardController;
use App\Controllers\HomeController;
use App\Controllers\PasswordController;

$router->get('/', [HomeController::class, 'index']);

$router->get('/register', [AuthController::class, 'showRegister'], ['GuestMiddleware']);
$router->post('/register', [AuthController::class, 'register'], ['GuestMiddleware']);
$router->get('/login', [AuthController::class, 'showLogin'], ['GuestMiddleware']);
$router->post('/login', [AuthController::class, 'login'], ['GuestMiddleware']);
$router->post('/logout', [AuthController::class, 'logout'], ['AuthMiddleware']);
$router->get('/verify', [AuthController::class, 'verify']);
$router->get('/verify/pending', [AuthController::class, 'pendingVerification']);

$router->get('/forgot-password', [PasswordController::class, 'showForgotForm'], ['GuestMiddleware']);
$router->post('/forgot-password', [PasswordController::class, 'sendResetLink'], ['GuestMiddleware']);
$router->get('/reset-password', [PasswordController::class, 'showResetForm'], ['GuestMiddleware']);
$router->post('/reset-password', [PasswordController::class, 'resetPassword'], ['GuestMiddleware']);

$router->get('/dashboard', [DashboardController::class, 'index'], ['AuthMiddleware', 'VerifiedMiddleware']);
$router->get('/admin/users', [AdminController::class, 'users'], ['AuthMiddleware', 'VerifiedMiddleware', 'AdminMiddleware']);
