<!-- Begin Page Content -->
<div class="container-fluid">


    <!-- edit.php -->
    <div class="container-fluid">
        <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

        <div class="row">
            <div class="col-lg-6">
                <?= form_error('menu', '<div class="alert alert-danger" role="alert">', '</div>'); ?>

                <?= $this->session->flashdata('message'); ?>

                <form action="<?= base_url('menu/edit/' . $menu['id']); ?>" method="post">
                    <div class="form-group">
                        <input type="text" class="form-control" id="menu" name="menu" value="<?= $menu['menu']; ?>" placeholder="Menu Name">
                    </div>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->
</div>
<!-- End of Main Content -->