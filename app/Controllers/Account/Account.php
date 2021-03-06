<?php

namespace App\Controllers\Account;

use App\Controllers\BaseController;
use App\Models\AccountModel;

class Account extends BaseController
{
	protected $accountModel;

	public function __construct()
	{
		$this->accountModel = new AccountModel();
	}

	public function settings()
	{
		$data = [
			'title' => 'Settings',
			'account' => $this->accountModel->getAccount(['id' => session('acc_id')]),
			'validation' => \Config\Services::validation()
		];

		return view('account/settings', $data);
	}

	public function update()
	{
		$id = session('acc_id');

		if (!$this->validate([
			'email' => 'required|valid_email|is_unique[accounts.email,id,' . $id . ']',
			'username' => 'required|alpha_numeric|min_length[5]|max_length[50]|is_unique[accounts.username,id,' . $id . ']',
			'password' => 'required|min_length[5]',
			'password_confirm' => 'required|matches[password]',
			'first_name' => 'required|alpha_space|min_length[2]',
			'last_name' => 'permit_empty|alpha_space',
			'birth_date' => 'required|valid_date|less_than_today',
			'gender' => 'required',
			'profile_picture' => 'max_size[profile_picture,10240]|is_image[profile_picture]',
			// |mime_in[profile_picture,image/jpg,image/jpeg,image/png,image/gif]|ext_in[profile_picture,jpg,jpeg,png,gif]
		])) {
			return redirect()->back()->withInput();
		}

		$account = $this->accountModel->updateAccount($id, $this->request->getPost());

		if (isset($account['error_msg'])) {
			return redirect()->back()->withInput()->with('settings_error_msg', $account['error_msg']);
		}

		$session = session();

		$session->set('acc_email', $this->request->getPost('email'));
		$session->set('acc_username', $this->request->getPost('username'));
		$session->set('acc_first_name', $this->request->getPost('first_name'));
		$session->set('acc_last_name', $this->request->getPost('last_name'));

		$session->set('acc_profile_picture', $account['profile_picture']);

		return redirect()->to(base_url('u'));
	}
}
