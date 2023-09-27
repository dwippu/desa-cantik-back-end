<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Dashboard::index');
$routes->get('/profiledesa', 'ProfileDesa::index');
$routes->get('/strukturdesa', 'StrukturDesa::index');
