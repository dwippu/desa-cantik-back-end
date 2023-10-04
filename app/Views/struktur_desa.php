<?= $this->extend('template'); ?>

<?= $this->Section('content'); ?>

<div class="container-fluid">
    <div class="card bg-primary">
    <div class="card-body">
        <div class="card bg-primary">
        <div class="card-body" style="padding:0;">
            <h2 class="fw-semibold text-bg-primary" style="float: left;">Riwayat Pengajuan - Perubahan Struktur Desa</h2>
            <?php if (auth()->user()->inGroup('operator')): ?>
                <a type="button" class="btn btn-light m-1" href="/pengajuanstrukturdesa" style="float: right; box-shadow: 0 6px 20px 0 rgba(0,0,0,0.19);">Ajukan Perubahan</a>
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
                                    <th>Kode Desa</th>
                                    <th>Keterangan</th>
                                    <th>Tanggal Pengajuan</th>
                                    <th>Tanggal Konfirmasi</th>
                                    <th>Detail</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
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