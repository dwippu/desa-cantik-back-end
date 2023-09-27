<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Dashboard::index');
$routes->get('/profiledesa', 'ProfileDesa::index');
$routes->get('/strukturdesa', 'StrukturDesa::index');

service('auth')->routes($routes, ['except' => ['login', 'register']]);
$routes->get('login', 'Auth\LoginController::loginView');
$routes->get('register', 'Auth\RegisterController::registerView');
$routes->post('register', 'Auth\RegisterController::registerAction');

