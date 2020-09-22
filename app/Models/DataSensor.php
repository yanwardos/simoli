<?php namespace App\Models;

use CodeIgniter\Model;

class DataSensor extends Model
{
	protected $DBGroup       = 'default';
	protected $table         = 'register_sensor';
	protected $primaryKey    = 'id_sensor';
	protected $allowedFields = [
		'nama_sensor',
		'id_gedung',
	];

	function __construct()
	{
	}
}
