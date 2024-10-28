<?= $this->extend('auth/app') ?>

<?= $this->section('content') ?>

<h1 class="mb-4">Create User</h1>

<form action="<?= site_url('admin/users/store') ?>" method="POST">
    <div class="form-group">
        <label for="first_name">First Name</label>
        <input type="text" class="form-control" name="first_name" required>
    </div>
    <div class="form-group">
        <label for="last_name">Last Name</label>
        <input type="text" class="form-control" name="last_name" required>
    </div>
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" class="form-control" name="email" required>
    </div>
    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" class="form-control" name="password" required>
    </div>
    <button type="submit" class="btn btn-success">Create User</button>
</form>

<?= $this->endSection() ?>
