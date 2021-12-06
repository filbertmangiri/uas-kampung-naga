<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RequestSeeder extends Seeder
{
	public function run()
	{
		$data = [
			[
				'customer_id'	=> rand(3, 100),
				'facility_id'	=> rand(1, 5),
				'management_id'	=> null,
				'start_date'	=> '2021-12-10 13:00:00',
				'end_date'		=> '2021-12-10 16:00:00',
				'status'		=> 0,
				'created_at'	=> '2021-12-5 13:00:00',
				'updated_at'	=> '2021-12-5 13:00:00'
			],
			[
				'customer_id'	=> rand(3, 100),
				'facility_id'	=> rand(1, 5),
				'management_id'	=> null,
				'start_date'	=> '2021-12-11 14:00:00',
				'end_date'		=> '2021-12-11 16:00:00',
				'status'		=> 0,
				'created_at'	=> '2021-12-5 13:00:00',
				'updated_at'	=> '2021-12-5 13:00:00'
			],
			[
				'customer_id'	=> rand(3, 100),
				'facility_id'	=> rand(1, 5),
				'management_id'	=> null,
				'start_date'	=> '2021-12-12 16:00:00',
				'end_date'		=> '2021-12-12 18:00:00',
				'status'		=> 0,
				'created_at'	=> '2021-12-5 13:00:00',
				'updated_at'	=> '2021-12-5 13:00:00'
			],
			[
				'customer_id'	=> rand(3, 100),
				'facility_id'	=> rand(1, 5),
				'management_id'	=> null,
				'start_date'	=> '2021-12-15 08:00:00',
				'end_date'		=> '2021-12-15 12:00:00',
				'status'		=> 0,
				'created_at'	=> '2021-12-5 13:00:00',
				'updated_at'	=> '2021-12-5 13:00:00'
			]
		];

		$this->db->table('requests')->insertBatch($data);
	}
}
