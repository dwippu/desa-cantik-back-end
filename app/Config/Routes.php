<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->group('',['filter' => 'session'], function ($routes) {
    $routes->get('/', 'Dashboard::index');
    $routes->group('',['filter' => 'group:operator,verifikator'], function ($routes) {
        $routes->get('/profiledesa', 'ProfileDesa::index');
        $routes->post('/profildesa', 'ProfileDesa::pengajuan');
        $routes->get('/strukturdesa', 'StrukturDesa::index');
    });
    $routes->group('',['filter' => 'group:superadmin'], function ($routes) {
        $routes->get('/users', 'Users::index');
        $routes->get('register', 'Auth\RegisterController::registerView');
        $routes->post('register', 'Auth\RegisterController::registerAction');
        $routes->get('/listdesa', 'ListDesa::index');
        $routes->get('/listdesa/tambah', 'ListDesa::tambahview');
        $routes->post('/listdesa/tambah', 'ListDesa::tambahaction');
    });
});

service('auth')->routes($routes, ['except' => ['login', 'register']]);
$routes->get('login', 'Auth\LoginController::loginView');
$routes->post('login', 'Auth\LoginController::loginAction');

