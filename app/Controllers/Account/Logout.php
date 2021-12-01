<?php

namespace App\Controllers\Account;

use App\Controllers\BaseController;

class Logout extends BaseController
{
	public function index()
	{
		session()->destroy();

		return redirect()->to(base_url());
	}
}
