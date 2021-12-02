<?php

namespace App\Controllers\Account;

use App\Controllers\BaseController;
use App\Models\AccountModel;

class Register extends BaseController
{
	protected $accountModel;

	public function __construct()
	{
		$this->accountModel = new AccountModel();
	}

	public function index()
	{
		$data = [
			'title' => 'Daftar',
			'validation' => \Config\Services::validation()
		];

		return view('account/register', $data);
	}

	public function submit()
	{
		if (!$this->validate([
			'email' => 'required|valid_email|is_unique[accounts.email]',
			'username' => 'required|alpha_numeric|min_length[5]|max_length[50]|is_unique[accounts.username]',
			'password' => 'required|min_length[6]',
			'password_confirm' => 'required|matches[password]',
			'first_name' => 'required|alpha_space|min_length[2]',
			'last_name' => 'permit_empty|alpha_space',
			'birth_date' => 'required|valid_date|less_than_today',
			'gender' => 'required',
			'profile_picture' => 'max_size[profile_picture,10240]|is_image[profile_picture]',
			// |mime_in[profile_picture,image/jpg,image/jpeg,image/png,image/gif]|ext_in[profile_picture,jpg,jpeg,png,gif]
		])) {
			return redirect()->to(base_url('register'))->withInput();
		}

		$account = $this->accountModel->insertAccount($this->request->getPost());

		if ($account['id'] <= 0) {
			return redirect()->to(base_url('register'))->withInput()->with('register_error_msg', $account['error_msg']);
		}

		$session = session();

		$session->set('acc_id', $account['id']);

		$session->set('acc_email', $this->request->getPost('email'));
		$session->set('acc_username', $this->request->getPost('username'));
		$session->set('acc_first_name', $this->request->getPost('first_name'));
		$session->set('acc_last_name', $this->request->getPost('last_name'));
		$session->set('acc_gender', (bool) $this->request->getPost('gender'));

		$session->set('acc_profile_picture', $account['profile_picture']);

		$session->set('acc_logged_in', true);

		return redirect()->to(base_url());
	}
}
