<?php

namespace App\Controllers;

use App\Core\Csrf;
use App\Core\Flash;
use App\Core\Mailer;
use App\Core\Session;
use App\Core\Validator;
use App\Core\View;
use App\Models\AuditLog;
use App\Models\PasswordReset;
use App\Models\User;

final class PasswordController
{
    public function showForgotForm(): void
    {
        View::render('auth/forgot', [
            'title' => 'Forgot Password',
            'errors' => Session::getFlash('errors', []),
        ]);
    }

    public function sendResetLink(): void
    {
        Csrf::ensure();
        Session::keepOldInput($_POST);
        $errors = Validator::emailOnly($_POST);

        if ($errors) {
            Session::flash('errors', $errors);
            redirect('/forgot-password');
        }

        $email = strtolower(trim($_POST['email']));
        $user = User::findByEmail($email);

        if ($user) {
            $token = PasswordReset::create($email);
            Mailer::sendPasswordReset($email, $token);
            AuditLog::record('password_reset_requested', (int) $user['id'], ['email' => $email]);
        }

        Flash::info('If the account exists, a reset link was written to the mail log.');
        redirect('/forgot-password');
    }

    public function showResetForm(): void
    {
        $token = $_GET['token'] ?? '';
        $record = $token ? PasswordReset::findValid($token) : null;

        View::render('auth/reset', [
            'title' => 'Reset Password',
            'errors' => Session::getFlash('errors', []),
            'token' => $token,
            'isValidToken' => (bool) $record,
        ]);
    }

    public function resetPassword(): void
    {
        Csrf::ensure();
        $token = (string) ($_POST['token'] ?? '');
        $record = $token ? PasswordReset::findValid($token) : null;
        $errors = Validator::resetPassword($_POST);

        if (! $record) {
            $errors['token'] = 'This reset link is invalid or expired.';
        }

        if ($errors) {
            Session::flash('errors', $errors);
            redirect('/reset-password?token=' . urlencode($token));
        }

        $user = User::findByEmail($record['email']);
        if (! $user) {
            Flash::error('No account was found for this reset request.');
            redirect('/forgot-password');
        }

        User::updatePassword((int) $user['id'], $_POST['password']);
        PasswordReset::deleteByEmail($record['email']);
        AuditLog::record('password_reset_completed', (int) $user['id'], ['email' => $user['email']]);
        Flash::success('Password updated. You can now sign in.');
        redirect('/login');
    }
}
