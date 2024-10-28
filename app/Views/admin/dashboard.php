<?= $this->extend('auth/app') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Welcome, <?= esc(session()->get('loggedUser')['first_name']) ?>!</h1>
    <div>
        <a href="<?= base_url('admin/users') ?>" class="btn btn-primary">User Management</a>
        <button class="btn btn-danger" onclick="confirmLogout()">Logout</button>
    </div>
</div>

<!-- Display last login details -->
<p class="text-muted">Last Login: <strong><?= format_last_login(session()->get('loggedUser')['last_login']) ?></strong></p>

<p>Total Users: <strong><?= $totalUsers ?></strong></p>

<h3 class="mt-4">Last 5 Users:</h3>

<!-- Responsive table with Bootstrap classes -->
<div class="table-responsive">
    <table class="table table-bordered table-hover">
        <thead class="thead-dark">
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($recentUsers as $user): ?>
            <tr>
                <td><?= esc($user['first_name']) ?></td>
                <td><?= esc($user['last_name']) ?></td>
                <td><?= esc($user['email']) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>
function confirmLogout() {
    if (confirm("Are you sure you want to logout?")) {
        window.location.href = "<?= site_url('logout') ?>"; // Update with your actual logout URL
    }
}
</script>

<?= $this->endSection() ?>
