<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');
$routes->get('/welcome', 'Welcome::index');
/*$routes->get('/hello', 'Hello::index');
*/