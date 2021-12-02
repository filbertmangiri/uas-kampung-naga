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

			$data['accounts'] = $this->accountModel->getAccount([], [
				'id',
				'email',
				'username',
				'first_name',
				'last_name',
				'birth_date',
				'gender',
				'profile_picture',
				'is_management',
				'updated_at',
				'deleted_at'
			], true);

			return view('dashboard/admin', $data);
		}

		if (session('acc_management') === true) {
			$data['title'] .= ' | Management';

			return view('dashboard/management', $data);
		}

		return view('dashboard/user', $data);
	}

	public function getAccounts()
	{
		$accounts = $this->accountModel->getAccount([], [
			'id',
			'email',
			'username',
			'first_name',
			'last_name',
			'birth_date',
			'gender',
			'profile_picture',
			'is_management',
			'updated_at',
			'deleted_at'
		], true);

		echo json_encode([
			'recordsTotal' => count($accounts),
			'recordsFiltered' => count($accounts),
			'data' => $accounts
		]);
	}
}
