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
		'customer_id',
		'facility_id',
		'management_id',
		'start_date',
		'end_date',
		'status',
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

	public function insertRequest(array $data)
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

	public function updateRequest(int $id, array $data)
	{
		$return = [];

		try {
			$this->update($id, $data);
		} catch (\Exception $e) {
			return ['error_msg' => $e->getMessage()];
		}

		return $return;
	}

	public function deleteRequest(int $id, bool $purge = false)
	{
		$return = [];

		try {
			$this->delete($id, $purge);
		} catch (\Exception $e) {
			return ['error_msg' => $e->getMessage()];
		}

		return $return;
	}

	public function getRequest(array $where = [], bool $join = false, ?int $limit = null, bool $onlyDeleted = false)
	{
		$builder = $this;

		if ($join) {
			$joinStr = 'requests.*';

			foreach (['customer', 'management'] as $value) {
				foreach (['first_name', 'last_name', 'username'] as $column) {
					$joinStr .= ", {$value}.{$column} AS {$value}_{$column}";
				}
			}

			foreach (['name', 'name_slug'] as $value) {
				$joinStr .= ", facilities.{$value} AS facility_{$value}";
			}

			$builder = $builder->select($joinStr);

			$builder = $builder->join('accounts AS customer', 'customer.id = requests.customer_id');
			$builder = $builder->join('facilities', 'facilities.id = requests.facility_id');
			$builder = $builder->join('accounts AS management', 'management.id = requests.management_id', 'LEFT');
		} else {
			$joinStr = 'requests.*';

			foreach (['name', 'name_slug'] as $value) {
				$joinStr .= ", facilities.{$value} AS facility_{$value}";
			}

			$builder = $builder->select($joinStr);
			$builder = $builder->join('facilities', 'facilities.id = requests.facility_id');
		}

		if ($where) {
			$builder = $builder->where($where);
		}

		if ($onlyDeleted) {
			$builder = $builder->onlyDeleted();
		}

		if (!$limit || $limit < 1) {
			return $builder->findAll();
		}

		$result = $builder->get($limit)->getResultArray();

		if ($limit == 1) {
			return $result[0];
		}

		return $result;
	}
}
