<?php namespace App\Controllers;

use CodeIgniter\Controller;

class AboutController extends Controller
{
    function __construct()
    {
        $this->db = \Config\Database::connect();
        helper('form', 'url');
    }

	public function index()
	{  
        $data = [];
        array_push($data, [
            'nama' => 'Kevin Inal Arianto',
            'keterangan' => 'Kevin adalah seorang Mahasiswa Institut Teknologi Sumatera dengan program studi Teknik Elektro angkatan 2017. Lahir di Bekasi, Jawa Barat pada tanggal 26 Desember 1999. Bertempat tinggal di desa jatimulya, Kampung Rawa Sapi, kecamatan Tambun Selatan, Kabupaten Bekasi, Jawa Barat. ',
            'img' => 'Kevin.jpg'
        ]);

        array_push($data, [
            'nama' => 'Handika Mediamarta',
            'keterangan' => 'Handika adalah seorang Mahasiswa Institut Teknologi Sumatera dengan program studi Teknik Elektro angkatan 2017. Lahir di Purwakarta, 20 Agustus 1999. Bertempat tinggal di Perum Bukit Berbunga blok B2 No.17.',
            'img' => 'handika.PNG'
        ]);

        array_push($data, [
            'nama' => 'Febyka Widiantara',
            'keterangan' => 'Febyka adalah seorang Mahasiswa Institut Teknologi Sumatera dengan program studi Teknik Elektro angkatan 2016. Lahir di Lampung Tengah, pada tanggal 26 Februari 1999. Bertempat tinggal di desa gayabaru V,kecamatan Bandar Surabaya,kabupaten Lampung Tengah,Lampung. ',
            'img' => 'febyka.PNG'
        ]);

        array_push($data, [
            'nama' => 'Leja Aprianza',
            'keterangan' => 'Leja adalah seorang Mahasiswa Institut Teknlogi Sumatera dengan program studi Teknik Elektro angkatan 2017. Lahir di Jakarta, pada tanggal 15 April 1998. Bertempat tinggal di KP. Margo mulyo LK l, Pidada, Panjang',
            'img' => 'leja.jpeg'
        ]);

        array_push($data, [
            'nama' => 'Josep Oktavianus Ambarita',
            'keterangan' => 'Josep adalah seorang Mahasiswa Institut Teknologi Sumatera dengan program studi Teknik Elektro angkatan 2016. Lahir di Berastagi, pada tanggal 18 Juli 1998. Bertempat tinggal di Jl. Way Huwi, Way Huwi, Jati Agung, Lampung Selatan.',
            'img' => 'josep.jpg'
        ]);

        echo view('layout/header');
        echo view('about', [
            'data'=>$data
        ]);
        echo view('layout/footer');
    }

}
