<?php

namespace App\Controllers;

use App\Models\CustomModel;
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
                        'role' => $this->request->getVar('role'),
                        'pesel' => $this->request->getVar('pesel'),
                    ];
                    $newUser->save($newUserData);

                    $userEntity = (new UserModel())
                        ->where('pesel', $this->request->getVar('pesel'))
                        ->first();

                    $patientId = $userEntity['id'];

                    $successInfo.='New patient added. ';
                    $data['newPassword'] = $newPassword;
                }
                else
                {
                    $patientId = $userEntity['id'];
                }

                $userEntityDoctor = (new UserModel())
                    ->where('id', session()->get('id'))
                    ->first();

                $newPrescription = (new PrescriptionModel());
                $securityCode = uniqid();

                //test
                //$filename = $_FILES["uploadfile"]["name"];
//                $filename = 'assets/qrcode.png';
//
//                if (file_exists($filename)) {
//
//                  //Open the required file in read mode
//                  $handle = fopen($filename, "r");
//
//                  //Read all bytes from the file and print
//                  $fileB = fread($handle, filesize($filename));
//                  echo $fileB;
//
//                  //Do not forget to clone open files
//                  fclose($handle);
//                    echo 'gitara';
//                }

                $newData = [
                    'patient_id' => $patientId,
                    'author_id' => $userEntityDoctor['id'],
                    'recommendation' => $this->request->getVar('recommendation'),
                    'medicines' => $this->request->getVar('medicines'),
                    'security_code' => $securityCode,
                    'status' => 'NEW',
                ];

                $newPrescription->save($newData);

                $successInfo.='Prescription created. ';
                $data['securityCode'] = $securityCode;

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

        $data['posts'] = [];

        if($this->request->getMethod() == 'post' && $this->request->getVar('pesel'))
        {
            $db = db_connect();
            $model = new CustomModel($db);

            $result = $model->all($this->request->getVar('pesel'));

            $data['posts'] = $result;
        }


        echo view('templates/header', $data);
        echo view('search_prescription_form', $data);
        echo view('templates/footer', $data);
    }

    public function detailsPrescription($id)
    {
        $data = [];

        $model = (new PrescriptionModel())
            ->where('id', $id)
            ->first();

        $data['prescription'] = $model;

        echo view('templates/header', $data);
        echo view('details_prescription_form', $data);
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

    //user
    public function prescriptionList()
    {
        $data = [];

        $data['posts'] = [];

        $db = db_connect();
        $model = new CustomModel($db);

        $result = $model->allUserPrescriptions(session()->get('id'));

        $data['posts'] = $result;


        echo view('templates/header', $data);
        echo view('prescription_list_form', $data);
        echo view('templates/footer', $data);
    }

    //pharmacy
    public function prescriptionRead()
    {
        $data = [];

        $data['posts'] = [];

        if($this->request->getMethod() == 'post' && $this->request->getVar('status'))
        {
            $readModel = (new PrescriptionModel())
                ->where('security_code', $this->request->getVar('security_code'))
                ->first();


            $model = new PrescriptionModel();

            $newData = [
                'id' => $readModel['id'],
                'status' => 'COMPLETED',
            ];

            $model->save($newData);

            $db = db_connect();
            $model = new CustomModel($db);

            $result = $model->getPrescriptionBySecurityCode($this->request->getVar('security_code'));

            $data['prescription'] = $result;
        }
        else if($this->request->getMethod() == 'post' && $this->request->getVar('security_code'))
        {
            $db = db_connect();
            $model = new CustomModel($db);

            $result = $model->getPrescriptionBySecurityCode($this->request->getVar('security_code'));

            $data['prescription'] = $result;
        }



        echo view('templates/header', $data);
        echo view('prescription_read_form', $data);
        echo view('templates/footer', $data);
    }
}
