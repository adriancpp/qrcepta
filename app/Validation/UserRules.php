<?php

namespace App\Validation;

use App\Models\UserModel;

class UserRules
{
    public function validateUser(string $str, string $fields, array $data)
    {
        if (str_contains($data['email'], '@'))
            $defaultUser = false;
        else
            $defaultUser = true;

        $model = new UserModel();

        if (!$defaultUser) //doctor, admin, pharmacy
        {
            $user = $model->where('email', $data['email'])
                ->first();
        }
        else //patient
        {
            $user = $model->where('pesel', $data['email'])
                ->first();
        }

        if(!$user)
            return false;

        return password_verify($data['password'], $user['password']);
    }
}