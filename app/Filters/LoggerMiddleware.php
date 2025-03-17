<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use Config\Services;

class LoggerMiddleware implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $method = $request->getMethod();
        $uri = $request->getUri();
        $ip = $request->getIPAddress();

        log_message('info', "🐘  [REQUEST] {$method} {$uri} - IP: {$ip}");
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        $status = $response->getStatusCode();
        $uri = $request->getUri();

        if ($status >= 200 && $status < 400) {
            log_message('info', "🐘  [RESPONSE] {$status} - {$uri}");
        }
        else {
            log_message('error', "❌ [ERROR RESPONSE] {$status} - {$uri}");
        }
    }
}
