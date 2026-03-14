<section class="page-shell">
    <div class="container form-shell">
        <div class="form-card">
            <span class="kicker">Create account</span>
            <h1 class="page-title">Register</h1>
            <p class="page-subtitle">Build your account and verify your email before accessing the dashboard.</p>

            <form method="POST" action="/register">
                <?= csrf_field() ?>
                <div class="form-grid">
                    <div class="form-group full">
                        <label class="label" for="name">Full name</label>
                        <input class="input" id="name" name="name" value="<?= e(old('name')) ?>" required>
                        <?php if (! empty($errors['name'])): ?><div class="error-text"><?= e($errors['name']) ?></div><?php endif; ?>
                    </div>

                    <div class="form-group full">
                        <label class="label" for="email">Email address</label>
                        <input class="input" id="email" type="email" name="email" value="<?= e(old('email')) ?>" required>
                        <?php if (! empty($errors['email'])): ?><div class="error-text"><?= e($errors['email']) ?></div><?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label class="label" for="password">Password</label>
                        <input class="input" id="password" type="password" name="password" required>
                        <?php if (! empty($errors['password'])): ?><div class="error-text"><?= e($errors['password']) ?></div><?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label class="label" for="password_confirmation">Confirm password</label>
                        <input class="input" id="password_confirmation" type="password" name="password_confirmation" required>
                        <?php if (! empty($errors['password_confirmation'])): ?><div class="error-text"><?= e($errors['password_confirmation']) ?></div><?php endif; ?>
                    </div>
                </div>

                <button class="button" type="submit">Create account</button>
            </form>

            <p class="form-help">Already registered? <a href="/login">Sign in here</a>.</p>
        </div>
    </div>
</section>
