<?= $this->extend('superadmin_pages/superadmin_template'); ?>

<?= $this->Section('content'); ?>

<div class="container-fluid">
    <div class="card" style="background-color:#5D87FF;">
    <div class="card-body">
        <h2 class="fw-semibold mb-4 text-bg-primary">Daftar Desa Cantik</h2>
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
                                    <th>Kode</th>
                                    <th>Desa</th>
                                    <th>Kecamatan</th>
                                    <th>Kota/Kabupaten</th>
                                    <th>Provinsi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($desa as $row):?>
                                <tr>
                                    <td><?=$row['kode_desa']?></td>
                                    <td><?=$row['nama_desa']?></td>
                                    <td><?=$row['nama_kec']?></td>
                                    <td><?=$row['nama_kab']?></td>
                                    <td><?=$row['nama_prov']?></td>
                                    <td>
                                        <span><a class="btn btn-outline-primary rounded-pill" href="http://localhost:8085/<?=$row['kode_desa']?>" target="_blank">Visit</a></span>
                                    </td>
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