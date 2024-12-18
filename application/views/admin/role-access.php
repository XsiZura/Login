<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>



    <div class="row">
        <div class="col-lg-6">
            <div class="table table-hover">
                <?= $this->session->flashdata('message'); ?>
                <h5>
                    Role : <?= $role['role']; ?>
                </h5>
                <table class="col-lg">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Menu</th>
                            <th scope="col">access</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($menu as $m) : ?>
                            <tr>
                                <th scope="row"><?= $i++; ?></th>
                                <td><?= $m['menu']; ?></td>
                                <td>
                                    <div class="input-group mb-3">
                                        <input class="form-check-input mt-0"
                                            type="checkbox"
                                            <?= isset($role['id'], $m['id']) ? check_access($role['id'], $m['id']) : ''; ?>
                                            data-role="<?= isset($role['id']) ? $role['id'] : ''; ?>"
                                            data-menu="<?= isset($m['id']) ? $m['id'] : ''; ?>">
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->