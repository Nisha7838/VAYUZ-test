<?= $this->extend('auth/app') ?>

<?= $this->section('content') ?>

<h1 class="mb-4">Edit User</h1>

<form action="<?= site_url('admin/users/update/' . $user['id']) ?>" method="POST">
    <div class="form-group">
        <label for="first_name">First Name</label>
        <input type="text" class="form-control" name="first_name" value="<?= $user['first_name'] ?>" required>
    </div>
    <div class="form-group">
        <label for="last_name">Last Name</label>
        <input type="text" class="form-control" name="last_name" value="<?= $user['last_name'] ?>" required>
    </div>
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" class="form-control" name="email" value="<?= $user['email'] ?>" required>
    </div>
    <div class="form-group">
        <label for="password">Password (leave blank to keep current password)</label>
        <input type="password" class="form-control" name="password">
    </div>
    <button type="submit" class="btn btn-primary">Update User</button>
</form>

<?= $this->endSection() ?>
