<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Pages extends BaseController
{
	public function index()
	{
		$data = [
			'title' => 'Beranda',
			'facilities' => (new \App\Models\FacilityModel())->getFacility()
		];

		return view('pages/home', $data);
	}

	public function about()
	{
		$data = [
			'title' => 'Tentang Kami'
		];

		return view('pages/about', $data);
	}
}
