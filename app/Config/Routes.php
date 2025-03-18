<?php

use CodeIgniter\Router\RouteCollection;
use App\Controllers\AuthController;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->post('auth/register', 'AuthController::register');

