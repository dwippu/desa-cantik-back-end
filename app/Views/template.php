<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Desa Cantik - Jawa Barat</title>
  <link rel="shortcut icon" type="image/png" href="/assets/images/logos/Logo.png" />
  <link rel="stylesheet" href="/assets/css/styles.min.css" />

  <!-- Data Tables Stylesheet -->
  <link href="/assets/css/datatables.min.css" rel="stylesheet">
</head>

<body>
  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <!-- Sidebar Start -->
    <aside class="left-sidebar">
      <!-- Sidebar scroll-->
      <div>
        <div class="brand-logo d-flex align-items-center justify-content-between">
          <a href="./index.html" class="text-nowrap logo-img d-flex">
              <img src="/assets/images/logos/Logo.png" alt="logo" width="100%" height="50px" >
              <div class="pt-2 px-2">
                  <p  style="border:0; border-left: 1px; border-color:black; border-style:solid; padding-left:10%; color:#000;">
                    <b>PORTAL</b><br>Desa Cantik
                  </p>
              </div>
          </a>
          <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
            <i class="ti ti-x fs-8"></i>
          </div>
        </div>

        <!-- Sidebar navigation-->
        <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
          <ul id="sidebarnav">
            <li class="nav-small-cap">
              <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
              <span class="hide-menu">Home</span>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link <?php if (strcmp(uri_string(), "") == 0) echo 'active' ?>" href="/" aria-expanded="false">
                <span>
                  <i class="ti ti-layout-dashboard"></i>
                </span>
                <span class="hide-menu">Dashboard</span>
              </a>
            </li>
            <li class="nav-small-cap">
              <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
              <span class="hide-menu">PROFILE</span>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link <?php if (preg_match("/profiledesa$/", uri_string()) == 1) echo 'active' ?>" href="/profiledesa" aria-expanded="false">
                <span>
                  <i class="ti ti-user"></i>
                </span>
                <span class="hide-menu">Profile Desa</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link <?php if (strcmp(uri_string(), "strukturdesa") == 0) echo 'active' ?>" href="/strukturdesa" aria-expanded="false">
                <span>
                  <i class="ti ti-list"></i>
                </span>
                <span class="hide-menu">Struktur Desa</span>
              </a>
            </li>
            <li class="nav-small-cap">
              <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
              <span class="hide-menu">Data & INFORMASI</span>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="./icon-tabler.html" aria-expanded="false">
                <span>
                  <i class="ti ti-upload"></i>
                </span>
                <span class="hide-menu">Upload</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="./sample-page.html" aria-expanded="false">
                <span>
                  <i class="ti ti-pencil"></i>
                </span>
                <span class="hide-menu">Edit</span>
              </a>
            </li>
            <li class="nav-small-cap">
              <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
              <span class="hide-menu">Surat Keputusan</span>
            </li>
            <?php if(auth()->user()->inGroup('adminkab')): ?>
            <li class="sidebar-item">
              <a class="sidebar-link" href="./ui-alerts.html" aria-expanded="false">
                <span>
                  <i class="ti ti-file-description"></i>
                </span>
                <span class="hide-menu">SK Pembina Desa</span>
              </a>
            </li>
            <?php endif ?>
            <?php if(auth()->user()->inGroup('operator', 'verifikator')): ?>
            <li class="sidebar-item">
              <a class="sidebar-link <?php if (preg_match("/skagen$/", uri_string()) == 1) echo 'active' ?>" href="/skagen" aria-expanded="false">
                <span>
                  <i class="ti ti-receipt"></i>
                </span>
                <span class="hide-menu">SK Agen Statistik</span>
              </a>
            </li>
            <?php endif ?>
            <li class="nav-small-cap">
              <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
              <span class="hide-menu">LAPORAN</span>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="./authentication-login.html" aria-expanded="false">
                <span>
                  <i class="ti ti-clipboard"></i>
                </span>
                <span class="hide-menu">Laporan Pembinaan</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="./authentication-register.html" aria-expanded="false">
                <span>
                  <i class="ti ti-cards"></i>
                </span>
                <span class="hide-menu">Laporan Bulanan</span>
              </a>
            </li>
            <?php if (auth()->user()->inGroup('adminkab')): ?>
            <li class="nav-small-cap">
              <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
              <span class="hide-menu">MANAJEMEN AKUN</span>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link <?php if (strcmp(uri_string(), "users") == 0) echo 'active' ?>" href="/users" aria-expanded="false">
                <span>
                  <i class="ti ti-user"></i>
                </span>
                <span class="hide-menu">Daftar Akun</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link <?php if (strcmp(uri_string(), "register") == 0) echo 'active' ?>" href="/register" aria-expanded="false">
                <span>
                  <i class="ti ti-list"></i>
                </span>
                <span class="hide-menu">Tambah Akun</span>
              </a>
            </li>
            <?php endif ?>
          </ul>
        </nav>
        <!-- End Sidebar navigation -->
      </div>
      <!-- End Sidebar scroll-->
    </aside>
    <!--  Sidebar End -->
    <!--  Main wrapper -->
    <div class="body-wrapper">
      <!--  Header Start -->
      <header class="app-header">
        <nav class="navbar navbar-expand-lg navbar-light">
          <ul class="navbar-nav">
            <li class="nav-item d-block d-xl-none">
              <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse" href="javascript:void(0)">
                <i class="ti ti-menu-2"></i>
              </a>
            </li>
          </ul>
          <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
            <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
              <li class="nav-item dropdown">
                <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown"
                  aria-expanded="false">
                  <img src="/assets/images/profile/user-1.jpg" alt="" width="35" height="35" class="rounded-circle">
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
                  <div class="message-body">
                    <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                      <i class="ti ti-user fs-6"></i>
                      <p class="mb-0 fs-3"><?= auth()->user()->username ?></p>
                    </a>
                    <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                      <i class="ti ti-list-check fs-6"></i>
                      <?php if (auth()->user()->inGroup('operator')){
                          echo '<p class="mb-0 fs-3">OPERATOR</p>';
                        }elseif (auth()->user()->inGroup('verifikator')){
                          echo '<p class="mb-0 fs-3">VERIFIKATOR</p>';
                        }elseif (auth()->user()->inGroup('adminkab')){
                          echo '<p class="mb-0 fs-3">Admin Kabupaten</p>';
                        };
                      ?>
                    </a>
                    <a href="./logout" class="btn btn-outline-primary mx-3 mt-2 d-block">Logout</a>
                  </div>
                </div>
              </li>
            </ul>
          </div>
        </nav>
      </header>
      <!--  Header End -->
      <div class="container-fluid">

        <?= $this->renderSection('content'); ?>

        <div class="py-6 px-6 text-center">
          <p class="mb-0 fs-4">Design and Developed by <a href="https://adminmart.com/" target="_blank" class="pe-1 text-primary text-decoration-underline">AdminMart.com</a> Distributed by <a href="https://themewagon.com">ThemeWagon</a></p>
        </div>
      </div>
    </div>
  </div>
  <script src="/assets/libs/jquery/dist/jquery.min.js"></script>
  <script src="/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="/assets/js/sidebarmenu.js"></script>
  <script src="/assets/js/app.min.js"></script>
  <script src="/assets/libs/apexcharts/dist/apexcharts.min.js"></script>
  <script src="/assets/libs/simplebar/dist/simplebar.js"></script>
  <script src="/assets/js/dashboard.js"></script>
  <!-- Data Tables Javascript -->
  <script src="/assets/js/datatables/datatables.min.js"></script>
  <script src="/assets/js/datatables/custom.js"></script>

</body>

</html>