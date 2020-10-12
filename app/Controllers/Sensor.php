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

	public function all(){
		$idSensor = $this->request->getGet('sensor');
		if($idSensor=="false"){
			$sensors = new DataSensor();
			$sensors = $sensors->asArray()->findAll();
		}else{
			$sensors = $this->db->query('SELECT * FROM register_sensor WHERE id_sensor='.$idSensor);
			$sensors = $sensors->getResult();
		}

		$this->response->setJSON($sensors, true);
		print_r(json_encode($sensors));
	}

	public function sensordet(){
		$id_sensor = $this->request->getGet('id_sensor');
		
		if(is_null($id_sensor)) return $this->response->setStatusCode(400, 'Forbidden');

		echo view('layout/header');
		echo view('monitoring/grafik', [
					'sensors' => $id_sensor
				  ]);
		echo view('layout/footer');
	}
}
