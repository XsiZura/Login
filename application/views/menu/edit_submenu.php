<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <?= $this->session->flashdata('message'); ?>

    <form action="<?= base_url('menu/edit_submenu/' . $submenu['id']); ?>" method="post">
        <div class="form-group">
            <label for="title">Sub Menu Title</label>
            <input type="text" class="form-control" id="title" name="title" value="<?= set_value('title', $submenu['title']); ?>" placeholder="Sub Menu Title">
            <?= form_error('title', '<small class="text-danger">', '</small>'); ?>
        </div>

        <div class="form-group">
            <label for="menu_id">Menu</label>
            <select name="menu_id" id="menu_id" class="form-control">
                <option value="">Select Menu</option>
                <?php foreach ($menu as $m) : ?>
                    <option value="<?= $m['id']; ?>" <?= ($submenu['menu_id'] == $m['id']) ? 'selected' : ''; ?>><?= $m['menu']; ?></option>
                <?php endforeach; ?>
            </select>
            <?= form_error('menu_id', '<small class="text-danger">', '</small>'); ?>
        </div>

        <div class="form-group">
            <label for="url">URL</label>
            <input type="text" class="form-control" id="url" name="url" value="<?= set_value('url', $submenu['url']); ?>" placeholder="Sub Menu URL">
            <?= form_error('url', '<small class="text-danger">', '</small>'); ?>
        </div>

        <div class="form-group">
            <label for="icon">Icon</label>
            <input type="text" class="form-control" id="icon" name="icon" value="<?= set_value('icon', $submenu['icon']); ?>" placeholder="Sub Menu Icon">
            <?= form_error('icon', '<small class="text-danger">', '</small>'); ?>
        </div>

        <div class="form-group">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="1" name="is_active" id="is_active" <?= ($submenu['is_active'] == 1) ? 'checked' : ''; ?>>
                <label for="is_active" class="form-check-label">Active?</label>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Save Changes</button>
        <a href="<?= base_url('menu/submenu'); ?>" class="btn btn-secondary">Cancel</a>
    </form>

</div>
<!-- /.container-fluid -->
</div>