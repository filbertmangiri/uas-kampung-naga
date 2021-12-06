<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\FacilityModel;

class Facility extends BaseController
{
	protected $facilityModel;

	public function __construct()
	{
		$this->facilityModel = new FacilityModel();
	}

	public function index($slug = '')
	{
		$data['facility'] = $this->facilityModel->getFacility(['name_slug' => $slug]);
		$data['name'] = $data['facility']['name'];

		$data['title'] = $data['facility'] ? $data['facility']['name'] : '';

		$data['validation'] = \Config\Services::validation();

		return view('details/facility', $data);
	}

	public function insert()
	{
		if (!$this->validate([
			'name' => 'required|alpha_numeric_punct|min_length[5]|max_length[100]|is_unique[facilities.name]',
			// 'description' => 'permit_empty|min_length[20]',
			'image' => 'max_size[image,10240]|is_image[image]|mime_in[image,image/png,image/jpg,image/jpeg,image/gif]|ext_in[image,png,jpg,jpeg,gif]'
		])) {
			return redirect()->back()->withInput()
				->with('show_facility_modal', "$('#facilityModal').modal('show');
					$('#facilityModalLabel').html('Tambah Fasilitas')
					$('#facilityModal .modal-footer :submit').html('Tambah');
					$('#facilityForm').attr('action', '" . base_url('facility/insert') . "');");
		}

		$result = $this->facilityModel->insertFacility($this->request->getPost(), $this->request->getFiles());

		if (isset($result['error_msg'])) {
			return redirect()->back()->withInput()
				->with('facility_error_msg', $result['error_msg'])
				->with('show_facility_modal', "$('#facilityModal').modal('show');
					$('#facilityModalLabel').html('Tambah Fasilitas')
					$('#facilityModal .modal-footer :submit').html('Tambah');
					$('#facilityForm').attr('action', '" . base_url('facility/insert') . "');");
		}

		return redirect()->back()->with('show_facility_modal', "Swal.fire({
			icon: 'success',
			text: 'Berhasil menambah fasilitas',
			showConfirmButton: false,
			timer: 1500
		});");
	}

	public function update($id)
	{
		if (!$this->validate([
			'name' => 'required|alpha_numeric_punct|min_length[5]|max_length[100]|is_unique[facilities.name,id,' . $id . ']',
			// 'description' => 'permit_empty|min_length[20]',
			'image' => 'max_size[image,10240]|is_image[image]|mime_in[image,image/png,image/jpg,image/jpeg,image/gif]|ext_in[image,png,jpg,jpeg,gif]'
		])) {
			return redirect()->back()->withInput()
				->with('show_facility_modal', "$('#facilityModal').modal('show');
					$('#facilityModalLabel').html('Ubah Fasilitas')
					$('#facilityModal .modal-footer :submit').html('Simpan');
					$('#facilityForm').attr('action', '" . base_url('facility/update/' . $id) . "');");
		}

		$result = $this->facilityModel->updateFacility($id, $this->request->getPost(), $this->request->getFiles());

		if (isset($result['error_msg'])) {
			return redirect()->back()->withInput()
				->with('facility_error_msg', $result['error_msg'])
				->with('show_facility_modal', "$('#facilityModal').modal('show');
					$('#facilityModalLabel').html('Ubah Fasilitas')
					$('#facilityModal .modal-footer :submit').html('Simpan');
					$('#facilityForm').attr('action', '" . base_url('facility/update/' . $id) . "');");
		}

		return redirect()->back()->with('show_facility_modal', "Swal.fire({
			icon: 'success',
			text: 'Berhasil mengubah fasilitas',
			showConfirmButton: false,
			timer: 1500
		});");
	}

	public function delete()
	{
		$result = $this->facilityModel->deleteFacility($this->request->getPost('id'), (bool) $this->request->getPost('purge'));

		echo $result['error_msg'] ?? '';
	}

	public function restore()
	{
		$result = $this->facilityModel->restoreFacility($this->request->getPost('id'));

		echo $result['error_msg'] ?? '';
	}

	public function getAllFacilities($onlyDeleted = false)
	{
		$facilities = $this->facilityModel->getFacility([], [], [
			'customer'
		], (bool) $onlyDeleted);

		echo json_encode([
			'recordsTotal' => count($facilities),
			'recordsFiltered' => count($facilities),
			'data' => $facilities
		]);
	}
}
