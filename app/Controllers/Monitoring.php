<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models;
use App\Models\DataGedung;
use App\Models\DataMonitoring;
use App\Models\DataSensor;
use CodeIgniter\Database\Database;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\Request;
use CodeIgniter\HTTP\Response;
use CodeIgniter\Router\Router;
use DateTime;
use Throwable;

use function PHPSTORM_META\type;

class Monitoring extends Controller
{
	function __construct()
	{
		$this->db = \Config\Database::connect();
		helper('form', 'url');
	}

	public function index()
	{
		$monitorings = new DataMonitoring();
		$monitorings = $monitorings->asArray()->findAll();

		$gedungs = new DataGedung();
		$gedungs = $gedungs->asArray()->findAll();

		echo view('layout/header');
		echo view('monitoring/index', [
					  'monitorings' => $monitorings,
					  'gedungs'     => $gedungs,
				  ]);
		echo view('layout/footer');
	}

	public function grafik()
	{
		$sensors = new DataSensor();
		$sensors = $sensors->asArray()->findAll();
		
		echo view('layout/header');
		echo view('monitoring/grafik', [
				  ]);
		echo view('layout/footer');
	}

	public function tambahIface()
	{
		$gedungs = new DataGedung();
		$gedungs = $gedungs->asArray()->findAll();

		$sensors = new DataSensor();
		$sensors = $sensors->asArray()->findAll();

		echo view('layout/header');
		echo view('monitoring/tambah', [
					  'gedungs' => $gedungs,
					  'sensors' => $sensors,
				  ]);
		echo view('layout/footer');
	}

	public function tambah()
	{
		try
		{
			$waktu                = $this->request->getPost('waktu-tanggal') . ' ' . $this->request->getPost('waktu-jam');
			$data['id_sensor']    = $this->request->getPost('id_sensor');
			$data['waktu_rekord'] = $waktu;
			$data['tegangan']     = $this->request->getPost('tegangan');
			$data['kwh']          = $this->request->getPost('kwh');
			$data['arus']         = $this->request->getPost('arus');
			$data['frekuensi']    = $this->request->getPost('frekuensi');
			$data['daya_aktif']   = $this->request->getPost('daya_aktif');
			$data['daya_tampak']  = $this->request->getPost('daya_tampak');
		}
		catch (\Throwable $th)
		{
			return $th->getMessage();
		}

		try
		{
			$rekord = new DataMonitoring();
			$cek    = $rekord->insert($data);
			return redirect()->to('/monitoring');
		}
		catch (\Throwable $th)
		{
			return $th->getMessage();
		}
	}

	public function getDataMonitoring()
	{
		
		$data = $this->request->getGet('data');
		$data = json_decode($data);
		
		$start = $data->start;
		$end = $data->end;
		$idSensors = $data->idSensors;

		try
		{
			if(is_null($start)||$start==""){
				$start = false;
			}else{
				$start = new DateTime($start);
				$start = $start->format('Y-m-d H:m:i');
			}
		}
		catch (\Throwable $th)
		{
			$start = false;
		}

		try
		{
			if(is_null($end)||$end==""){
				$end = false;
			}else{
				$end = new DateTime($end);
				$end = $end->format('Y-m-d H:m:i');
			}
		}
		catch (\Throwable $th)
		{
			$end = false;
		}


		$result = [];
		if (! $start || ! $end)
		{
			foreach ($idSensors as $idSensor) {
				$query = $this->db->query('SELECT * FROM register_sensor WHERE id_sensor=' . $idSensor);
				$sensor = $query->getResult();

				if(sizeof($sensor)!==0){
					$query = $this->db->query('SELECT * FROM data_monitoring WHERE (id_sensor=' . $idSensor . ') ORDER BY waktu_rekord ASC');
					array_push($result, [
						'idSensor'=>$sensor[0]->id_sensor,
						'namaSensor'=>$sensor[0]->nama_sensor,
						'data'=>$query->getResult()
					]);
				}
			}
		}
		else
		{
			foreach ($idSensors as $idSensor) {
				$query = $this->db->query('SELECT * FROM register_sensor WHERE id_sensor=' . $idSensor);
				$sensor = $query->getResult();
				
				if(sizeof($sensor)!==0){
					$query = $this->db->query('SELECT * FROM data_monitoring WHERE (id_sensor=' . $idSensor . ') and (waktu_rekord BETWEEN ' . "'" . $start . "'" . ' and ' . "'" . $end . "'" . ') ORDER BY waktu_rekord ASC');
					array_push($result, [
						'idSensor'=>$sensor[0]->id_sensor,
						'namaSensor'=>$sensor[0]->nama_sensor,
						'data'=>$query->getResult()
					]);
				}
			}
			
		}
		
		$this->response->setJSON($result, true);
		print_r(json_encode($result));
		
	}
}
