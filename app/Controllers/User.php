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

	public function update($id)
	{
		// $id = $this->request->getPost('id');

		if (!$this->validate([
			'email' => 'required|valid_email|is_unique[accounts.email,id,' . $id . ']',
			'username' => 'required|alpha_numeric|min_length[5]|max_length[50]|is_unique[accounts.username,id,' . $id . ']',
			'first_name' => 'required|alpha_space|min_length[2]',
			'last_name' => 'permit_empty|alpha_space',
			'birth_date' => 'required|valid_date|less_than_today'
		])) {
			return redirect()->to(base_url('dashboard'))->withInput()->with('show_editing_modal', "$('#accountEditModal').modal('show');");
		}

		$result = $this->accountModel->updateAccount($id, $this->request->getPost());

		if (isset($result['error_msg'])) {
			return redirect()->to(base_url('dashboard'))->withInput()->with('acc_settings_error_msg', $result['error_msg'])->with('show_editing_modal', "$('#accountEditModal').modal('show');");
		}

		return redirect()->to(base_url('dashboard'))->with('show_editing_modal', "Swal.fire({
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
}
