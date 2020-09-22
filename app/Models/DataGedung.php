<?php namespace App\Models;

use CodeIgniter\Model;

class DataGedung extends Model
{
	protected $DBGroup       = 'default';
	protected $table         = 'register_gedung';
	protected $primaryKey    = 'id_gedung';
	protected $allowedFields = [
		'nama_gedung'
	];

	function __construct()
	{
	}
}
