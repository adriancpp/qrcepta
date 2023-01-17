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

        echo view('templates/header', $data);
        echo view('register', $data);
        echo view('templates/footer', $data);
    }
}
