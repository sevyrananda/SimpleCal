<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'KalkulatorController::index'); // Route untuk menampilkan halaman utama/halaman project kalkulator
$routes->post('/', 'KalkulatorController::index'); // Route untuk melakukan 