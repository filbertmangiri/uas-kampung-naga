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
		'description',
		'is_rented',
		'customer_id',
		'management_id',
		'start_date',
		'end_date',
		'created_at',
		'updated_at',
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

	public function insertFacility($post, $files)
	{
		$return = [];

		try {
			$post['name_slug'] = url_title($post['name'], '-', true);

			$return['id'] = $this->insert($post);

			if ($files['image']->getError() == UPLOAD_ERR_OK) {
				$post['image'] = 'facility-' . $return['id'] . '.' . $files['image']->guessExtension();

				$files['image']->move('assets/img/facilities', $post['image'], true);
			} else {
				$post['image'] = 'default.png';
			}

			$this->update($return['id'], ['image' => $post['image']]);
		} catch (\Exception $e) {
			return ['error_msg' => $e->getMessage()];
		}

		return $return;
	}

	public function updateFacility($id, $post, $files)
	{
		$return = [];

		try {
			$post['name_slug'] = url_title($post['name'], '-', true);

			$fileError = $files['image']->getError();

			if ($fileError == UPLOAD_ERR_OK) {
				$post['image'] = 'facility-' . $return['id'] . '.' . $files['image']->guessExtension();

				$files['image']->move('assets/img/facilities', $post['image'], true);
			} elseif ($fileError == UPLOAD_ERR_NO_FILE) {
				$post['image'] = $post['old_image'];
			} else {
				throw new \Exception($files['image']->getErrorString() . ' (' . $files['image']->getError() . ')');
			}

			$this->update($id, $post);
		} catch (\Exception $e) {
			return ['error_msg' => $e->getMessage()];
		}

		return $return;
	}

	public function deleteFacility($id, $purge = false)
	{
		$return = [];

		try {
			$image = $this->select('image')->where('id', $id)->get(1)->getRowArray()['image'];

			if (!$image) {
				throw new \Exception('Fasilitas dengan ID ' . $id . ' tidak ditemukan');
			}

			if ($purge && !str_starts_with($image, 'default')) {
				unlink('assets/img/facilities/' . $image);
			}

			$this->delete($id, $purge);
		} catch (\Exception $e) {
			return ['error_msg' => $e->getMessage()];
		}

		return $return;
	}

	public function restoreFacility($id)
	{
		$return = [];

		try {
			$this->update($id, ['deleted_at' => null]);
		} catch (\Exception $e) {
			return ['error_msg' => $e->getMessage()];
		}

		return $return;
	}

	public function getFacility($where = [], $selectColumns = [], $joins = [], $onlyDeleted = false)
	{
		$return = [];

		if (!$where) {
			$builder = $this;

			if ($joins) {
				$joinStr = 'facilities.*';

				foreach ($joins as $joinsValue) {
					foreach ((new \App\Models\AccountModel)->allowedFields as $column) {
						$joinStr .= ", {$joinsValue}.{$column} AS {$joinsValue}_{$column}";
					}
				}

				$builder = $builder->select($joinStr);

				foreach ($joins as $joinsValue) {
					$builder = $builder->join("accounts AS {$joinsValue}", "{$joinsValue}.id = facilities.{$joinsValue}_id", 'LEFT');
				}
			}

			if ($selectColumns) {
				$builder = $builder->select(implode(', ', $selectColumns));
			}

			if ($onlyDeleted) {
				$builder = $builder->onlyDeleted();
			}

			return $builder->findAll();
		}

		return $this->where($where)->first();
	}

	public function isExist($key, $value)
	{
		if ($this->select('id')->where($key, $value)->get(1)->getRowArray())
			return true;
		return false;
	}
}
