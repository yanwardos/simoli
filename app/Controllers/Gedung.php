<?php namespace App\Controllers;

use CodeIgniter\Config\Config;
use CodeIgniter\Controller;
use App\Models;
use App\Models\DataGedung;

class Gedung extends Controller
{
    function __construct()
    {
        // $this->load->helper('html');
        $this->db = \Config\Database::connect();
    }

	public function index()
	{  
        $gedungs = new DataGedung();
        $gedungs = $gedungs->asArray()->findAll();
        $data['gedungs'] = $gedungs;
        
        echo view('layout/header');
        echo view('gedung/index', $data);
        echo view('layout/footer');
    }
    
    public function tambahIface()
    {
        echo view('layout/header');
        echo view('gedung/tambah');
        echo view('layout/footer');
    }

    public function tambah()
    {
        try {
            $data['nama_gedung']   = $this->request->getPost('nama');
        } catch (\Throwable $th) {
            return $th->getMessage();
        }

        try {
            $rekord = new DataGedung();
            $cek = $rekord->insert($data);
            return redirect()->to('/gedung');
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
}
