<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models;
use App\Models\DataGedung;
use App\Models\DataMonitoring;
use CodeIgniter\Database\Database;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\Request;
use CodeIgniter\HTTP\Response;
use CodeIgniter\Router\Router;
use DateTime;
use Throwable;

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
            'monitorings'=>$monitorings,
            'gedungs' => $gedungs
        ]);
        echo view('layout/footer');
    }

    public function grafik()
    {
        echo view('layout/header');
        echo view('monitoring/grafik');
        echo view('layout/footer');
    }
    
    public function tambahIface()
    {
        $gedungs = new DataGedung();
        $gedungs = $gedungs->asArray()->findAll();
        
        echo view('layout/header');
        echo view('monitoring/tambah', [
            'gedungs' => $gedungs
        ]);
        echo view('layout/footer');
    }

    public function tambah()
    {
        try {
            $waktu =  $this->request->getPost('waktu-tanggal')." ".$this->request->getPost('waktu-jam');
            $data['id_gedung']  = $this->request->getPost('gedung');
            $data['waktu_rekord']   = $waktu;
            $data['tegangan'] = $this->request->getPost('tegangan');
            $data['kwh'] = $this->request->getPost('kwh');
            $data['arus'] = $this->request->getPost('arus');
            $data['frekuensi'] = $this->request->getPost('frekuensi');
            $data['daya_aktif'] = $this->request->getPost('daya_aktif');
            $data['daya_tampak'] = $this->request->getPost('daya_tampak');
        } catch (\Throwable $th) {
            return $th->getMessage();
        }

        try {
            $rekord = new DataMonitoring();
            $cek = $rekord->insert($data);
            return redirect()->to('/monitoring');
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function getDataMonitoring(){
        $start = $this->request->getGet('startDate');
        $end = $this->request->getGet('endDate');

        try {
            $start=new DateTime($start);
            $start=$start->format('Y-m-d H:m:i');
        } catch (\Throwable $th) {
            $start=false;
        }

        try{
            $end=new DateTime($end);
            $end=$end->format('Y-m-d H:m:i');
        } catch (\Throwable $th){
            $end=false;
        }

        if(!$start || !$end){
            $query = $this->db->query('SELECT * FROM data_monitoring_listrik ORDER BY waktu_rekord ASC');
        }else{
            $query = $this->db->query('SELECT * FROM data_monitoring_listrik WHERE waktu_rekord BETWEEN '."'".$start."'"." and "."'".$end."'"."ORDER BY waktu_rekord ASC");
        }

        $result = $query->getResult();
        $this->response->setJSON($result, true);
        print_r(json_encode($result));
    }
}
