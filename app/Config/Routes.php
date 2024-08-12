<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'User\Home::index');
$routes->get('uploads/(:any)/(:any)', 'Files::view/$1/$2');
$routes->get('product/(:any)', 'User\Home::product/$1');
$routes->get('getproduct/(:any)', 'User\Home::getproduct/$1');
$routes->post('addcart', 'User\Transactions::addcart');

$routes->post('login', 'User\Login::login');

// $routes->get('/hb-admin', 'Admin\Home::index');
$routes->group('hb-admin', static function ($routes) {
    $routes->get('/', 'Admin\Home::index');

    $routes->get('login', 'Admin\Login::index');
    $routes->post('login', 'Admin\Login::login');
    $routes->get('sign_out', 'Admin\Login::logout');

    $routes->get('products', 'Admin\Products::index');
    $routes->post('products/fetch', 'Admin\Products::fetch');
    $routes->post('products/add', 'Admin\Products::add');
    $routes->get('products/getData/(:any)', 'Admin\Products::getProduct/$1');
    $routes->post('products/delete', 'Admin\Products::delete');
    $routes->post('products/update', 'Admin\Products::update');

    $routes->get('products/gallery/(:any)', 'Admin\Products::gallery/$1');
    $routes->post('products/fetchGallery', 'Admin\Products::fetchGallery');
    $routes->post('products/addGallery', 'Admin\Products::addGallery');
    $routes->post('products/deleteGallery', 'Admin\Products::deleteGallery');
});
