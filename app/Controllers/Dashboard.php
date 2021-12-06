<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AccountModel;

class Dashboard extends BaseController
{
	protected $accountModel;

	public function __construct()
	{
		$this->accountModel = new AccountModel();
	}

	public function index()
	{
		$data = [
			'title' => 'Dashboard'
		];

		if (session('acc_admin') === true) {
			$data['title'] .= ' | Admin';
			$data['validation'] = \Config\Services::validation();

			return view('dashboard/roles/admin/main', $data);
		}

		if (session('acc_management') === true) {
			$data['title'] .= ' | Management';
			$data['validation'] = \Config\Services::validation();

			return view('dashboard/roles/management/main', $data);
		}

		return view('dashboard/roles/user/main', $data);
	}
}
