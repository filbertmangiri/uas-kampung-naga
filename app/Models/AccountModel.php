<?php

namespace App\Models;

use CodeIgniter\Model;

class AccountModel extends Model
{
	protected $table      = 'accounts';
	protected $primaryKey = 'id';

	protected $useAutoIncrement = true;

	protected $returnType     = 'array';

	protected $allowedFields = [
		'email',
		'username',
		'password',
		'first_name',
		'last_name',
		'birth_date',
		'gender',
		'profile_picture',
		'is_management',
		'deleted_at'
	];

	protected $useTimestamps = true;
	protected $createdField  = 'created_at';
	protected $updatedField  = 'updated_at';

	protected $useSoftDeletes = true;
	protected $deletedField  = 'deleted_at';

	protected $validationRules    = [];
	protected $validationMessages = [];
	protected $skipValidation     = true;

	public function isExist($key, $value)
	{
		if ($this->select('id')->where($key, $value)->get(1)->getRowArray())
			return true;
		return false;
	}

	public function insertAccount($data)
	{
		$return = [];

		try {
			$captcha = $data['g-recaptcha-response'] ?? '';

			if (!$captcha) {
				throw new \Exception('Silakan verifikasi reCAPTCHA');
			}

			$response = (array) json_decode(file_get_contents(
				'https://www.google.com/recaptcha/api/siteverify?secret=' . getenv('RECAPTCHA_SECRET_KEY') .
					'&response=' . $captcha .
					'&remoteip=' . $_SERVER['REMOTE_ADDR']
			));

			if ($response['success'] !== true) {
				throw new \Exception('Verifikasi reCAPTCHA gagal');
			}

			$return['id'] = $this->insert([
				'email' => $data['email'],
				'username' => $data['username'],
				'password' => password_hash($data['password'], PASSWORD_DEFAULT),
				'first_name' => $data['first_name'],
				'last_name' => $data['last_name'],
				'birth_date' => $data['birth_date'],
				'gender' => (bool) $data['gender'],
			]);

			if (!$data['profile_picture_canvas']) {
				$return['profile_picture'] = 'default-' . (!(bool) $data['gender'] ? 'male' : 'female') . '.png';
			} else {
				list($type, $image) = explode(';', $data['profile_picture_canvas']);
				list(, $type) = explode('/', $type);
				list(, $image) = explode(',', $image);

				$image = base64_decode($image);

				$return['profile_picture'] = 'profile-' . $return['id'] . '.' . $type;

				file_put_contents('assets/img/profile-pictures/' . $return['profile_picture'], $image);
			}

			$this->update($return['id'], ['profile_picture' => $return['profile_picture']]);
		} catch (\Exception $e) {
			$return = ['error_msg' => $e->getMessage()];
		}

		return $return;
	}

	public function updateAccount($id, $data)
	{
		$return = [];

		try {
			if (count($data) <= 1) {
				return $this->update($id, $data);
			}

			if (!isset($data['profile_picture_canvas']) || !$data['profile_picture_canvas']) {
				if (!isset($data['old_profile_picture']) || str_starts_with($data['old_profile_picture'], 'default-')) {
					$return['profile_picture'] = 'default-' . (!(bool) $data['gender'] ? 'male' : 'female') . '.png';
				} else {
					$return['profile_picture'] = $data['old_profile_picture'];
				}
			} else {
				list($type, $image) = explode(';', $data['profile_picture_canvas']);
				list(, $type) = explode('/', $type);
				list(, $image) = explode(',', $image);

				$image = base64_decode($image);

				$return['profile_picture'] = 'profile-' . $id . '.' . $type;

				if (!str_starts_with($data['old_profile_picture'], 'default')) {
					unlink('assets/img/profile-pictures/' . $data['old_profile_picture']);
				}

				file_put_contents('assets/img/profile-pictures/' . $return['profile_picture'], $image);
			}

			$data['profile_picture'] = $return['profile_picture'];

			if (isset($data['password'])) {
				$data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
			}

			if (isset($data['gender'])) {
				$data['gender'] = (bool) $data['gender'];
			}

			if (isset($data['is_management'])) {
				$data['is_management'] = (bool) $data['is_management'];
			}

			$this->update($id, $data);
		} catch (\Exception $e) {
			return ['error_msg' => $e->getMessage()];
		}

		return $return;
	}

	public function deleteAccount($id, $purge = false)
	{
		$return = [];

		try {
			$profile_picture = $this->select('profile_picture')->where('id', $id)->get(1)->getRowArray()['profile_picture'];

			if (!$profile_picture) {
				throw new \Exception('User dengan ID ' . $id . ' tidak ditemukan');
			}

			if ($purge && !str_starts_with($profile_picture, 'default')) {
				unlink('assets/img/profile-pictures/' . $profile_picture);
			}

			$this->delete($id, $purge);
		} catch (\Exception $e) {
			return ['error_msg' => $e->getMessage()];
		}

		return $return;
	}

	public function restoreAccount($id)
	{
		$return = [];

		try {
			$this->update($id, ['deleted_at' => null]);
		} catch (\Exception $e) {
			return ['error_msg' => $e->getMessage()];
		}

		return $return;
	}

	public function getAccount($where = [], $selectColumns = [], $onlyDeleted = false)
	{
		if (!$where) {
			$builder = $this;

			if ($selectColumns) {
				$builder = $builder->select(implode(', ', $selectColumns));
			}

			if ($onlyDeleted) {
				$builder = $builder->onlyDeleted();
			}

			return $builder->findAll();
		}

		if (!isset($where['email_username'])) {
			return $this->where($where)->first();
		}

		$account = $this
			->groupStart()
			->where('email', $where['email_username'])
			->orWhere('username', $where['email_username'])
			->groupEnd()
			->first();

		if (!$account || !password_verify($where['password'], $account['password'])) {
			return [];
		}

		return $account;
	}
}
