<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->group('',['filter' => 'session'], function ($routes) {
    $routes->get('/', 'Dashboard::index');
    $routes->group('',['filter' => 'group:operator,verifikator,adminkab'], function ($routes) {
        $routes->get('/profiledesa', 'ProfileDesa::index');
        $routes->get('/profiledesa/(:any)', 'ProfileDesa::profile/$1');
        $routes->get('/pengajuanprofiledesa', 'PengajuanProfileDesa::index');
        $routes->get('/pengajuanstrukturdesa', 'PengajuanStrukturDesa::index');
        $routes->get('/daftarpengajuanstruktur', 'DaftarPengajuanStruktur::index');
        $routes->get('/daftarpengajuanstruktur/(:any)', 'DaftarPengajuanStruktur::view/$1');
        $routes->get('/strukturdesa', 'StrukturDesa::index');
        $routes->get('/skagen', 'SkAgen::index');
        $routes->get('/daftarskagenstatistik', 'DaftarPengajuanSkAgen::index');
        $routes->get('/daftarskagenstatistik/(:any)', 'DaftarPengajuanSkAgen::view/$1');
        $routes->get('/daftarpengajuanlaporan', 'DaftarPengajuanLaporanBulanan::index');
        $routes->get('/daftarpengajuanlaporan/(:any)', 'DaftarPengajuanLaporanBulanan::view/$1');
        $routes->get('/laporanbulanan', 'LaporanBulanan::index');
        $routes->get('/laporanbulanan/(:any)', 'LaporanBulanan::view/$1');
    });
    $routes->group('',['filter' => 'group:operator'], function ($routes) {
        $routes->post('/pengajuanprofiledesa', 'PengajuanProfileDesa::pengajuan');
        $routes->post('/pengajuanstrukturdesa', 'PengajuanStrukturDesa::pengajuan');
        $routes->post('/aktifstrukturdesa/(:any)', 'StrukturDesa::edit/$1');
        $routes->get('/editstrukturdesa/(:any)', 'EditStrukturDesa::index/$1');
        $routes->post('/editstrukturdesa/(:any)', 'EditStrukturDesa::edit/$1');
        $routes->delete('/profiledesa/(:num)', 'ProfileDesa::delete/$1');
        $routes->delete('/daftarpengajuanstruktur/(:num)', 'DaftarPengajuanStruktur::delete/$1');
        $routes->delete('/daftarskagenstatistik/(:num)', 'DaftarPengajuanSkAgen::delete/$1');
        $routes->get('/pengajuanskagen', 'PengajuanSkAgen::index');
        $routes->post('/pengajuanskagen', 'PengajuanSkAgen::pengajuan');
        $routes->post('/hapusskagen/(:any)', 'SkAgen::hapus/$1');
        $routes->get('/editskagen/(:any)', 'EditSkAgen::index/$1');
        $routes->post('/editskagen/(:any)', 'EditSkAgen::pengajuan/$1');
        $routes->get('/pengajuanlaporan', 'PengajuanLaporan::index');
        $routes->post('/pengajuanlaporan', 'PengajuanLaporan::pengajuan');
        $routes->delete('/daftarpengajuanlaporan/(:num)', 'DaftarPengajuanLaporanBulanan::delete/$1');
        $routes->post('/hapuslaporan/(:any)', 'LaporanBulanan::hapus/$1');
        $routes->get('/editlaporan/(:any)', 'EditLaporan::index/$1');
        $routes->post('/editlaporan/(:any)', 'EditLaporan::pengajuan/$1');
    });
    $routes->group('',['filter' => 'group:verifikator,adminkab'], function ($routes) {
        $routes->post('/setujuiprofile/(:any)', 'ProfileDesa::setujui/$1');
        $routes->post('/tolakprofile/(:any)', 'ProfileDesa::tolak/$1');
        $routes->post('/setujuistruktur/(:any)', 'DaftarPengajuanStruktur::setujui/$1');
        $routes->post('/tolakstruktur/(:any)', 'DaftarPengajuanStruktur::tolak/$1');
        $routes->post('/setujuiskagen/(:any)', 'DaftarPengajuanSkAgen::setujui/$1');
        $routes->post('/tolakskagen/(:any)', 'DaftarPengajuanSkAgen::tolak/$1');
        $routes->post('/setujuilaporan/(:any)', 'DaftarPengajuanLaporanBulanan::setujui/$1');
        $routes->post('/tolaklaporan/(:any)', 'DaftarPengajuanLaporanBulanan::tolak/$1');
    });
    $routes->group('',['filter' => 'group:adminkab'], function ($routes) {
        $routes->get('/skpembina', 'SkPembina::index');
        $routes->delete('/hapusskpembina/(:num)', 'SkPembina::delete/$1');
        $routes->get('/pengajuanskpembina', 'PengajuanSkPembina::index');
        $routes->post('/pengajuanskpembina', 'PengajuanSkPembina::pengajuan');
        $routes->get('/editskpembina/(:any)', 'EditSkPembina::index/$1');
        $routes->post('/editskpembina/(:any)', 'EditSkPembina::edit/$1');
    });
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
    $routes->group('',['filter' => 'group:superadmin'], function ($routes) {
        $routes->get('/desa/(:any)', 'ListDesa::desa/$1'); // url ajax
        $routes->get('/listdesa', 'ListDesa::index');
        $routes->get('/listdesa/tambah', 'ListDesa::tambahview');
        $routes->post('/listdesa/tambah', 'ListDesa::tambahaction');
        $routes->get('/skdescan', 'SkDescan::index');
        $routes->get('/uploadskdescan', 'SkDescan::uploadview');
        $routes->post('/uploadskdescan', 'SkDescan::uploadpost');
        $routes->delete('/hapusskdescan/(:num)', 'SkDescan::hapus/$1');
        $routes->get('/editskdescan/(:num)', 'SkDescan::edit/$1');
        $routes->post('/editskdescan/(:num)', 'SkDescan::editaction/$1');
        $routes->post('/nonaktifdescan', 'ListDesa::nonaktif');
    });
});

service('auth')->routes($routes, ['except' => ['login', 'register']]);
$routes->get('login', 'Auth\LoginController::loginView');
$routes->post('login', 'Auth\LoginController::loginAction');
$routes->post('cobapost', 'ListDesa::coba');
$routes->delete('cobapost', 'ListDesa::coba');

