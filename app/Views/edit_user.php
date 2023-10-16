<?php
  if(auth()->user()->inGroup('adminkab')) {echo $this->extend('template');}
  if(auth()->user()->inGroup('superadmin')) {echo $this->extend('superadmin_pages/superadmin_template');}
?>

<?= $this->Section('content'); ?>

<div class="container-fluid">
    <div class="card" style="background-color:#5D87FF;">
    <div class="card-body">
        <h2 class="fw-semibold mb-4 text-bg-primary">Edit Informasi Akun</h2>
        <div class="card">
        <div class="card-body">

        <!-- Start Form -->
        <div class="container d-flex justify-content-center p-5">
            <div class="col-5 shadow-md">

                    <?php if (session('error') !== null) : ?>
                        <div class="alert alert-danger" role="alert"><?= session('error') ?></div>
                    <?php elseif (session('errors') !== null) : ?>
                        <div class="alert alert-danger" role="alert">
                            <?php if (is_array(session('errors'))) : ?>
                                <?php foreach (session('errors') as $error) : ?>
                                    <?= $error ?>
                                    <br>
                                <?php endforeach ?>
                            <?php else : ?>
                                <?= session('errors') ?>
                            <?php endif ?>
                        </div>
                    <?php endif ?>
                    <?php if (session('message') !== null) : ?>
                        <div class="alert alert-success" role="alert"><?= session('message') ?></div>
                    <?php endif ?>

                    <form action="/users/edit" method="post">
                        <?= csrf_field() ?>
                        <input type="hidden" name="id" value="<?= $user['user_id'] ?>">
                        <!-- Email -->
                        <div class="mb-4">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" inputmode="email" autocomplete="email" value="<?= $user['secret'] ?>" required />
                        </div>

                        <!-- Username -->
                        <div class="mb-4">
                            <label for="username" class="form-label">Nama</label>
                            <input type="text" class="form-control" name="username" inputmode="text" autocomplete="username" value="<?= $user['username'] ?>" required />
                        </div>

                        <!-- Role -->
                        <div class="mb-4">
                            <label for="role" class="form-label">Role</label>    
                            <select class="form-select" name="role" id="role" required>
                                <option disabled value="">Pilih Role</option>
                                <?php if (auth()->user()->inGroup('superadmin')): ?>
                                <option <?php if($user['group']=='adminkab') {echo 'selected';} ?> value="adminkab">Admin Kabupaten/Kota</option>
                                <?php endif ?>                                
                                <option <?php if($user['group']=='operator') {echo 'selected';} ?> value="operator">Operator Desa</option>
                                <option <?php if($user['group']=='verifikator') {echo 'selected';} ?> value="verifikator">Verifikator Desa</option>
                            </select>
                        </div>      

                        <!-- Kode Desa -->
                        <?php if(auth()->user()->inGroup('adminkab')): ?>
                        <div class="mb-5">
                        <label for="kode_desa" class="form-label">Desa</label>
                            <select class="form-select" name="kode_desa" id="kode_desa" required>
                                <option disabled value="">Pilih Desa</option>
                                <?php foreach ($list as $list): ?>
                                    <option <?php if($list['kode_desa'] == $user['kode_desa']) {echo 'selected';} ?> value="<?= $list['kode_desa'] ?>"> <?= $list['nama_desa'] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <?php endif ?>

                        <?php if(auth()->user()->inGroup('superadmin')): ?>
                        <div class="mb-2">
                            <select class="form-select" name="kode_kab" id="pilih_kabupaten" required>
                                <option disabled value=''>-- Pilih Kabupaten --</option>
                                <?php foreach ($kab as $i): ?>
                                    <option <?php if($i['kab'] == substr($user['kode_desa'],2,2)) {echo 'selected';} ?> value="<?= $i['kab'] ?>"><?= $i['nama_kab'] ?></option>
                                <?php endforeach;?>
                            </select>
                        </div>
                        <input id="input_hidden" type="hidden" name="kode_desa" value="" disabled>
                        
                        <div class="mb-5">
                        <select class="form-select" name="kode_desa" id="pilih_desa" <?php if($user['group']=='adminkab') {echo 'hidden disabled';} ?>>
                            <option selected value=''>-- Pilih Desa --</option>
                            <?php foreach ($list as $list): ?>
                                <option <?php if($list['kode_desa'] == $user['kode_desa']) {echo 'selected';} ?> value="<?= $list['kode_desa'] ?>"> <?= $list['nama_desa'] ?></option>
                            <?php endforeach ?>
                        </select>
                        </div>
                        <?php endif ?>

                        <div class="d-grid col-12 col-md-8 mx-auto m-3">
                            <button type="submit" class="btn btn-primary btn-block">Simpan</button>
                        </div>

                    </form>

            </div>
        </div>
        <!-- End Form -->

        </div>
        </div>
    </div>
    </div>
</div>

<?= $this->endSection() ?>
