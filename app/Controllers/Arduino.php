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
			echo $saveTimeSecond;

			$saveTime = new DateTime($dataTime->format('Y-m-d H:i:'.$saveTimeSecond), new DateTimeZone('Asia/Jakarta'));

			// Check if there is data in that time
			$query = 'SELECT * FROM data_monitoring WHERE (id_sensor=' . $data['id_sensor'] . ') AND (waktu_rekord='."'".$saveTime->format('Y-m-d H:i:s')."') ".'ORDER BY waktu_rekord DESC LIMIT 1';
			$query_exec = $this->db->query($query);
			$query_result = $query_exec->getResult();

			var_dump($saveTime);
			if(sizeof($query_result)==0){
				$data['waktu_rekord'] = $saveTime->format('Y-m-d H:i:s');
				$dataObj = new DataMonitoring();
				$a = $dataObj->insert($data);

				echo "ditambah";
			}else{
				$query_result = $query_result[0];
				$query = "UPDATE data_monitoring SET arus='".$data['arus']."' WHERE id_rekord='".$query_result->id_rekord."'";

				$this->db->query($query);

				echo "diupdate";
			}
			/*
			if(!is_null($latestTime)){
				$latestTime = new DateTime($latestTime, new DateTimeZone('Asia/Jakarta'));
				$limitTime = new DateTime($latestTime->format('Y-m-d H:i:s'), new DateTimeZone('Asia/Jakarta'));
				$limitTime = $limitTime->add(new DateInterval('PT5S'));
			}else{
				$latestTime = false;
			}
			
			if($latestTime==false){
				$dataBaru = new DataMonitoring();
				$cobaSimpan = $dataBaru->insert($data);
			}

			if($dataTime<$limitTime)
			{
				// update latest record
				$query = "UPDATE data_monitoring SET arus='".$data['arus']."' WHERE waktu_rekord='".$latestTime->format('Y-m-d H:i:s')."'";
				$query_exec = $this->db->query($query);
				
				echo "Memperbarui data berhasil";
			}else{
				// add new record
				try
				{

					$dif = $dataTime->diff($limitTime);
					$h = intval($dif->h);
					$m = intval($dif->i);
					$s = intval($dif->s) + $m*60 + $h*60*60;

					echo "<br>";
					echo "<br>";
					
					$lost = round($s/5);
					$sec = $s%5;

					$dataBaru   = new DataMonitoring();

					var_dump($latestData);

					for($i=0; $i<$lost; $i++){
						$tmpData['id_sensor']    = $latestData->id_sensor;
						$tmpData['arus']         = $latestData->arus;
						$tmpData['waktu_rekord'] = $limitTime->format('Y-m-d H:i:s');
						$tmpData['tegangan']    = 220; 
						$tmpData['kwh']         = 0; 
						$tmpData['frekuensi']   = 50; 
						$tmpData['daya_aktif']  = 0; 
						$tmpData['daya_tampak'] = 0; 
						$cobaSimpan = $dataBaru->insert($tmpData);
						$limitTime->add(new DateInterval('PT5S'));
					}

					$data['waktu_rekord'] = $limitTime->format('Y-m-d H:i:s');
					$cobaSimpan = $dataBaru->insert($data);
	
					echo 'status: ' . $cobaSimpan;
					echo 'Menyimpan data berhasil';
				}
				catch (\Throwable $th)
				{
					return $th->getMessage();
				}

			}
			*/
		}
		catch (\Throwable $th)
		{
			return $th->getMessage();
		}
	}
}
