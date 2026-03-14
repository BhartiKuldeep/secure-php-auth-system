<section class="page-shell">
    <div class="container">
        <span class="kicker">Admin only</span>
        <h1 class="page-title">User Administration</h1>
        <p class="page-subtitle">A simple responsive user table that demonstrates role-based access control.</p>

        <div class="panel table-wrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Verification</th>
                        <th>Created</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td>
                                <strong><?= e($user['name']) ?></strong>
                                <div class="table-subtext">ID #<?= e((string) $user['id']) ?></div>
                            </td>
                            <td><?= e($user['email']) ?></td>
                            <td>
                                <span class="badge <?= $user['role'] === 'admin' ? 'badge-admin' : 'badge-user' ?>">
                                    <?= e(ucfirst($user['role'])) ?>
                                </span>
                            </td>
                            <td>
                                <span class="badge <?= ! empty($user['email_verified_at']) ? 'badge-verified' : 'badge-pending' ?>">
                                    <?= ! empty($user['email_verified_at']) ? 'Verified' : 'Pending' ?>
                                </span>
                            </td>
                            <td><?= e($user['created_at']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>
