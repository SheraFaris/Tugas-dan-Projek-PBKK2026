<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');
$routes->get('/welcome', 'Welcome::index');
/////
$routes->group('admin', ['namespace' => 'App\Controllers\Admin'], static function ($routes) {

    // READ
    $routes->get('products', 'Products::index');

    // CREATE
    $routes->get('products/add', 'Products::add');
    $routes->post('products/add', 'Products::add');

    // UPDATE
    $routes->get('products/edit/(:segment)', 'Products::edit/$1');
    $routes->post('products/edit/(:segment)', 'Products::edit/$1');

    // DELETE
    $routes->post('products/delete/(:segment)', 'Products::delete/$1');

});
