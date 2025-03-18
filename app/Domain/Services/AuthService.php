<?php

namespace App\Domain\Services;

use App\Domain\Repositories\UserRepository;
use App\Domain\Entities\User;

class AuthService
{
    protected $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
    }

    public function register(array $data)
    {
        // 1️⃣ Verificar si el email ya está registrado
        if ($this->userRepository->findByEmail($data['email'])) {
            throw new \Exception("El email ya está registrado.");
        }

        // 2️⃣ Crear un usuario con la Entidad (valida los datos)
        $user = new User([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => password_hash($data['password'], PASSWORD_DEFAULT) // 3️⃣ Encriptar la contraseña
        ]);

        // 4️⃣ Guardar en la base de datos usando el Repositorio
        $this->userRepository->createUser([
            'name' => $user->name,
            'email' => $user->email,
            'password' => $user->password
        ]);

        // 5️⃣ Devolver mensaje de éxito
        return "Usuario registrado correctamente.";
    }

    public function login($data)
    {
        $user = $this->userRepository->findByEmail($data['email']);
        if(!$user){
            throw new \Exception("Usuario no encontrado.");
        }

        if(!password_verify($data['password'],$user['password'])){
            throw new \Exception("Contraseña incorrecta.");
        }
    }
}
