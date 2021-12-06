<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class FacilitySeeder extends Seeder
{
	public function run()
	{
		$faker = \Faker\Factory::create('id_ID');

		$temp['c'] = $faker->dateTime()->format('Y-m-d');
		$temp['u'] = $faker->dateTime($temp['c'])->format('Y-m-d');
		$temp['s'] = $faker->dateTime($temp['u'])->format('Y-m-d');
		$temp['e'] = $faker->dateTime($temp['s'])->format('Y-m-d');

		$data = [
			[
				'name'			=> 'Kolam Renang',
				'name_slug'		=> 'kolam-renang',
				'image'			=> 'facility-1.png',
				'description'	=> 'Lingkungan untuk memanjakan keperluan perairan anda. Dengan air yang jernih dan pemandangan yang memukau, anda akan menikmati momen-momen terbaik anda pada kolam renang kami',
				'customer_id'	=> null,
				'start_date'	=> null,
				'end_date'		=> null,
				'created_at'	=> $faker->dateTime($temp['c'])->format('Y-m-d'),
				'updated_at'	=> $faker->dateTime($temp['u'])->format('Y-m-d')
			],
			[
				'name'			=> 'Auditorium',
				'name_slug'		=> 'auditorium',
				'image'			=> 'facility-2.png',
				'description'	=> 'Ruangan untuk menampilkan karya anda. Area yang luas, akomodasi yang cukup, dan dukungan sound system yang memukau menjadikan karyamu yang spektakuler bisa memanjakan banyak penonton.',
				'customer_id'	=> null,
				'start_date'	=> null,
				'end_date'		=> null,
				'created_at'	=> $faker->dateTime($temp['c'])->format('Y-m-d'),
				'updated_at'	=> $faker->dateTime($temp['u'])->format('Y-m-d')
			],
			[
				'name'			=> 'Room Type A',
				'name_slug'		=> 'room-type-a',
				'image'			=> 'facility-3.png',
				'description'	=> 'Ruangan dengan nuansa minimalis menjadikan momenmu lebih tertata. Jendela yang luas memberikan tampilan sekitar yang fantastis dan leluasa. Dengan kasur yang sangat lembut menjadikan tidurmu kebahagiaan terbesar',
				'customer_id'	=> null,
				'start_date'	=> null,
				'end_date'		=> null,
				'created_at'	=> $faker->dateTime($temp['c'])->format('Y-m-d'),
				'updated_at'	=> $faker->dateTime($temp['u'])->format('Y-m-d')
			],
			[
				'name'			=> 'Meeting Room',
				'name_slug'		=> 'meeting-room',
				'image'			=> 'facility-4.png',
				'description'	=> 'Ruangan yang mendukung setiap pertemuan penting yang dimiliki organisasimu. Dengan penempatan kursi yang nyaman serta atmosfir yang ringan membuat setiap pertemuan menjadi lebih bermakna.',
				'customer_id'	=> null,
				'start_date'	=> null,
				'end_date'		=> null,
				'created_at'	=> $faker->dateTime($temp['c'])->format('Y-m-d'),
				'updated_at'	=> $faker->dateTime($temp['u'])->format('Y-m-d')
			],
			[
				'name'			=> 'Room Type B',
				'name_slug'		=> 'room-type-b',
				'image'			=> 'facility-5.png',
				'description'	=> 'Ruangan dengan nuansa santai dan megah, Ukuran yang luas membuat anda leluasa beraktivitas, pencahayaan yang redup memanjakan mata serta kasur yang lembut membuat tidur menjadi pengalaman terbaik yang pernah dirasakan.',
				'customer_id'	=> null,
				'start_date'	=> null,
				'end_date'		=> null,
				'created_at'	=> $faker->dateTime($temp['c'])->format('Y-m-d'),
				'updated_at'	=> $faker->dateTime($temp['u'])->format('Y-m-d')
			]
		];

		$this->db->table('facilities')->insertBatch($data);
	}
}
