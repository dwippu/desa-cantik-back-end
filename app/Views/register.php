<?= $this->extend('superadmin_template'); ?>

<?= $this->Section('content'); ?>

<div class="container-fluid">
    <div class="card" style="background-color:#5D87FF;">
    <div class="card-body">
        <h2 class="fw-semibold mb-4 text-bg-primary">Tambahkan Akun</h2>
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

                    <form action="<?= url_to('register') ?>" method="post">
                        <?= csrf_field() ?>

                        <!-- Email -->
                        <div class="mb-2">
                            <input type="email" class="form-control" name="email" inputmode="email" autocomplete="email" placeholder="<?= lang('Auth.email') ?>" value="<?= old('email') ?>" required />
                        </div>

                        <!-- Username -->
                        <div class="mb-4">
                            <input type="text" class="form-control" name="username" inputmode="text" autocomplete="username" placeholder="<?= lang('Auth.username') ?>" value="<?= old('username') ?>" required />
                        </div>

                        <!-- Password -->
                        <div class="mb-2">
                            <input type="password" class="form-control" name="password" inputmode="text" autocomplete="new-password" placeholder="<?= lang('Auth.password') ?>" required />
                        </div>

                        <!-- Password (Again) -->
                        <div class="mb-4">
                            <input type="password" class="form-control" name="password_confirm" inputmode="text" autocomplete="new-password" placeholder="<?= lang('Auth.passwordConfirm') ?>" required />
                        </div>

                        <!-- Role -->
                        <div class="mb-2">
                            <select class="form-select" name="role" id="role">
                                <option selected disabled value=''>Pilih Role</option>
                                <option value="operator">Operator</option>
                                <option value="verifikator">Verifikator</option>
                            </select>
                        </div>    

                        <!-- Kode Desa -->
                        <div class="mb-5">
                            <input type="text" class="form-control" name="kode_desa" inputmode="text" placeholder="Kode Desa" required />
                        </div>


                        <div class="d-grid col-12 col-md-8 mx-auto m-3">
                            <button type="submit" class="btn btn-primary btn-block">Tambahkan Akun</button>
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
