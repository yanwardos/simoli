<?php namespace App\Controllers;

use App\Models\DataMonitoring;
use CodeIgniter\Controller;
use DateInterval;
use DateTime;
use DateTimeZone;

class Arduino extends Controller
{
	function __construct()
	{
		$this->db = \Config\Database::connect();
		helper('form', 'url');
		$this->saveResolution = 30; // second
	}

	public function index()
	{
		echo 'Arduino Interface';
	}

	public function data()
	{
		try
		{
			// AMBIL DATA DARI PARAMETER GET
			$data['id_sensor']    = $this->request->getGet('id_sensor');
			$dataTime                = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
			$data['arus']         = $this->request->getGet('arus');
			$data['waktu_rekord'] = $dataTime->format('Y-m-d H:i:s');

			$data['tegangan']    = 220; //$this->request->getGet('tegangan');
			$data['kwh']         = 0; // $this->request->getGet('kwh');
			$data['frekuensi']   = 50; // $this->request->getGet('frekuensi');
			$data['daya_aktif']  = 0; // $this->request->getGet('daya_aktif');
			$data['daya_tampak'] = 0; // $this->request->getGet('daya_tampak');

			$datavalid = true;
			foreach ($data as $value)
			{
				if (is_null($value) || $value === '')
				{
					$datavalid = false;
				}
			}

			if (!$datavalid)
			{
				return 'Data not valid';
			}


			$dataTime = new DateTime('now',new DateTimeZone('Asia/Jakarta'));
			$dataTimeSecond = $dataTime->format('s');
			$dataTimeSecond = intval($dataTimeSecond);
			$saveTimeSecond = (floor($dataTimeSecond/$this->saveResolution)) * $this->saveResolution;

			$saveTime = new DateTime($dataTime->format('Y-m-d H:i:'.$saveTimeSecond), new DateTimeZone('Asia/Jakarta'));

			// Check if there is data in that time
			$query = 'SELECT * FROM data_monitoring WHERE (id_sensor=' . $data['id_sensor'] . ') AND (waktu_rekord='."'".$saveTime->format('Y-m-d H:i:s')."') ".'ORDER BY waktu_rekord DESC LIMIT 1';
			$query_exec = $this->db->query($query);
			$query_result = $query_exec->getResult();


			if(sizeof($query_result)==0){
				$data['waktu_rekord'] = $saveTime->format('Y-m-d H:i:s');
				$dataObj = new DataMonitoring();
				$a = $dataObj->insert($data);

				$this->response->setStatusCode(200, 'Data added');
			}else{
				$query_result = $query_result[0];
				$query = "UPDATE data_monitoring SET arus='".$data['arus']."' WHERE id_rekord='".$query_result->id_rekord."'";

				$this->db->query($query);

				$this->response->setStatusCode(200, 'Data updated');
			}
		}
		catch (\Throwable $th)
		{
			return $th->getMessage();
		}
	}
}
