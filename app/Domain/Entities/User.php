<?php

namespace App\Domain\Entities;

class User{
    public int $id;
    public string $name;
    public string $email;
    public string $password;

    public function __construct(array $data)
    {
        $this->id = $data['id'] ?? 0;
        $this->name = $this->validateName(trim($data['name']));
        $this->email = $this->validateEmail(trim($data['email']));
        $this->password = $data['password']; 
    }
    private function validateName(string $name):string{
        if(strlen($name) < 3){
            throw new \Exception("El nombre debe tener al menos 3 caracteres");
        }
        return htmlspecialchars(strip_tags($name)); // Sanitización básica 
    }
    private function validateEmail(string $email): string
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \Exception("El email no es válido.");
        }
        return $email;
    }
}