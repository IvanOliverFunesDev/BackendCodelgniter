<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('test-cors', function () {
    return response()->setJSON(['message' => 'CORS funciona correctamente']);
});
