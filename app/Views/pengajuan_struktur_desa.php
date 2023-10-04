<?= $this->extend('template'); ?>

<?= $this->Section('content'); ?>
    <div class="container-fluid">

        <div class="card" style="background-color:#5D87FF;">
        <div class="card-body">
            <h2 class="fw-semibold mb-4 text-bg-primary">Struktur Desa</h2>
            <div class="card">
            <div class="card-body">
                <h4 class=" fw-semibold mb-4">Data Kepala Desa</h4>
                <form>
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input id="nama" name="nama" type="text" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="jabatan" class="form-label">Jabatan</label>
                        <select id="jabatan" name="jabatan" class="form-select" required>
                            <option value="">None</option>
                            <option value="Kepala Desa">Kepala Desa</option>
                            <option value="Sekretaris Desa">Sekretaris Desa</option>
                            <option value="Bendahara Desa">Bendahara Desa</option>
                            <option value="Pembina Desa">Pembina Desa</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">E-mail</label>
                        <input type="email" id="email" name="email" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="ig" class="form-label">Instagram</label>
                        <input id="ig" name="ig" type="text" class="form-control">
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
            </div>
        </div>
        </div>
    </div>
<?= $this->endSection(); ?>