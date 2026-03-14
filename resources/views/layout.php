<?php
use App\Core\Auth;
use App\Core\Session;

$flash = Session::allFlash();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($title ?? config('app.name')) ?></title>
    <meta name="description" content="Secure PHP authentication starter with verification, reset flows, RBAC, and responsive UI.">
    <link rel="stylesheet" href="<?= e(asset('assets/css/app.css')) ?>">
</head>
<body>
<header class="site-header">
    <div class="container navbar">
        <a href="/" class="brand">
            <span class="brand-badge">S</span>
            <span><?= e(config('app.name')) ?></span>
        </a>

        <button class="nav-toggle" data-nav-toggle type="button">Menu</button>

        <nav class="nav-menu" data-nav-menu>
            <a class="nav-link <?= is_active('/') ?>" href="/">Home</a>

            <?php if (Auth::check()): ?>
                <a class="nav-link <?= is_active('/dashboard') ?>" href="/dashboard">Dashboard</a>
                <?php if (Auth::isAdmin()): ?>
                    <a class="nav-link <?= is_active('/admin/users') ?>" href="/admin/users">Admin</a>
                <?php endif; ?>
                <form method="POST" action="/logout">
                    <?= csrf_field() ?>
                    <button type="submit" class="nav-button">Sign Out</button>
                </form>
            <?php else: ?>
                <a class="nav-link <?= is_active('/login') ?>" href="/login">Sign In</a>
                <a class="button" href="/register">Create account</a>
            <?php endif; ?>
        </nav>
    </div>
</header>

<?php if ($flash): ?>
    <div class="container alert-stack">
        <?php foreach ($flash as $type => $message): ?>
            <?php if (is_string($message) && $message !== ''): ?>
                <div class="alert alert-<?= e($type) ?>"><?= e($message) ?></div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<main>
    <?= $content ?>
</main>

<footer class="site-footer">
    <div class="container footer-panel">
        Built with PHP, SQLite, and a very normal amount of paranoia.
    </div>
</footer>
<script src="<?= e(asset('assets/js/app.js')) ?>"></script>
</body>
</html>
