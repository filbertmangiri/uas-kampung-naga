<?php

namespace App\Controllers\Account;

use App\Controllers\BaseController;
use App\Models\AccountModel;

class Login extends BaseController
{
	protected $accountModel;

	public function __construct()
	{
		$this->accountModel = new AccountModel();
	}

	public function index()
	{
		$data = [
			'title' => 'Masuk'
		];

		return view('account/login', $data);
	}

	public function submit()
	{
		if (!$this->validate([
			'email_username' => 'required',
			'password' => 'required'
		])) {
			return redirect()->to(base_url('login'))->withInput()->with('login_error_msg', 'Username atau password salah');
		}

		$account = $this->accountModel->getAccount($this->request->getPost());

		if (!$account) {
			return redirect()->to(base_url('login'))->withInput()->with('login_error_msg', 'Username atau password salah');
		} else {
			$session = session();

			$session->set('acc_id', (int) $account['id']);

			$session->set('acc_email', $account['email']);
			$session->set('acc_username', $account['username']);
			$session->set('acc_first_name', $account['first_name']);
			$session->set('acc_last_name', $account['last_name']);
			$session->set('acc_gender', (bool) $account['gender']);

			$session->set('acc_profile_picture', $account['profile_picture']);

			if ($account['username'] === getenv('ADMIN_USERNAME')) {
				$session->set('acc_admin', true);
			}

			$session->set('acc_management', (bool) $account['is_management']);

			$session->set('acc_logged_in', true);

			if (!file_exists('assets/img/profile-pictures/' . session('acc_profile_picture'))) {
				$session->set('acc_profile_picture', 'default-' . (!session('acc_gender') ? 'male' : 'female') . '.png');
				$this->accountModel->updateAccount(session('acc_id'), ['profile_picture' => session('acc_profile_picture')]);
			}
		}

		return redirect()->to(base_url());
	}
}
