<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Account extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id' => [
				'type' => 'INT',
				'unsigned' => true,
				'auto_increment' => true
			],
			'email' => [
				'type' => 'VARCHAR',
				'constraint' => '255',
				'null' => true
			],
			'username' => [
				'type' => 'VARCHAR',
				'constraint' => '100',
				'null' => true
			],
			'password' => [
				'type' => 'VARCHAR',
				'constraint' => '255',
				'null' => true
			],
			'first_name' => [
				'type' => 'VARCHAR',
				'constraint' => '100',
				'null' => true
			],
			'last_name' => [
				'type' => 'VARCHAR',
				'constraint' => '100',
				'null' => true
			],
			'birth_date' => [
				'type' => 'DATE',
				'null' => true
			],
			'gender' => [
				'type' => 'BIT',
				'default' => false
			],
			'profile_picture' => [
				'type' => 'VARCHAR',
				'constraint' => '255',
				'default' => 'default.png'
			],
			'is_management' => [
				'type' => 'BIT',
				'default' => false
			],
			'created_at' => [
				'type' => 'DATETIME',
				'null' => true
			],
			'updated_at' => [
				'type' => 'DATETIME',
				'null' => true
			],
			'deleted_at' => [
				'type' => 'DATETIME',
				'null' => true
			],
		]);

		$this->forge->addKey('id', true);
		$this->forge->addUniqueKey('email');
		$this->forge->addUniqueKey('username');

		$this->forge->createTable('accounts', true);
	}

	public function down()
	{
		$this->forge->dropTable('accounts', true);
	}
}
