<?php namespace App\Models;

use CodeIgniter\Model;

class DataMonitoring extends Model
{
	protected $DBGroup       = 'default';
	protected $table         = 'data_monitoring';
	protected $primaryKey    = 'id_gedung';
	protected $allowedFields = [
		'id_rekord',
		'tegangan',
		'kwh',
		'arus',
		'frekuensi',
		'daya_aktif',
		'daya_tampak',
		'waktu_rekord',
		'id_sensor',
	];

	function __construct()
	{
	}
}
