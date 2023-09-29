<?= $this->extend('superadmin_template'); ?>

<?= $this->Section('content'); ?>

<div class="container-fluid">
    <div class="card" style="background-color:#5D87FF;">
    <div class="card-body">
        <h2 class="fw-semibold mb-4 text-bg-primary">Daftar Akun</h2>
        <div class="card">
        <div class="card-body">

        <!-- Data Tables -->
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="data_tablesk">
                        <table id="user" class="table table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Kode Desa</th>
                                    <th>Terakhir Aktif</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($list as $row):?>
                                <tr>
                                    <td><?=$row['user_id']?></td>
                                    <td><?=$row['username']?></td>
                                    <td><?=$row['secret']?></td>
                                    <td><?=$row['group']?></td>
                                    <td><?=$row['kode_desa']?></td>
                                    <td><?=$row['last_active']?></td>
                                    <td><button class="btn btn-outline-primary rounded-pill"><i class="fa fa-search"></i>Edit</button></td>
                                </tr>
                            <?php endforeach;?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Data Tables -->

        </div>
        </div>
    </div>
    </div>
</div>

<?= $this->endSection(); ?>