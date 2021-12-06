<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\RequestModel;

class Request extends BaseController
{
	protected $requestModel;

	public function __construct()
	{
		$this->requestModel = new RequestModel();
	}

	public function insert()
	{
		if (!$this->validate([
			'start_date' => 'required|valid_date|greater_than_now',
			'duration' => 'required|integer|greater_than[0]'
		])) {
			return redirect()->back()->withInput()->with('show_request_modal', "$('#requestModal').modal('show');");
		}

		$result = $this->requestModel->insertRequest($this->request->getPost());

		if (isset($result['error_msg'])) {
			return redirect()->back()->withInput()
				->with('request_error_msg', $result['error_msg'])
				->with('show_request_modal', "$('#requestModal').modal('show');");
		}

		return redirect()->back()->with('show_request_modal', "Swal.fire({
			icon: 'success',
			text: 'Berhasil request fasilitas',
			showConfirmButton: false,
			timer: 1500
		});");
	}
}
