<?php namespace App\Controllers;

use CodeIgniter\Controller;

class Welcome extends Controller
{
    function __construct()
    {
        // $this->load->helper('html');
    }

	public function index()
	{  
        echo view('layout/header');
        echo view('welcome');
        echo view('layout/footer');
	}
}
