<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\FacilityModel;
use App\Models\RequestModel;

class Request extends BaseController
{
	protected $requestModel;
	protected $facilityModel;

	public function __construct()
	{
		$this->requestModel = new RequestModel();
		$this->facilityModel = new FacilityModel();
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

	public function delete()
	{
		$id = (int) $this->request->getPost('id');

		$result = $this->requestModel->deleteRequest($id);

		echo $result['error_msg'] ?? '';
	}

	public function decision()
	{
		$id = (int) $this->request->getPost('id');
		$decision = (int) $this->request->getPost('decision');

		$data = [
			'status' => $decision,
			'management_id' => session('acc_id')
		];

		$result = $this->requestModel->updateRequest($id, $data);

		$data = [
			'customer_id' => $this->request->getPost('customer_id'),
			'management_id' => session('acc_id'),
			'start_date' => $this->request->getPost('start_date'),
			'end_date' => $this->request->getPost('end_date')
		];

		$result += $this->facilityModel->updateFacility((int) $this->request->getPost('facility_id'), $data);

		echo $result['error_msg'] ?? '';
	}
}
