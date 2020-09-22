<?php namespace App\Controllers;

use CodeIgniter\Config\Config;
use CodeIgniter\Controller;
use App\Models;
use App\Models\DataGedung;
use App\Models\DataSensor;

class Sensor extends Controller
{
	function __construct()
	{
		// $this->load->helper('html');
		$this->db = \Config\Database::connect();
	}

	public function index()
	{
		$sensors = new DataSensor();
		$sensors = $sensors->asArray()->findAll();

		echo view('layout/header');
		echo view('sensor/index', [
					  'sensors' => $sensors,
				  ]);
		echo view('layout/footer');
	}

	public function tambahSensor()
	{
		$gedungs = new DataGedung();
		$gedungs = $gedungs->asArray()->findAll();

		echo view('layout/header');
		echo view('sensor/tambah', [
					  'gedungs' => $gedungs,
				  ]);
		echo view('layout/footer');
	}

	public function tambah()
	{
		try
		{
			$data['nama_sensor'] = $this->request->getPost('nama');
			$data['id_gedung']   = $this->request->getPost('id_gedung');
		}
		catch (\Throwable $th)
		{
			return $th->getMessage();
		}

		try
		{
			$rekord = new DataSensor();
			$cek    = $rekord->insert($data);
			return redirect()->to('/sensor');
		}
		catch (\Throwable $th)
		{
			return $th->getMessage();
		}
	}
}
