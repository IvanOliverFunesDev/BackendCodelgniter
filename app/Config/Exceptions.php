<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Debug\ExceptionHandler;
use CodeIgniter\Debug\ExceptionHandlerInterface;
use Psr\Log\LogLevel;
use Throwable;

/**
 * Setup how the exception handler works.No
 */
class Exceptions extends BaseConfig
{

    public bool $log = true;

    /**
     * --------------------------------------------------------------------------
     * DO NOT LOG STATUS CODES
     * --------------------------------------------------------------------------
     * Any status codes here will NOT be logged if logging is turned on.
     * By default, only 404 (Page Not Found) exceptions are ignored.
     *
     * @var list<int>
     */
    public array $ignoreCodes = [404];


    public string $errorViewPath = APPPATH . 'Views/errors';

    /**
     * --------------------------------------------------------------------------
     * HIDE FROM DEBUG TRACE
     * --------------------------------------------------------------------------
     * Any data that you would like to hide from the debug trace.
     * In order to specify 2 levels, use "/" to separate.
     * ex. ['server', 'setup/password', 'secret_token']
     *
     * @var list<string>
     */
    public array $sensitiveDataInTrace = [];

  
    public bool $logDeprecations = true;

    
    public string $deprecationLogLevel = LogLevel::WARNING;

    /*
     * DEFINE THE HANDLERS USED
     * --------------------------------------------------------------------------
     * Given the HTTP status code, returns exception handler that
     * should be used to deal with this error. By default, it will run CodeIgniter's
     * default handler and display the error information in the expected format
     * for CLI, HTTP, or AJAX requests, as determined by is_cli() and the expected
     * response format.
     *
     * Custom handlers can be returned if you want to handle one or more specific
     * error codes yourself like:
     *
     *      if (in_array($statusCode, [400, 404, 500])) {
     *          return new \App\Libraries\MyExceptionHandler();
     *      }
     *      if ($exception instanceOf PageNotFoundException) {
     *          return new \App\Libraries\MyExceptionHandler();
     *      }
     */
public function handler(int $statusCode, Throwable $exception): ExceptionHandlerInterface
{
    // Asignar nivel de log correcto
    $logLevel = ($statusCode >= 500) ? 'critical' : (($statusCode == 404) ? 'error' : 'warning');

    // Registrar el error en los logs
    log_message($logLevel, "💥 [ERROR] {$exception->getMessage()} - Code: {$statusCode}");

    // Obtener la instancia de la respuesta
    $response = service('response');

    // Si es una petición AJAX o se espera JSON, devolver JSON
    if (service('request')->isAJAX() || $this->isJsonExpected()) {
        $jsonResponse = [
            'success' => false,
            'error' => $exception->getMessage(),
            'code' => $statusCode,
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
            'trace' => $exception->getTrace() // Opcional: solo en desarrollo
        ];

        // Establecer la respuesta JSON
        $response->setStatusCode($statusCode)->setJSON($jsonResponse);

        // Enviar la respuesta y terminar la ejecución
        $response->send();
        exit;
    }

    // Si es un error 404, forzar una respuesta JSON manualmente
    if ($statusCode == 404) {
        $jsonResponse = [
            'success' => false,
            'error' => 'Página no encontrada',
            'code' => 404
        ];

        // Establecer la respuesta JSON
        $response->setStatusCode(404)->setJSON($jsonResponse);

        // Enviar la respuesta y terminar la ejecución
        $response->send();
        exit;
    }

    // Si no es AJAX ni un 404, usar el manejador por defecto
    return new ExceptionHandler($this);
}

private function isJsonExpected(): bool
{
    $request = service('request');
    $acceptHeader = $request->getHeaderLine('Accept');
    return strpos($acceptHeader, 'application/json') !== false;
}
}
