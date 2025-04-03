<?php

namespace App\Models;

use App\Base\Model;

class User extends Model
{
    protected string $model = 'users';  

    public function getUserById(int $userId): ?array
    {
        $this->searchById($userId);
        return $this->getData() ?? null;
    }
}