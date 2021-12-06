<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Requests extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id' => [
				'type' => 'INT',
				'unsigned' => true,
				'auto_increment' => true
			],
			'customer_id' => [
				'type' => 'INT',
				'unsigned' => true
			],
			'facility_id' => [
				'type' => 'INT',
				'unsigned' => true
			],
			'management_id' => [
				'type' => 'INT',
				'unsigned' => true,
				'null' => true
			],
			'start_date' => [
				'type' => 'DATETIME',
				'null' => true
			],
			'end_date' => [
				'type' => 'DATETIME',
				'null' => true
			],
			'status' => [
				'type' => 'TINYINT',
				'constraint' => 1,
				'default' => 0
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
		// $this->forge->addKey(['customer_id', 'facility_id'], true);
		$this->forge->addKey('id', true);

		$this->forge->addUniqueKey(['customer_id', 'facility_id']);

		$this->forge->addForeignKey('customer_id', 'accounts', 'id', 'CASCADE', 'CASCADE');
		$this->forge->addForeignKey('facility_id', 'facilities', 'id', 'CASCADE', 'CASCADE');

		$this->forge->addForeignKey('management_id', 'accounts', 'id', 'CASCADE', 'CASCADE');

		$this->forge->createTable('requests', true);
	}

	public function down()
	{
		$this->forge->dropTable('requests', true);
	}
}
