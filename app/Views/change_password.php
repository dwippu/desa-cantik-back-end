<?= $this->extend('template'); ?>

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

                    <form action="/resetpasswordaction" method="post">
                        <?= csrf_field() ?>
                        <!-- Password -->
                        <div class="mb-2">
                            <input type="password" class="form-control" name="password" inputmode="text" autocomplete="new-password" placeholder="<?= lang('Auth.password') ?>" required />
                        </div>

                        <!-- Password (Again) -->
                        <div class="mb-4">
                            <input type="password" class="form-control" name="password_confirm" inputmode="text" autocomplete="new-password" placeholder="<?= lang('Auth.passwordConfirm') ?>" required />
                        </div>

                        <input type="hidden" name="old-password" value="<?= $old_password ?>">
                        <input type="hidden" name="id" value="<?= $id ?>">

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

<?php if(session('errors') !== null): ?>
    
<?php endif ?>

<?= $this->endSection() ?>
