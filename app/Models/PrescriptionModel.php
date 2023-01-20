<?php

namespace App\Models;

use CodeIgniter\Model;

class PrescriptionModel extends Model
{
    protected $table = 'prescription';
    protected $allowedFields = ['patient_id', 'author_id', 'recommendation', 'medicines', 'updated_at', 'security_code', 'status'];

    protected $useTimestamps = true;

    protected $beforeInsert = ['beforeInsert'];
    protected $beforeUpdate = ['beforeUpdate'];

    protected function beforeInsert(array $data)
    {
//        $data = $this->passwordHash($data);
//        $data = $this->setDefaultRole($data);

        return $data;
    }

    protected function beforeUpdate(array $data)
    {
//        $data = $this->passwordHash($data);

        return $data;
    }

//    protected function passwordHash(array $data)
//    {
//        if(isset($data['data']['password']))
//            $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
//
//        return $data;
//    }
//
//    protected function setDefaultRole(array $data)
//    {
//        $data['data']['role'] = 'PATIENT';
//
//        return $data;
//    }
}