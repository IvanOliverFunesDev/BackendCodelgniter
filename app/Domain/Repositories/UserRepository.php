<?php

namespace App\Domain\Repositories;

use App\Models\UserModel;

class UserRepository
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function findByEmail(string $email)
    {
        return $this->userModel->where('email', $email)->first();
    }

    public function findById(int $id)
    {
        return $this->userModel->find($id);
    }

    public function createUser(array $data)
    {
        return $this->userModel->insert($data);
    }
}
