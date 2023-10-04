<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->group('',['filter' => 'session'], function ($routes) {
    $routes->get('/', 'Dashboard::index');
    $routes->group('',['filter' => 'group:operator,verifikator'], function ($routes) {
        $routes->get('/profiledesa', 'ProfileDesa::index');
        $routes->delete('/profiledesa/(:num)', 'ProfileDesa::delete/$1');
        $routes->get('/profiledesa/(:any)', 'ProfileDesa::profile/$1');
        $routes->get('/pengajuanprofiledesa', 'PengajuanProfileDesa::index');
        $routes->get('/pengajuanstrukturdesa', 'PengajuanStrukturDesa::index');
        $routes->post('/pengajuanprofiledesa', 'PengajuanProfileDesa::pengajuan');
        $routes->get('/strukturdesa', 'StrukturDesa::index');
        $routes->get('/skagen', 'SkAgen::index');
        $routes->get('/pengajuanskagen', 'PengajuanSkAgen::index');
        $routes->post('/pengajuanskagen', 'PengajuanSkAgen::pengajuan');
    });
    $routes->group('',['filter' => 'group:verifikator'], function ($routes) {
        $routes->post('/setujuiprofile/(:any)', 'ProfileDesa::setujui/$1');
        $routes->post('/tolakprofile/(:any)', 'ProfileDesa::tolak/$1');
    });
    $routes->group('',['filter' => 'group:superadmin'], function ($routes) {
        $routes->get('/users', 'Users::index');
        $routes->get('register', 'Auth\RegisterController::registerView');
        $routes->post('register', 'Auth\RegisterController::registerAction');
    });
});

service('auth')->routes($routes, ['except' => ['login', 'register']]);
$routes->get('login', 'Auth\LoginController::loginView');
$routes->post('login', 'Auth\LoginController::loginAction');

