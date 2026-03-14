<section class="page-shell">
    <div class="container form-shell">
        <div class="form-card">
            <span class="kicker">Email verification required</span>
            <h1 class="page-title">Verify Your Email</h1>
            <p class="page-subtitle">
                We wrote a verification message to <strong>storage/mail/</strong>
                <?php if (! empty($email)): ?>for <strong><?= e($email) ?></strong><?php endif; ?>.
                Open the latest file and click the verification link.
            </p>
            <div class="inline-actions">
                <a class="button-secondary" href="/login">Back to sign in</a>
                <a class="button-ghost" href="/register">Create another account</a>
            </div>
        </div>
    </div>
</section>
