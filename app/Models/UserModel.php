<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users'; // Nombre de la tabla en la base de datos
    protected $primaryKey = 'id'; // Clave primaria

    protected $allowedFields = [
        'name', 'email', 'password'
    ];

    protected $returnType = 'array';
    protected $useTimestamps = false; // Manejo automático de timestamps
}
