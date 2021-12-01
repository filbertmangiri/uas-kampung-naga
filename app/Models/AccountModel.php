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
		if ($this->where($key, $value)->first())
			return true;
		return false;
	}

	public function insertAccount($post)
	{
		try {
			$captcha = $post['g-recaptcha-response'] ?? '';

			if (!$captcha) {
				throw new \Exception();
			}

			$response = (array) json_decode(file_get_contents(
				'https://www.google.com/recaptcha/api/siteverify?secret=' . getenv('RECAPTCHA_SECRET_KEY') .
					'&response=' . $captcha .
					'&remoteip=' . $_SERVER['REMOTE_ADDR']
			));

			if ($response['success'] !== true) {
				throw new \Exception();
			}

			$insertedID = $this->insert([
				'email' => $post['email'],
				'username' => $post['username'],
				'password' => password_hash($post['password'], PASSWORD_DEFAULT),
				'first_name' => $post['first_name'],
				'last_name' => $post['last_name'],
				'birth_date' => $post['birth_date'],
				'gender' => (bool) $post['gender'],
			]);

			if (!$post['profile_picture_canvas']) {
				$fileName = 'default-' . (!(bool) $post['gender'] ? 'male' : 'female') . '.png';
			} else {
				$data = $post['profile_picture_canvas'];

				list($type, $data) = explode(';', $data);
				list(, $type) = explode('/', $type);
				list(, $data) = explode(',', $data);

				$data = base64_decode($data);

				$fileName = 'profile-' . $insertedID . '.' . $type;

				file_put_contents('img/profile-pictures/' . $fileName, $data);
			}

			$this->update($insertedID, ['profile_picture' => $fileName]);
		} catch (\Exception $e) {
			$insertedID = -1;
		}

		return $insertedID;
	}

	public function updateAccount($id, $post)
	{
		try {
			if (count($post) <= 1) {
				return $this->update($id, $post);
			}

			if (!$post['profile_picture_canvas']) {
				if (str_starts_with($post['old_profile_picture'], 'default-')) {
					$fileName = 'default-' . (!(bool) $post['gender'] ? 'male' : 'female') . '.png';
				} else {
					$fileName = $post['old_profile_picture'];
				}
			} else {
				$data = $post['profile_picture_canvas'];

				list($type, $data) = explode(';', $data);
				list(, $type) = explode('/', $type);
				list(, $data) = explode(',', $data);

				$data = base64_decode($data);

				$fileName = 'profile-' . $id . '.' . $type;

				if (!str_starts_with($post['old_profile_picture'], 'default')) {
					unlink('img/profile-pictures/' . $post['old_profile_picture']);
				}

				file_put_contents('img/profile-pictures/' . $fileName, $data);
			}

			$this->update($id, [
				'email' => $post['email'],
				'username' => $post['username'],
				'password' => password_hash($post['password'], PASSWORD_DEFAULT),
				'first_name' => $post['first_name'],
				'last_name' => $post['last_name'],
				'birth_date' => $post['birth_date'],
				'gender' => (bool) $post['gender'],
				'profile_picture' => $fileName
			]);
		} catch (\Exception $e) {
			return $e->getMessage();
		}

		return '';
	}

	public function getAccount($post = [])
	{
		if (!$post) {
			return $this->withDeleted()->findAll();
		}

		if (!isset($post['email_username'])) {
			return $this->where($post)->first();
		}

		$account = $this
			->groupStart()
			->where('email', $post['email_username'])
			->orWhere('username', $post['email_username'])
			->groupEnd()
			->first();

		if (!$account || !password_verify($post['password'], $account['password'])) {
			return [];
		}

		return $account;
	}
}
