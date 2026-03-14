<section class="page-shell">
    <div class="container">
        <span class="kicker">Authenticated area</span>
        <h1 class="page-title">Hello, <?= e($user['name']) ?></h1>
        <p class="page-subtitle">Your account is verified and active. This is where your protected application area starts.</p>

        <div class="dashboard-grid">
            <article class="stat-card">
                <h3>Account role</h3>
                <p class="lead"><span class="badge <?= $user['role'] === 'admin' ? 'badge-admin' : 'badge-user' ?>"><?= e(ucfirst($user['role'])) ?></span></p>
            </article>
            <article class="stat-card">
                <h3>Email status</h3>
                <p class="lead"><span class="badge badge-verified">Verified</span></p>
            </article>
            <article class="stat-card">
                <h3>Signed in as</h3>
                <p class="lead"><?= e($user['email']) ?></p>
            </article>
        </div>

        <div class="feature-grid" style="margin-top: 1.25rem;">
            <article class="card">
                <h3>Protected routes</h3>
                <p class="page-subtitle">The dashboard is guarded by both the authentication and verified-email middleware.</p>
            </article>
            <article class="card">
                <h3>Audit-ready</h3>
                <p class="page-subtitle">Important auth actions are written to the audit log table for review and debugging.</p>
            </article>
            <article class="card">
                <h3>Admin-aware</h3>
                <p class="page-subtitle">Admins can open the user management screen from the navigation bar.</p>
            </article>
        </div>
    </div>
</section>
