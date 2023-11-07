<?php

use CodeIgniter\Router\RouteCollection;

/**
 * Routing dibuat berkelompok berdasarkan role yang dapat mengakses
 * 
 * @var RouteCollection $routes
 */

//  Filter authentikasi, hanya pengunjung yang telah memiliki session (telah login) yang dapat mengakses
$routes->group('',['filter' => 'session'], function ($routes) {
    // Halaman yang dapat diakses seluruh role
    $routes->get('/', 'Dashboard::index');

    // Halaman untuk role operator, verifikator dan admin kabupaten
    // Berkenaan dengan manajemen konten pada website front end, khususnya pada riwayat pengajuan perubahan
    $routes->group('',['filter' => 'group:operator,verifikator,adminkab'], function ($routes) {
        $routes->get('/profiledesa', 'ProfilDesa\ProfileDesa::index');
        $routes->get('/profiledesa/(:any)', 'ProfilDesa\ProfileDesa::profile/$1');
        $routes->get('/pengajuanprofiledesa', 'ProfilDesa\PengajuanProfileDesa::index');
        $routes->get('/pengajuanstrukturdesa', 'StrukturDesa\PengajuanStrukturDesa::index');
        $routes->get('/daftarpengajuanstruktur', 'StrukturDesa\DaftarPengajuanStruktur::index');
        $routes->get('/daftarpengajuanstruktur/(:any)', 'StrukturDesa\DaftarPengajuanStruktur::view/$1');
        $routes->get('/strukturdesa', 'StrukturDesa\StrukturDesa::index');
        $routes->get('/skagen', 'SkAgen\SkAgen::index');
        $routes->get('/daftarskagenstatistik', 'SkAgen\DaftarPengajuanSkAgen::index');
        $routes->get('/daftarskagenstatistik/(:any)', 'SkAgen\DaftarPengajuanSkAgen::view/$1');
        $routes->get('/daftarpengajuanlaporan', 'Laporan\DaftarPengajuanLaporanBulanan::index');
        $routes->get('/daftarpengajuanlaporan/(:any)', 'Laporan\DaftarPengajuanLaporanBulanan::view/$1');
        $routes->get('/laporanbulanan', 'Laporan\LaporanBulanan::index');
        $routes->get('/laporanbulanan/(:any)', 'Laporan\LaporanBulanan::view/$1');
    });

    // Halaman untuk role operator
    // Berkenaan dengan pengajuan perubahan konten untuk website front end
    $routes->group('',['filter' => 'group:operator'], function ($routes) {
        $routes->post('/pengajuanprofiledesa', 'ProfilDesa\PengajuanProfileDesa::pengajuan');
        $routes->post('/pengajuanstrukturdesa', 'StrukturDesa\PengajuanStrukturDesa::pengajuan');
        $routes->post('/aktifstrukturdesa/(:any)', 'StrukturDesa\StrukturDesa::edit/$1');
        $routes->get('/editstrukturdesa/(:any)', 'StrukturDesa\EditStrukturDesa::index/$1');
        $routes->post('/editstrukturdesa/(:any)', 'StrukturDesa\EditStrukturDesa::edit/$1');
        $routes->delete('/profiledesa/(:num)', 'ProfilDesa\ProfileDesa::delete/$1');
        $routes->delete('/daftarpengajuanstruktur/(:num)', 'StrukturDesa\DaftarPengajuanStruktur::delete/$1');
        $routes->delete('/daftarskagenstatistik/(:num)', 'SkAgen\DaftarPengajuanSkAgen::delete/$1');
        $routes->get('/pengajuanskagen', 'SkAgen\PengajuanSkAgen::index');
        $routes->post('/pengajuanskagen', 'SkAgen\PengajuanSkAgen::pengajuan');
        $routes->post('/hapusskagen/(:any)', 'SkAgen\SkAgen::hapus/$1');
        $routes->get('/editskagen/(:any)', 'SkAgen\EditSkAgen::index/$1');
        $routes->post('/editskagen/(:any)', 'SkAgen\EditSkAgen::pengajuan/$1');
        $routes->get('/pengajuanlaporan', 'Laporan\PengajuanLaporan::index');
        $routes->post('/pengajuanlaporan', 'Laporan\PengajuanLaporan::pengajuan');
        $routes->delete('/daftarpengajuanlaporan/(:num)', 'Laporan\DaftarPengajuanLaporanBulanan::delete/$1');
        $routes->post('/hapuslaporan/(:any)', 'Laporan\LaporanBulanan::hapus/$1');
        $routes->get('/editlaporan/(:any)', 'Laporan\EditLaporan::index/$1');
        $routes->post('/editlaporan/(:any)', 'Laporan\EditLaporan::pengajuan/$1');
    });
    
    // Halaman untuk verifikator dan admin kabupaten
    // Berkenaan dengan konfirmasi/persetujuan perubahan konten website front end
    $routes->group('',['filter' => 'group:verifikator,adminkab'], function ($routes) {
        $routes->post('/setujuiprofile/(:any)', 'ProfilDesa\ProfileDesa::setujui/$1');
        $routes->post('/tolakprofile/(:any)', 'ProfilDesa\ProfileDesa::tolak/$1');
        $routes->post('/setujuistruktur/(:any)', 'StrukturDesa\DaftarPengajuanStruktur::setujui/$1');
        $routes->post('/tolakstruktur/(:any)', 'StrukturDesa\DaftarPengajuanStruktur::tolak/$1');
        $routes->post('/setujuiskagen/(:any)', 'SkAgen\DaftarPengajuanSkAgen::setujui/$1');
        $routes->post('/tolakskagen/(:any)', 'SkAgen\DaftarPengajuanSkAgen::tolak/$1');
        $routes->post('/setujuilaporan/(:any)', 'Laporan\DaftarPengajuanLaporanBulanan::setujui/$1');
        $routes->post('/tolaklaporan/(:any)', 'Laporan\DaftarPengajuanLaporanBulanan::tolak/$1');
    });

    // Halaman untuk admin kabupaten
    // Berkenaan dengan manajemen sk pembina desa cantik
    $routes->group('',['filter' => 'group:adminkab'], function ($routes) {
        $routes->get('/skpembina', 'SkPembina\SkPembina::index');
        $routes->delete('/hapusskpembina/(:num)', 'SkPembina\SkPembina::delete/$1');
        $routes->get('/pengajuanskpembina', 'SkPembina\PengajuanSkPembina::index');
        $routes->post('/pengajuanskpembina', 'SkPembina\PengajuanSkPembina::pengajuan');
        $routes->get('/editskpembina/(:any)', 'SkPembina\EditSkPembina::index/$1');
        $routes->post('/editskpembina/(:any)', 'SkPembina\EditSkPembina::edit/$1');
    });

    // Halaman untuk admin kabupaten dan superadmin
    // Berkenaan dengan manajemen akun
    $routes->group('',['filter' => 'group:adminkab,superadmin'], function ($routes) {
        $routes->get('/users', 'Users::index');
        $routes->get('/users/(:num)', 'Users::detail/$1'); //ajax
        $routes->get('/users/edit/(:num)', 'Users::editview/$1');
        $routes->post('/users/edit/', 'Users::edit');
        $routes->get('/register', 'Auth\RegisterController::registerView');
        $routes->post('/register', 'Auth\RegisterController::registerAction');
        $routes->post('/nonaktifuser', 'Users::nonaktifuser');
        $routes->post('/resetpassword', 'Users::resetPasswordView');
        $routes->post('/resetpasswordaction', 'Users::resetPasswordAction');
    });

    // Halmaan untuk superadmin
    // Berkenaan dengan manajemen desa cantik dan SK desa cantik
    $routes->group('',['filter' => 'group:superadmin'], function ($routes) {
        $routes->get('/desa/(:any)', 'SkDescan\ListDesa::desa/$1'); // url ajax
        $routes->get('/listdesa', 'SkDescan\ListDesa::index');
        $routes->get('/listdesa/tambah', 'SkDescan\ListDesa::tambahview');
        $routes->post('/listdesa/tambah', 'SkDescan\ListDesa::tambahaction');
        $routes->get('/skdescan', 'SkDescan\SkDescan::index');
        $routes->get('/uploadskdescan', 'SkDescan\SkDescan::uploadview');
        $routes->post('/uploadskdescan', 'SkDescan\SkDescan::uploadpost');
        $routes->delete('/hapusskdescan/(:num)', 'SkDescan\SkDescan::hapus/$1');
        $routes->get('/editskdescan/(:num)', 'SkDescan\SkDescan::edit/$1');
        $routes->post('/editskdescan/(:num)', 'SkDescan\SkDescan::editaction/$1');
        $routes->post('/nonaktifdescan', 'SkDescan\ListDesa::nonaktif');
    });
});

// Alamat web yang terbuka
service('auth')->routes($routes, ['except' => ['login', 'register']]);
$routes->get('login', 'Auth\LoginController::loginView');
$routes->post('login', 'Auth\LoginController::loginAction');
