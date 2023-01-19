<?php

namespace App\Controllers;

use App\Models\PrescriptionModel;
use App\Models\UserModel;

class DashboardController extends BaseController
{
    public function index()
    {
        $data = [];


        echo view('templates/header', $data);
        echo view('dashboard', $data);
        echo view('templates/footer', $data);
    }

    //doctor
    public function createPrescription()
    {
        $data = [];

        helper(['form']);

        if($this->request->getMethod() == 'post' && $this->request->getVar('getDataByPesel') == '1')
        {
            return 'dupa';



        }


        if($this->request->getMethod() == 'post')
        {
            $rules = [
//                'recommendation' => 'required',
//                'lastname' => 'required',
            ];

            if( !$this->validate($rules))
            {
                $data['validation'] = $this->validator;
            }
            else {
                $userEntity = (new UserModel())
                    ->where('pesel', $this->request->getVar('pesel'))
                    ->first();

                $patientId = $userEntity->getId();

                //change it later!
                if($userEntity==null)
                    $patientId = 0;

                $newPrescription = (new PrescriptionModel());

                $newData = [
                    'patient_id' => $patientId,
                    'author_id' => 5,
                    'recommendation' => '4fdf',
                    'medicines' => '4fdf',
                    'security_code' => '4fdf',
                ];


                $newPrescription->save($newData);
                $session = session();
                $session->setFlashdata('success', 'Successful Registration');
                return redirect()->to('/');
            }
        }

        echo view('templates/header', $data);
        echo view('new_prescription_form', $data);
        echo view('templates/footer', $data);
    }

    public function searchPrescription()
    {
        $data = [];



        echo view('templates/header', $data);
        echo view('search_prescription_form', $data);
        echo view('templates/footer', $data);
    }
}
