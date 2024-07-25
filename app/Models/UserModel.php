<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'first_name', 'last_name', 'email', 'password', 'user_type', 'city', 'state', 'zip'
    ];
    protected $useTimestamps = false;
}

