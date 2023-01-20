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

        if($this->request->getMethod() == 'post' && $this->request->getVar('pesel') &&
            !$this->request->getVar('firstname') && !$this->request->getVar('lastname'))
        {
            $userEntity = (new UserModel())
                ->where('pesel', $this->request->getVar('pesel'))
                ->first();

            if($userEntity)
            {
                $data['pesel'] = $userEntity['pesel'];
                $data['firstname'] = $userEntity['firstname'];
                $data['lastname'] = $userEntity['lastname'];
                $data['email'] = $userEntity['email'];

            return view('templates/header', $data).
                view('new_prescription_form', $data).
                view('templates/footer', $data);
            }
        }


        if($this->request->getMethod() == 'post')
        {
            $successInfo = '';

            $rules = [
                'pesel' => 'required',
                'firstname' => 'required',
                'lastname' => 'required',
                'email' => 'required',
                'recommendation' => 'required',
                'medicines' => 'required',
            ];

            if( !$this->validate($rules))
            {
                $data['validation'] = $this->validator;
            }
            else {
                $userEntity = (new UserModel())
                    ->where('pesel', $this->request->getVar('pesel'))
                    ->first();

                if(!$userEntity)
                {
                    $newUser = new UserModel();

                    $newPassword = $this->randomPassword();

                    $newUserData = [
                        'firstname' => $this->request->getVar('firstname'),
                        'lastname' => $this->request->getVar('lastname'),
                        'email' => $this->request->getVar('email'),
                        'password' => $newPassword,
                        'role' => 'PATIENT',
                        'pesel' => $this->request->getVar('pesel'),
                    ];
                    $newUser->save($newUserData);

                    $userEntity = (new UserModel())
                        ->where('pesel', $this->request->getVar('pesel'))
                        ->first();

                    $patientId = $userEntity['id'];

                    $successInfo.='New patient added. ';
                }
                else
                {
                    $patientId = $userEntity['id'];
                }

                $userEntityDoctor = (new UserModel())
                    ->where('id', session()->get('id'))
                    ->first();

                $newPrescription = (new PrescriptionModel());

                $newData = [
                    'patient_id' => $patientId,
                    'author_id' => $userEntityDoctor['id'],
                    'recommendation' => $this->request->getVar('recommendation'),
                    'medicines' => $this->request->getVar('medicines'),
                    'security_code' => uniqid(),
                ];

                $newPrescription->save($newData);

                $successInfo.='Prescription created. ';

                $session = session();
                $session->setFlashdata('success', $successInfo);

                return view('templates/header', $data).
                    view('new_prescription_form', $data).
                    view('templates/footer', $data);
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

    private function randomPassword() {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }
}
