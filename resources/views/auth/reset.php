<section class="page-shell">
    <div class="container form-shell">
        <div class="form-card">
            <span class="kicker">Update password</span>
            <h1 class="page-title">Reset Password</h1>

            <?php if (! $isValidToken): ?>
                <p class="page-subtitle">This password reset link is missing, invalid, or expired.</p>
                <div class="inline-actions">
                    <a class="button-secondary" href="/forgot-password">Request a new link</a>
                </div>
            <?php else: ?>
                <p class="page-subtitle">Choose a strong new password for your account.</p>
                <form method="POST" action="/reset-password">
                    <?= csrf_field() ?>
                    <input type="hidden" name="token" value="<?= e($token) ?>">

                    <div class="form-group">
                        <label class="label" for="password">New password</label>
                        <input class="input" id="password" type="password" name="password" required>
                        <?php if (! empty($errors['password'])): ?><div class="error-text"><?= e($errors['password']) ?></div><?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label class="label" for="password_confirmation">Confirm new password</label>
                        <input class="input" id="password_confirmation" type="password" name="password_confirmation" required>
                        <?php if (! empty($errors['password_confirmation'])): ?><div class="error-text"><?= e($errors['password_confirmation']) ?></div><?php endif; ?>
                    </div>

                    <?php if (! empty($errors['token'])): ?><div class="error-text"><?= e($errors['token']) ?></div><?php endif; ?>
                    <button class="button" type="submit">Reset password</button>
                </form>
            <?php endif; ?>
        </div>
    </div>
</section>
