<?= $this->extend('template'); ?>

<?= $this->Section('content'); ?>
    <div class="container-fluid">
        <!-- Data Kepala -->
        <div class="card" style="background-color:#5D87FF;">
        <div class="card-body">
            <h2 class="fw-semibold mb-4 text-bg-primary">Struktur Desa</h2>
            <div class="card">
            <div class="card-body">
                <h4 class=" fw-semibold mb-4">Data Kepala Desa</h4>
                <form>
                    <div class="mb-3">
                        <label for="namaKepala" class="form-label">Nama</label>
                        <input id="namaKepala" name="namaKepala" type="text" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="emailKepala" class="form-label">E-mail</label>
                        <input type="emailKepala" id="emailKepala" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="igKepala" class="form-label">Instagram</label>
                        <input id="igKepala" name="ig" type="text" class="form-control" required>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
            </div>

            <!-- Data Sekretaris -->
            <div class="card">
            <div class="card-body">
                <h4 class="fw-semibold mb-4">Data Sekretaris Desa</h4>
                <form>
                    <div class="mb-3">
                        <label for="namaKepala" class="form-label">Nama</label>
                        <input id="namaKepala" name="namaKepala" type="text" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="emailKepala" class="form-label">E-mail</label>
                        <input type="emailKepala" id="email" name="emailKepala" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="igKepala" class="form-label">Instagram</label>
                        <input id="igKepala" name="igKepala" type="text" class="form-control" required>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
            </div>

            <!-- Data bendahara -->
            <div class="card">
            <div class="card-body">
                <h4 class="fw-semibold mb-4">Data Bendahara Desa</h4>
                <form>
                    <div class="mb-3">
                        <label for="namaBendahara" class="form-label">Nama</label>
                        <input id="namaBendahara" name="namaBendahara" type="text" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="emailBendahara" class="form-label">E-mail</label>
                        <input type="emailBendahara" id="email" name="emailBendahara" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="igBendahara" class="form-label">Instagram</label>
                        <input id="igBendahara" name="igBendahara" type="text" class="form-control" required>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
            </div>

            <!-- Data bendahara -->
            <div class="card">
            <div class="card-body">
                <h4 class="fw-semibold mb-4">Data Pembina Desa</h4>
                <form>
                    <div class="mb-3">
                        <label for="namaPembina" class="form-label">Nama</label>
                        <input id="namaPembina" name="namaPembina" type="text" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="emailPembina" class="form-label">E-mail</label>
                        <input type="emailPembina" id="email" name="emailPembina" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="igPembina" class="form-label">Instagram</label>
                        <input id="igPembina" name="igPembina" type="text" class="form-control" required>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
            </div>
        </div>
        </div>
    </div>
<?= $this->endSection(); ?>