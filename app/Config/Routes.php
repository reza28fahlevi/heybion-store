<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'User\Home::index');
$routes->get('uploads/(:any)/(:any)', 'Files::view/$1/$2');
$routes->get('product/(:any)', 'User\Home::product/$1');
$routes->get('getproduct/(:any)', 'User\Home::getProduct/$1');

$routes->get('mycart', 'User\Transactions::myCart');
$routes->get('getProvince', 'User\Transactions::getProvince');
$routes->post('getCity', 'User\Transactions::getCity');
$routes->get('getCost', 'User\Transactions::getCost');
$routes->post('addcart', 'User\Transactions::addCart');
$routes->post('updatecart', 'User\Transactions::updateCart');
$routes->post('removecart', 'User\Transactions::removeFromCart');

$routes->get('mytransaction', 'User\Transactions::myHistory');
$routes->get('getDetailInvoice/(:any)', 'User\Transactions::getDetailInvoice/$1');

$routes->post('createinvoice', 'User\Transactions::createInvoice');
$routes->post('paybill', 'User\Transactions::payBill');
$routes->post('finishorder', 'User\Transactions::finishOrder');

$routes->get('getaddress', 'User\Transactions::getAddress');
$routes->post('updateaddress', 'User\Transactions::updateAddress');

$routes->get('login', 'User\Login::index');
$routes->post('login', 'User\Login::login');
$routes->get('logout', 'User\Login::logout');
$routes->get('register', 'User\Register::index');
$routes->post('check', 'User\Register::checkExisting');
$routes->post('register', 'User\Register::createAccount');

// $routes->get('/hb-admin', 'Admin\Home::index');
$routes->group('hb-admin', static function ($routes) {
    $routes->get('/', 'Admin\Home::index');

    $routes->get('login', 'Admin\Login::index');
    $routes->post('login', 'Admin\Login::login');
    $routes->get('sign_out', 'Admin\Login::logout');

    $routes->get('need_confirmation', 'Admin\Transactions::needConfirm');
    $routes->get('waiting_delivery', 'Admin\Transactions::needDelivery');
    $routes->get('all_transactions', 'Admin\Transactions::allTransactions');
    $routes->post('transactions/getlist/(:any)', 'Admin\Transactions::getListTransactions/$1');
    $routes->get('transactions/getdetail/(:any)', 'Admin\Transactions::getDetailInvoice/$1');
    $routes->post('transactions/submit', 'Admin\Transactions::submit');

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
