<?php

namespace App\Models;

use CodeIgniter\Model;

class FacilityModel extends Model
{
	protected $DBGroup          = 'default';
	protected $table            = 'facilities';
	protected $primaryKey       = 'id';
	protected $useAutoIncrement = true;
	protected $insertID         = 0;
	protected $returnType       = 'array';
	protected $useSoftDeletes   = true;
	protected $protectFields    = true;
	protected $allowedFields    = [
		'name',
		'name_slug',
		'image',
		'customer_id',
		'management_id',
		'rent_date',
		'return_date',
		'deleted_at'
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

	public function insertFacility($data)
	{
		$return = [];

		try {
			if (isset($data['customer_id'])) {
				$data['customer_id'] = (bool) $data['customer_id'];
			}

			if (isset($data['management_id'])) {
				$data['management_id'] = (bool) $data['management_id'];
			}

			$return['id'] = $this->insert($data);
		} catch (\Exception $e) {
			return ['error_msg' => $e->getMessage()];
		}

		return $return;
	}
}
