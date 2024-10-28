<?= $this->extend('auth/app') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>User Management</h1>
    <div>
        <a href="<?= site_url('admin/users/create') ?>" class="btn btn-primary me-2">Create New User</a>
        <a href="<?= site_url('admin/dashboard') ?>" class="btn btn-secondary">Dashboard</a>
    </div>
</div>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success">
        <?= session()->getFlashdata('success') ?>
    </div>
<?php endif; ?>
<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger">
        <?= session()->getFlashdata('error') ?>
    </div>
<?php endif; ?>

<table class="table table-bordered table-hover">
    <thead class="thead-dark">
        <tr>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($users)): ?>
            <?php foreach ($users as $user): ?>
            <tr>
                <td><?= esc($user['first_name']) ?></td>
                <td><?= esc($user['last_name']) ?></td>
                <td><?= esc($user['email']) ?></td>
                <td>
                    <a href="<?= site_url('admin/users/edit/' . $user['id']) ?>" class="btn btn-warning">Edit</a>
                    
                </td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="4" class="text-center">No users found.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<!-- Pagination links -->
<div class="d-flex justify-content-center mt-4">
    <?= $pager->links() ?>
</div>

<?= $this->endSection() ?>
