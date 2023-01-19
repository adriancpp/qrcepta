<?php

namespace App\Controllers;

class UserController extends BaseController
{
    public function index()
    {
        $data = [];

        helper(['form']);

        echo view('templates/header', $data);
        echo view('login', $data);
        echo view('templates/footer', $data);
    }

    public function register()
    {
        $data = [];

        helper(['form']);

        if($this->request->getMethod() == 'post')
        {
            $rules = [
                'firstname' => 'required|min_length[3]|max_length[20]',
                'lastname' => 'required|min_length[3]|max_length[20]',
                'email' => 'required|min_length[6]|max_length[50]|valid_email|is_unique[usersemail]',
                'password' => 'required|min_length[8]|max_length[255]',
                'password_confirm' => 'matches[password]',
            ];

            if( !$this->validate($rules))     //7;00
            {
                $data['validation'] = $this->validator;
            }
            else{
                //store the user in out db
            }
        }

        echo view('templates/header', $data);
        echo view('register', $data);
        echo view('templates/footer', $data);
    }
}
