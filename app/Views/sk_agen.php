<?= $this->extend('template'); ?>

<?= $this->Section('content'); ?>

<div class="container-fluid">
    <div class="card bg-primary">
    <div class="card-body">
        <div class="card bg-primary">
        <div class="card-body" style="padding:0;">
            <h2 class="fw-semibold text-bg-primary" style="float: left;">Riwayat Pengajuan - SK Agen Desa</h2>
            <?php if (auth()->user()->inGroup('operator')): ?>
                <a type="button" class="btn btn-light m-1" href="/pengajuanskagen" style="float: right; box-shadow: 0 6px 20px 0 rgba(0,0,0,0.19);">Ajukan Perubahan</a>
            <?php endif?>
        </div>
        </div>
        <div class="card">
        <div class="card-body">

        <!-- Data Tables -->
        <div class="container">
            <div class="row">
                <div class="col-12">
                        <table id="rpdesa" class="table table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Operator</th>
                                    <th>Nama Desa</th>
                                    <th>Nomor SK</th>
                                    <th>Keterangan</th>
                                    <th>Tanggal Pengajuan</th>
                                    <th>Tanggal Konfirmasi</th>
                                    <th>Detail</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($sk_agen as $row):?>
                                    <tr>
                                        <td><?=$row['username']?></td>
                                        <td><?=$desa['nama_desa']?></td>
                                        <td><?=$row['nomor_sk']?></td>
                                        <td><?php if ($row['approval'] == 'disetujui'){
                                                    echo '<span class="badge bg-success rounded-3 fw-semibold">Disetujui</span>';
                                                }elseif ($row['approval'] == 'diajukan'){
                                                    echo '<span class="badge bg-secondary rounded-3 fw-semibold">Diajukan</span>';
                                                }elseif ($row['approval'] == 'ditolak'){
                                                    echo '<span class="badge bg-danger rounded-3 fw-semibold">Ditolak</span>';
                                                }
                                            ?>
                                        </td>
                                        <td><?=$row['tanggal_pengajuan']?></td>
                                        <td><?=$row['tanggal_konfirmasi']?></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                <?php endforeach;?>
                            </tbody>
                        </table>
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