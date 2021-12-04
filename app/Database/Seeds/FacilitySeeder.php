<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class FacilitySeeder extends Seeder
{
	public function run()
	{
		$data = [
			'name'			=> '',
			'name_slug'		=> '',
			'image'			=> '',
			'customer_id'	=> '',
			'management_id'	=> '',
			'rent_date'		=> '',
			'return_date'	=> '',
			'created_at'	=> '',
			'updated_at'	=> ''
		];

		$this->db->table('accounts')->insert($data);
	}
}
