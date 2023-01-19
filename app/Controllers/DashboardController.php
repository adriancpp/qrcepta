<?php

namespace App\Controllers;

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
