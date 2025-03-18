<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Domain\Services\AuthService;
use Exception;

class AuthController extends ResourceController
{
    protected $authService;

    public function __construct()
    {
        $this->authService = new AuthService();
    }

    public function register()
    {
        try {
            $data = $this->request->getJSON(true); // Obtener datos en formato JSON
            $message = $this->authService->register($data);

            return $this->respond(['success' => true, 'message' => $message], 201);
        } catch (Exception $e) {
            return $this->fail($e->getMessage(), 400);
        }
    }
}
