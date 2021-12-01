<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Dashboard extends BaseController
{
	public function index()
	{
		$data = [
			'title' => 'Dashboard'
		];

		if (session('acc_admin') === true) {
			$data['title'] .= ' | Admin';
			return view('dashboard/admin', $data);
		}

		if (session('acc_management') === true) {
			$data['title'] .= ' | Management';
			return view('dashboard/management', $data);
		}

		return view('dashboard/user', $data);
	}
}
