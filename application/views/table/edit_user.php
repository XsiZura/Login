    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

        <?= $this->session->flashdata('message'); ?>

        <form action="<?= base_url('table/edit_user/') . $user['id']; ?>" method="post">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($user['name']); ?>" placeholder="Enter New Name">
                <?= form_error('name', '<small class="text-danger">', '</small>'); ?>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($user['email']); ?>" placeholder="Enter New Email" readonly >
                <?= form_error('email', '<small class="text-danger">', '</small>'); ?>
            </div>


            <div class="form-group">
                <label for="role_id">Role</label>
                <select name="role_id" id="role_id" class="form-control">
                    <option value="">Select Role</option>
                    <?php foreach ($roles as $role): ?>
                        <option value="<?= $role['id']; ?>" <?= $role['id'] == $user['role_id'] ? 'selected' : ''; ?>>
                            <?= $role['role']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <?= form_error('role_id', '<small class="text-danger">', '</small>'); ?>
            </div>


            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" value="" placeholder="Enter New Password (optional)">
                <?= form_error('icon', '<small class="text-danger">', '</small>'); ?>
            </div>

            <div class="form-group">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="1" name="is_active" id="is_active">
                    <label for="is_active" class="form-check-label">Active?</label>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Save Changes</button>
            <a href="<?= base_url('table/index'); ?>" class="btn btn-secondary">Cancel</a>
        </form>

    </div>
    <!-- /.container-fluid -->
    </div>