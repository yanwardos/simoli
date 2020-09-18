<?php namespace App\Controllers;

use App\Models\DataMonitoring;
use CodeIgniter\Controller;
use DateTime;
use DateTimeZone;

class Arduino extends Controller
{
    function __construct()
    {
        helper('form', 'url');
    }

	public function index()
	{  
        echo "Arduino Interface";
    }

    
    public function data()
    {
        try{
            $data['id_gedung'] = $this->request->getGet('id_gedung');
            $waktu = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
            $data['arus'] = $this->request->getGet('arus');            
            $data['waktu_rekord'] = $waktu->format('Y-m-d H:i:s');

            $data['tegangan'] = 220; //$this->request->getGet('tegangan');
            $data['kwh'] = 0; // $this->request->getGet('kwh');
            $data['frekuensi'] = 50; // $this->request->getGet('frekuensi');
            $data['daya_aktif'] = 0; // $this->request->getGet('daya_aktif');
            $data['daya_tampak'] = 0; // $this->request->getGet('daya_tampak');

            $datavalid = true;
            foreach($data as $value){
                if(is_null($value) || $value==='') $datavalid = false;
            }

            if($datavalid){
                echo "<pre>";
                print_r($data);
                echo "</pre>";

                try{
                    $dataBaru = new DataMonitoring();
                    $cobaSimpan = $dataBaru->insert($data);
                    
                    echo "Menyimpan data berhasil";
                }catch(\Throwable $th){
                    return $th->getMessage();
                }

            }else{
                echo "Data not valid";
            }
        }catch(\Throwable $th){
            return $th->getMessage();
        }
        
    }
}
