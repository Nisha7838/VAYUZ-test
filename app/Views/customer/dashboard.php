<?= $this->extend('auth/app') ?>

<?= $this->section('content') ?>




<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Welcome, <?= esc(session()->get('loggedUser')['first_name']) ?>!</h1>
    <div>
        <button class="btn btn-danger" onclick="confirmLogout()">Logout</button>
    </div>
</div>

<!-- Display last login details -->
<p class="text-muted">Last Login: <strong><?= format_last_login(session()->get('loggedUser')['last_login']) ?></strong></p>

<script>
function confirmLogout() {
    if (confirm("Are you sure you want to logout?")) {
        window.location.href = "<?= site_url('logout') ?>"; // Update with your actual logout URL
    }
}
</script>
<?= $this->endSection() ?>