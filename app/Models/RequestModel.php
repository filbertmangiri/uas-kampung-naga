<?php

namespace App\Models;

use CodeIgniter\Model;

class RequestModel extends Model
{
	protected $DBGroup          = 'default';
	protected $table            = 'requests';
	protected $primaryKey       = 'id';
	protected $useAutoIncrement = true;
	protected $insertID         = 0;
	protected $returnType       = 'array';
	protected $useSoftDeletes   = true;
	protected $protectFields    = true;
	protected $allowedFields    = [
		'user_id',
		'facility_id',
		'start_date',
		'end_date',
		'status'
	];

	// Dates
	protected $useTimestamps = true;
	protected $dateFormat    = 'datetime';
	protected $createdField  = 'created_at';
	protected $updatedField  = 'updated_at';
	protected $deletedField  = 'deleted_at';

	// Validation
	protected $validationRules      = [];
	protected $validationMessages   = [];
	protected $skipValidation       = true;
	protected $cleanValidationRules = true;

	// Callbacks
	protected $allowCallbacks = true;
	protected $beforeInsert   = [];
	protected $afterInsert    = [];
	protected $beforeUpdate   = [];
	protected $afterUpdate    = [];
	protected $beforeFind     = [];
	protected $afterFind      = [];
	protected $beforeDelete   = [];
	protected $afterDelete    = [];

	public function insertRequest($data)
	{
		$return = [];

		try {
			$temp = strtotime($data['start_date']);

			$data['end_date'] = date('Y-m-d H:i:s', $temp + ($data['duration'] * 3600));
			$data['start_date'] = date('Y-m-d H:i:s', $temp);

			$return['id'] = $this->insert($data);
		} catch (\Exception $e) {
			return ['error_msg' => $e->getMessage()];
		}

		return $return;
	}
}
