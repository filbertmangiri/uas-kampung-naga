<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Facility extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id' => [
				'type' => 'INT',
				'unsigned' => true,
				'auto_increment' => true
			],
			'name' => [
				'type' => 'VARCHAR',
				'constraint' => '255',
				'null' => true
			],
			'name_slug' => [
				'type' => 'VARCHAR',
				'constraint' => '255',
				'null' => true
			],
			'image' => [
				'type' => 'VARCHAR',
				'constraint' => '255',
				'default' => 'default.png'
			],
			'customer_id' => [
				'type' => 'INT',
				'unsigned' => true,
				'default' => 0
			],
			'management_id' => [
				'type' => 'INT',
				'unsigned' => true,
				'default' => 0
			],
			'rent_date' => [
				'type' => 'DATETIME',
				'null' => true
			],
			'return_date' => [
				'type' => 'DATETIME',
				'null' => true
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

		$this->forge->addUniqueKey('name');
		$this->forge->addUniqueKey('name_slug');

		$this->forge->addForeignKey('customer_id', 'accounts', 'id', 'CASCADE', 'CASCADE');
		$this->forge->addForeignKey('management_id', 'accounts', 'id', 'CASCADE', 'CASCADE');

		$this->forge->createTable('facilities', true);
	}

	public function down()
	{
		$this->forge->dropTable('facilities', true);
	}
}
