<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Csrf;
use App\Core\Flash;
use App\Core\Mailer;
use App\Core\RateLimiter;
use App\Core\Session;
use App\Core\Validator;
use App\Core\View;
use App\Models\AuditLog;
use App\Models\User;

final class AuthController
{
    public function showRegister(): void
    {
        View::render('auth/register', [
            'title' => 'Create Account',
            'errors' => Session::getFlash('errors', []),
        ]);
    }

    public function register(): void
    {
        Csrf::ensure();
        Session::keepOldInput($_POST);
        $errors = Validator::registration($_POST);

        if ($errors) {
            Session::flash('errors', $errors);
            redirect('/register');
        }

        $user = User::create([
            'name' => $_POST['name'],
            'email' => $_POST['email'],
            'password' => $_POST['password'],
        ]);

        $token = User::issueVerificationToken((int) $user['id']);
        Mailer::sendVerification($user['email'], $user['name'], $token);
        AuditLog::record('user_registered', (int) $user['id'], ['email' => $user['email']]);
        Session::put('pending_verification_email', $user['email']);
        Flash::success('Account created. Check the mail log for your verification link.');
        redirect('/verify/pending');
    }

    public function showLogin(): void
    {
        View::render('auth/login', [
            'title' => 'Sign In',
            'errors' => Session::getFlash('errors', []),
        ]);
    }

    public function login(): void
    {
        Csrf::ensure();
        Session::keepOldInput($_POST);
        $errors = Validator::login($_POST);
        $email = strtolower(trim($_POST['email'] ?? ''));
        $password = (string) ($_POST['password'] ?? '');
        $ipAddress = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';

        if (RateLimiter::tooManyLoginAttempts($email, $ipAddress)) {
            $errors['email'] = 'Too many login attempts. Please wait 15 minutes and try again.';
        }

        if ($errors) {
            Session::flash('errors', $errors);
            redirect('/login');
        }

        $user = User::verifyCredentials($email, $password);

        if (! $user) {
            RateLimiter::recordLoginFailure($email, $ipAddress);
            AuditLog::record('login_failed', null, ['email' => $email]);
            Session::flash('errors', ['email' => 'Invalid credentials.']);
            redirect('/login');
        }

        if (empty($user['email_verified_at'])) {
            $token = User::issueVerificationToken((int) $user['id']);
            Mailer::sendVerification($user['email'], $user['name'], $token);
            AuditLog::record('verification_resent', (int) $user['id'], ['email' => $user['email']]);
            Session::put('pending_verification_email', $user['email']);
            Flash::warning('Your email is not verified yet. We generated a fresh verification link in the mail log.');
            redirect('/verify/pending');
        }

        RateLimiter::clearLoginFailures($email);
        Auth::login($user);
        AuditLog::record('login_success', (int) $user['id'], ['email' => $user['email']]);
        Flash::success('Welcome back, ' . $user['name'] . '.');
        redirect('/dashboard');
    }

    public function logout(): void
    {
        Csrf::ensure();
        $userId = Auth::id();
        AuditLog::record('user_logged_out', $userId);
        Auth::logout();
        Session::start();
        Flash::info('You have been signed out.');
        redirect('/login');
    }

    public function verify(): void
    {
        $token = $_GET['token'] ?? '';
        $user = $token ? User::findByVerificationToken($token) : null;

        if (! $user) {
            Flash::error('That verification link is invalid or has already been used.');
            redirect('/login');
        }

        User::markEmailVerified((int) $user['id']);
        AuditLog::record('email_verified', (int) $user['id'], ['email' => $user['email']]);
        Flash::success('Email verified. You can now sign in.');
        redirect('/login');
    }

    public function pendingVerification(): void
    {
        View::render('auth/verify-pending', [
            'title' => 'Verify Your Email',
            'email' => Session::get('pending_verification_email'),
        ]);
    }
}
