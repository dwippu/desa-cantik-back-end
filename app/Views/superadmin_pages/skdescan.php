<?= $this->extend('superadmin_pages/superadmin_template'); ?>

<?= $this->Section('content'); ?>

<div class="container-fluid">
    <div class="card bg-primary">
    <div class="card-body">
        <div class="card bg-primary">
        <div class="card-body" style="padding:0;">
            <h2 class="fw-semibold text-bg-primary" style="float: left;">SK Desa Cantik BPS RI</h2>
            <a type="button" class="btn btn-light m-1" href="/uploadskdescan" style="float: right; box-shadow: 0 6px 20px 0 rgba(0,0,0,0.19);">Upload SK</a>
        </div>
        </div>
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
                                    <th>Tahun</th>
                                    <th>Nomor SK</th>
                                    <th>Tanggal SK</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach($sk as $sk): ?>
                                <tr>
                                    <td><?= $sk['tahun'] ?></td>
                                    <td><?= $sk['nomor_sk'] ?></td>
                                    <td><?= $sk['tanggal_sk'] ?></td>
                                    <td><?= $sk['status'] ?></td>
                                    <td>
                                        <button class="btn btn-outline-primary rounded-pill"><i class="fa fa-search"></i>View</button>
                                        <button class="btn btn-outline-primary rounded-pill"><i class="fa fa-search"></i>Edit</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
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