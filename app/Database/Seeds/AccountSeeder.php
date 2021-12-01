<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class AccountSeeder extends Seeder
{
	public function run()
	{
		$data = [
			'email'				=> getenv('ADMIN_EMAIL'),
			'username'			=> getenv('ADMIN_USERNAME'),
			'password'			=> password_hash(getenv('ADMIN_PASSWORD'), PASSWORD_DEFAULT),
			'first_name'		=> getenv('ADMIN_FIRST_NAME'),
			'last_name'			=> getenv('ADMIN_LAST_NAME'),
			'birth_date'		=> getenv('ADMIN_BIRTH_DATE'),
			'gender'			=> getenv('ADMIN_GENDER'),
			'profile_picture'	=> getenv('ADMIN_PROFILE_PICTURE'),
			'is_management'		=> true,
			'created_at'		=> Time::now(),
			'updated_at'		=> Time::now()
		];

		$this->db->table('accounts')->insert($data);

		$faker = \Faker\Factory::create('id_ID');

		for ($i = 0; $i < 100; $i++) {
			$data = [];

			$data['gender'] = $faker->boolean();
			$data['updated_at'] = $faker->dateTime()->format('Y-m-d');
			$data['created_at'] = $faker->dateTime($data['updated_at'])->format('Y-m-d');

			$data += [
				'email'				=> $faker->email(),
				'username'			=> $faker->userName(),
				'password'			=> password_hash($faker->password(), PASSWORD_DEFAULT),
				'first_name'		=> !$data['gender'] ? $faker->firstNameMale() : $faker->firstNameFemale(),
				'last_name'			=> $faker->lastName(),
				'birth_date'		=> $faker->dateTime($data['created_at'])->format('Y-m-d'),
				'profile_picture'	=> 'profile-' . (!$data['gender'] ? 'male' : 'female') . '.png',
				'is_management'		=> false
			];

			$this->db->table('accounts')->insert($data);
		}
	}
}
