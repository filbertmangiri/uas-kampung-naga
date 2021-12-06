<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AccountModel;
use App\Models\FacilityModel;
use App\Models\RequestModel;

class Dashboard extends BaseController
{
	protected $accountModel;
	protected $facilityModel;
	protected $requestModel;

	public function __construct()
	{
		$this->accountModel = new AccountModel();
		$this->facilityModel = new FacilityModel();
		$this->requestModel = new RequestModel();
	}

	public function index()
	{
		$data = [
			'title' => 'Dashboard',
			'validation' => \Config\Services::validation()
		];

		if (session('acc_admin') === true) {
			$data['title'] .= ' | Admin';

			$data['requests'] = $this->requestModel->getRequest([], true);

			return view('dashboard/roles/admin/main', $data);
		}

		if (session('acc_management') === true) {
			$data['title'] .= ' | Management';

			$data['requests'] = $this->requestModel->getRequest([], true);

			return view('dashboard/roles/management/main', $data);
		}

		$data += [
			'facilities' => $this->facilityModel->getFacility(),
			'requests' => $this->requestModel->getRequest(['requests.customer_id' => session('acc_id')])
		];

		return view('dashboard/roles/user/main', $data);
	}
}
