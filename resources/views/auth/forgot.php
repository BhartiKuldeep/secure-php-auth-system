<section class="page-shell">
    <div class="container form-shell">
        <div class="form-card">
            <span class="kicker">Password reset</span>
            <h1 class="page-title">Forgot Password</h1>
            <p class="page-subtitle">Enter your email and we will write a reset link to the local mail log.</p>

            <form method="POST" action="/forgot-password">
                <?= csrf_field() ?>
                <div class="form-group">
                    <label class="label" for="email">Email address</label>
                    <input class="input" id="email" type="email" name="email" value="<?= e(old('email')) ?>" required>
                    <?php if (! empty($errors['email'])): ?><div class="error-text"><?= e($errors['email']) ?></div><?php endif; ?>
                </div>
                <button class="button" type="submit">Send reset link</button>
            </form>
        </div>
    </div>
</section>
