<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// $routes->get('/hb-admin', 'Admin\Home::index');
$routes->group('hb-admin', static function ($routes) {
    $routes->get('/', 'Admin\Home::index');

    $routes->get('products', 'Admin\Products::index');
});
