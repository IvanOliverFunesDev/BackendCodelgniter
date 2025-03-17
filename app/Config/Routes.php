<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('test-cors', function () {
    // log_message('error', '🔥 Probando log_message desde un controlador');
    // log_message('debug', "🔥 Esto es un debug log");
    // log_message('info', "ℹ Esto es un info log");
    // log_message('error', "❌ Esto es un error log");
    return response()->setJSON(['message' => 'CORS funciona correctamente']);    
});
$routes->get('test-error', function () {
    throw new \CodeIgniter\Exceptions\PageNotFoundException('💥 Esto es un error 404.');
});

$routes->get('test-error2', function () {
    throw new \Exception('💥 Esto es un error de prueba en CodeIgniter.');
});
