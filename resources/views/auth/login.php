<section class="page-shell">
    <div class="container form-shell">
        <div class="form-card">
            <span class="kicker">Welcome back</span>
            <h1 class="page-title">Sign In</h1>
            <p class="page-subtitle">Use your verified account credentials to access the dashboard.</p>

            <form method="POST" action="/login">
                <?= csrf_field() ?>
                <div class="form-group">
                    <label class="label" for="email">Email address</label>
                    <input class="input" id="email" type="email" name="email" value="<?= e(old('email')) ?>" required>
                    <?php if (! empty($errors['email'])): ?><div class="error-text"><?= e($errors['email']) ?></div><?php endif; ?>
                </div>

                <div class="form-group">
                    <label class="label" for="password">Password</label>
                    <input class="input" id="password" type="password" name="password" required>
                    <?php if (! empty($errors['password'])): ?><div class="error-text"><?= e($errors['password']) ?></div><?php endif; ?>
                </div>

                <div class="inline-actions">
                    <button class="button" type="submit">Sign in</button>
                    <a href="/forgot-password" class="button-ghost">Forgot password?</a>
                </div>
            </form>

            <p class="form-help">No account yet? <a href="/register">Create one</a>.</p>
        </div>
    </div>
</section>
