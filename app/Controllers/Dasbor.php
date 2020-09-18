<?php namespace App\Controllers;

use CodeIgniter\Controller;

class Dasbor extends Controller
{
    function __construct()
    {
        // $this->load->helper('html');
    }

	public function index()
	{  
        echo view('layout/header');
        echo view('dasbor');
        echo view('layout/footer');
	}
}
