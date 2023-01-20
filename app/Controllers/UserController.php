<?php

namespace App\Controllers;

use App\Models\CustomModel;
use App\Models\UserModel;

class UserController extends BaseController
{
    public function index()
    {
//        $db = db_connect();
//        $model = new CustomModel($db);
//
//        $result = $model->test();
//
//        echo '<pre>';
//        print_r($result);
//        echo '</pre>';

        $data = [];

        helper(['form']);

        if($this->request->getMethod() == 'post')
        {
            $reqData = $this->request;

            $rules = [
                'password' => 'required|min_length[8]|max_length[255]|validateUser[email,password]',
            ];

            $defaultUser = null;

            if (str_contains($reqData->getVar('email'), '@'))
                $defaultUser = false;
            else
                $defaultUser = true;

            if (!$defaultUser) //doctor, admin, pharmacy
            {
                $rules['email'] = 'required|min_length[6]|max_length[50]|valid_email';
            }
            else //patient
            {
                $rules['email'] = 'required|min_length[3]|max_length[50]';
            }

            $errors = [
                'password' => [
                    'validateUser' => 'Email or Password dont match'
                ]
            ];

            if( !$this->validate($rules, $errors))
            {
                $data['validation'] = $this->validator;
            }
            else {
                $model = new UserModel();

                if (!$defaultUser) //doctor, admin, pharmacy
                    $user = $model->where('email', $this->request->getVar('email'))
                        ->first();
                else //patient
                    $user = $model->where('pesel', $this->request->getVar('email'))
                        ->first();

                $this->setUserSession($user);

                return redirect()->to('dashboard');
            }
        }

        echo view('templates/header', $data);
        echo view('login', $data);
        echo view('templates/footer', $data);
    }

    private function setUserSession($user)
    {
        $data = [
            'id' => $user['id'],
            'firstname' => $user['firstname'],
            'lastname' => $user['lastname'],
            'email' => $user['email'],
            'pesel' => $user['pesel'],
            'role' => $user['role'],
            'isLoggedIn' => true,
        ];

        session()->set($data);
        return true;
    }

    public function register()
    {
        $data = [];

        $data['categories'] = [
            'DOCTOR',
            'PHARMACIST',
            'ADMIN',
            'PATIENT'
        ];

        helper(['form']);

        if($this->request->getMethod() == 'post')
        {
            //lets do validation here
            $rules = [
                'firstname' => 'required|min_length[3]|max_length[20]',
                'lastname' => 'required|min_length[3]|max_length[20]',
                //'email' => 'required|min_length[6]|max_length[50]|valid_email|is_unique[users.email]',
                'password' => 'required|min_length[8]|max_length[255]',
                'password_confirm' => 'matches[password]',
                'role' => 'in_list[DOCTOR, PHARMACIST, ADMIN, PATIENT]',
            ];

            if( !$this->validate($rules))
            {
                $data['validation'] = $this->validator;
            }
            else {
                $model = new UserModel();

                $newData = [
                    'firstname' => $this->request->getVar('firstname'),
                    'lastname' => $this->request->getVar('lastname'),
                    'email' => $this->request->getVar('email'),
                    'password' => $this->request->getVar('password'),
                    'role' => $this->request->getVar('role'),
                    'pesel' => $this->request->getVar('pesel'),
                ];
                $model->save($newData);
                $session = session();
                $session->setFlashdata('success', 'Successful Registration');
                return redirect()->to('/');
            }
        }

        echo view('templates/header', $data);
        echo view('register', $data);
        echo view('templates/footer', $data);
    }

    public function profile()
    {
        $data = [];
        helper(['form']);
        $model = new UserModel();

        if($this->request->getMethod() == 'post')
        {
            //lets do validation here
            $rules = [
                'firstname' => 'required|min_length[3]|max_length[20]',
                'lastname' => 'required|min_length[3]|max_length[20]',
            ];

            if($this->request->getPost('password') != '')
            {
                $rules['password'] = 'required|min_length[3]|max_length[20]';
                $rules['password_confirm'] = 'matches[password]';
            }

            if( !$this->validate($rules))
            {
                $data['validation'] = $this->validator;
            }
            else {
                $model = new UserModel();

                $newData = [
                    'id' => session()->get('id'),
                    'firstname' => $this->request->getPost('firstname'),
                    'lastname' => $this->request->getPost('lastname'),
                ];

                if($this->request->getPost('password') != '')
                {
                    $newData['password'] = $this->request->getPost('password');
                }

                $model->save($newData);
                session()->setFlashdata('success', 'Successfuly Updated');
                return redirect()->to('/profile');
            }
        }

        $data['user'] = $model->where('id', session()->get('id'))->first();

        echo view('templates/header', $data);
        echo view('profile');
        echo view('templates/footer', $data);
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/');
    }
}
