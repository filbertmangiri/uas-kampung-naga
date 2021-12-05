<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AccountModel;

class User extends BaseController
{
	protected $accountModel;

	public function __construct()
	{
		$this->accountModel = new AccountModel();
	}

	public function index($username = '')
	{
		if (!$username) {
			return redirect()->to(base_url('u/' . session('acc_username')));
		}

		$data['username'] = $username;
		$data['account'] = $this->accountModel->getAccount(['username' => $username]);
		$data['title'] = $data['account'] ? trim($data['account']['first_name'] . ' ' . $data['account']['last_name']) . ' (' . $data['account']['username'] . ')' : '';

		return view('details/user', $data);
	}

	public function update($id)
	{
		if (!$this->validate([
			'email' => 'required|valid_email|is_unique[accounts.email,id,' . $id . ']',
			'username' => 'required|alpha_numeric|min_length[5]|max_length[50]|is_unique[accounts.username,id,' . $id . ']',
			'first_name' => 'required|alpha_space|min_length[2]',
			'last_name' => 'permit_empty|alpha_space',
			'birth_date' => 'required|valid_date|less_than_today',
			'gender' => 'required'
		])) {
			return redirect()->back()->withInput()
				->with('show_user_editing_modal', "$('#accountEditModal').modal('show');
					$('#accSettingsForm input[name=gender][value=' + " . old('gender') . " + ']').prop('checked', 'true');");
		}

		$result = $this->accountModel->updateAccount($id, $this->request->getPost());

		if (isset($result['error_msg'])) {
			return redirect()->back()->withInput()
				->with('acc_settings_error_msg', $result['error_msg'])
				->with('show_user_editing_modal', "$('#accountEditModal').modal('show');
					$('#accSettingsForm input[name=gender][value=' + " . old('gender') . " + ']').prop('checked', 'true');");
		}

		return redirect()->back()->with('show_user_editing_modal', "Swal.fire({
			icon: 'success',
			text: 'Akun berhasil diubah',
			showConfirmButton: false,
			timer: 1500
		});");
	}

	public function delete()
	{
		$result = $this->accountModel->deleteAccount($this->request->getPost('id'), (bool) $this->request->getPost('purge'));

		echo $result['error_msg'] ?? '';
	}

	public function restore()
	{
		$result = $this->accountModel->restoreAccount($this->request->getPost('id'));

		echo $result['error_msg'] ?? '';
	}

	public function getAllAccounts($onlyDeleted = false)
	{
		$accounts = $this->accountModel->getAccount([], [], (bool) $onlyDeleted);

		echo json_encode([
			'recordsTotal' => count($accounts),
			'recordsFiltered' => count($accounts),
			'data' => $accounts
		]);
	}

	public function isExist()
	{
		if ($this->accountModel->isExist($this->request->getPost('key'), $this->request->getPost('value')))
			echo true;
		else
			echo false;
	}
}
