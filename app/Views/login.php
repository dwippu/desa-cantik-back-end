<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title><?= lang('Auth.login') ?></title>

    <link rel="shortcut icon" type="image/png" href="../assets/images/logos/logo.png" />
    <link rel="stylesheet" href="../assets/css/styles.min.css" />
</head>

<body class="bg-light">

  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <div
      class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
      <div class="d-flex align-items-center justify-content-center w-100">
        <div class="row justify-content-center w-100">
          <div class="col-md-8 col-lg-6 col-xxl-3">
            
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
          
            <div class="card mb-0">
              <div class="card-body">
                <a href="/" class="text-nowrap logo-img text-center d-block py-2 w-100">
                  <img src="/assets/images/logos/Descan Login.png" width="270" alt="">
                </a>
                <p class="text-center">Login ke Web Back End</p>
                <form action="<?= url_to('login') ?>" method="post">
                  <?= csrf_field() ?>

                  <!-- Email -->
                  <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Email</label>
                    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email" inputmode="email" autocomplete="email" placeholder="Alamat Email" required />
                  </div>
                  
                  <!-- Password -->
                  <div class="mb-4">
                    <label for="exampleInputPassword1" class="form-label">Password</label>
                    <input type="password" class="form-control" id="exampleInputPassword1" name="password" inputmode="text" autocomplete="current-password" placeholder="<?= lang('Auth.password') ?>" required />
                  </div>
                  
                  <div class="d-flex align-items-center justify-content-between mb-4">
                     
                    <!-- Remember me -->
                     <?php if (setting('Auth.sessionConfig')['allowRemembering']): ?>
                        <div class="form-check">
                        <input class="form-check-input primary" type="checkbox" value="" id="flexCheckChecked" <?php if (old('remember')): ?> checked<?php endif ?>>
                        <label class="form-check-label text-dark" for="flexCheckChecked">
                            Ingat Saya
                        </label>
                        </div>
                    <?php endif ?>
                    
                    <!-- Forgot Password -->
                    <?php if (setting('Auth.allowMagicLinkLogins')) : ?>
                        <a class="text-primary fw-bold" href="./index.html">Forgot Password ?</a>
                    <?php endif ?>
                  
                </div>
                  <button href="/" class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded-2" type="submit">Sign In</button>
                  
                  <!-- Register -->
                  <?php if (setting('Auth.allowRegistration')) : ?>
                    <div class="d-flex align-items-center justify-content-center">
                        <p class="fs-4 mb-0 fw-bold">New to Modernize?</p>
                        <a class="text-primary fw-bold ms-2" href="./authentication-register.html">Create an account</a>
                    </div>
                  <?php endif?>

                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
  <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>