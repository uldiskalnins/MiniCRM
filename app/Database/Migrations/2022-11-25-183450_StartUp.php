<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class StartUp extends Migration
{
	public function up()
	{
		$attributes = [
			'ENGINE' => 'InnoDB',
			'CHARSET' => 'utf8mb4',
			'COLLATE' => 'utf8mb4_general_ci'
		];

		$this->forge->addField([
			'id' => [
				'type'			=> 'INT',
				'unsigned'		=> true,
				'auto_increment'=> true,
			],
			'email'	=> [
				'type'			=> 'TEXT',
			],
			'password'	=> [
				'type'			=> 'TEXT',
			],
			'name' => [
				'type'			=> 'VARCHAR',
				'constraint'	=> '100',
			],
			'surname' => [
				'type'			=> 'VARCHAR',
				'constraint'	=> '100',
			],
			'phone'	=> [
				'type'			=> 'VARCHAR',
				'constraint'	=> '100',
			],
			'user_rights' => [
				'type'			=> 'INT',
			],
			'position' => [
				'type'			=> 'VARCHAR',
				'constraint'	=> '100',
			],
			'creation_date'	=> [
				'type'			=> 'DATETIME',
			],
			'edit_date'	=> [
				'type'			=> 'DATETIME',
			],
			'sex' => [
				'type'			=> 'SMALLINT',
				'constraint'	=> '1',
			],
			'active' => [
				'type'			=> 'SMALLINT',
				'constraint'	=> '1',
			],
			'activity_date'	=> [
				'type'			=> 'DATETIME',
			],
		]);

		$this->forge->addKey('id', true);
		$this->forge->createTable('mc_users', true, $attributes);





		$this->forge->addField([
			'id' => [
				'type'			=> 'INT',
				'unsigned'		=> true,
				'auto_increment'=> true,
			],
			'title' => [
				'type'			=> 'TEXT',
			],
			'reg_nr' => [
				'type'			=> 'VARCHAR',
				'constraint'	=> '11',
			],
			'vat_nr' => [
				'type'			=> 'VARCHAR',
				'constraint'	=> '13',
			],
			'email' => [
				'type'			=> 'TEXT',
			],
			'phone'	=> [
				'type'			=> 'VARCHAR',
				'constraint'	=> '100',
			],
			'second_phone'	=> [
				'type'			=> 'VARCHAR',
				'constraint'	=> '100',
			],
			'fax' => [
				'type'			=> 'VARCHAR',
				'constraint'	=> '100',
			],
			'website'	=> [
				'type'			=> 'TEXT',
			],
			'bank_title' => [
				'type'			=> 'VARCHAR',
				'constraint'	=> '150',
			],
			'bank_code'	=> [
				'type'			=> 'VARCHAR',
				'constraint'	=> '11',
			],
			'bank_acc_nr'	=> [
				'type'			=> 'VARCHAR',
				'constraint'	=> '34',
			],
			'city'	=> [
				'type'			=> 'VARCHAR',
				'constraint'	=> '100',
			],
			'country'	=> [
				'type'			=> 'VARCHAR',
				'constraint'	=> '100',
			],
			'address1'	=> [
				'type'			=> 'TEXT',
			],
			'address2'	=> [
				'type'			=> 'TEXT',
			],
			'postal_code'	=> [
				'type'			=> 'VARCHAR',
				'constraint'	=> '10',
			],
			'description' => [
				'type'			=> 'TEXT',
			],
			'industry' => [
				'type'			=> 'SMALLINT',
				'unsigned'		=> true,
			],
			'type' => [
				'type'			=> 'SMALLINT',
				'unsigned'		=> true,
			],
			'creation_date'	=> [
				'type'			=> 'DATETIME',
			],
			'edit_date'	=> [
				'type'			=> 'DATETIME',
			],
			'user_id' => [
				'type'			=> 'INT',
				'unsigned'		=> true,
			],
			'active' => [
				'type'			=> 'SMALLINT',
				'unsigned'		=> true,
				'constraint'	=> '1',
			],
			'lead_id' => [
				'type'			=> 'INT',
				'unsigned'		=> true,
			],
		]);

		$this->forge->addKey('id', true);
		$this->forge->createTable('mc_companies', true, $attributes);



		$this->forge->addField([
			'id' => [
				'type'			=> 'INT',
				'unsigned'		=> true,
				'auto_increment'=> true,
			],
			'name' => [
				'type'			=> 'VARCHAR',
				'constraint'	=> '100',
			],
			'surname' => [
				'type'			=> 'VARCHAR',
				'constraint'	=> '100',
			],
			'phone' => [
				'type'			=> 'VARCHAR',
				'constraint'	=> '100',
			],
			'second_phone' => [
				'type'			=> 'VARCHAR',
				'constraint'	=> '100',
			],
			'email' => [
				'type'			=> 'TEXT',
			],
			'social_network' => [
				'type'			=> 'TEXT',
			],
			'website' => [
				'type'			=> 'TEXT',
			],
			'company_id' => [
				'type'			=> 'INT',
			],
			'position' => [
				'type'			=> 'TINYTEXT',
			],
			'city' => [
				'type'			=> 'VARCHAR',
				'constraint'	=> '100',
			],
			'country' => [
				'type'			=> 'VARCHAR',
				'constraint'	=> '100',
			],
			'address1' => [
				'type'			=> 'TEXT',
			],
			'address2' => [
				'type'			=> 'TEXT',
				'null'			=> true,
			],
			'postal_code' => [
				'type'			=> 'VARCHAR',
				'constraint'	=> '10',
			],
			'nin' => [
				'type'			=> 'VARCHAR',
				'constraint'	=> '11',
			],
			'bank_title' => [
				'type'			=> 'VARCHAR',
				'constraint'	=> '150',
			],
			'bank_code'	=> [
				'type'			=> 'VARCHAR',
				'constraint'	=> '11',
			],
			'bank_acc_nr'	=> [
				'type'			=> 'VARCHAR',
				'constraint'	=> '34',
			],
			'description' => [
				'type'			=> 'TEXT',
				'null'			=> true,
			],
			'birthday' => [
				'type'			=> 'DATE',
			],
			'creation_date' => [
				'type'			=> 'DATETIME',
			],
			'edit_date' => [
				'type'			=> 'DATETIME',
			],
			'user_id' => [
				'type'			=> 'INT',
				'unsigned'		=> true,
			],
			'active' => [
				'type'			=> 'SMALLINT',
				'unsigned'		=> true,
				'constraint'	=> '1',
			],
			'lead_id' => [
				'type'			=> 'INT',
				'unsigned'		=> true,
			],
		]);

		$this->forge->addKey('id', true);
		$this->forge->createTable('mc_persons', true, $attributes);




		$this->forge->addField([
			'id' => [
				'type'			=> 'INT',
				'unsigned'		=> true,
				'auto_increment'=> true,
			],
			'name' => [
				'type'			=> 'VARCHAR',
				'constraint'	=> '100',
			],
			'surname' => [
				'type'			=> 'VARCHAR',
				'constraint'	=> '100',
			],
			'phone' => [
				'type'			=> 'VARCHAR',
				'constraint'	=> '100',
			],
			'email' => [
				'type'			=> 'TEXT',
			],
			'social_network' => [
				'type'			=> 'TEXT',
			],
			'website' => [
				'type'			=> 'TEXT',
			],
			'position' => [
				'type'			=> 'TINYTEXT',
			],
			'account' => [
				'type'			=> 'TINYTEXT',
			],
			'city' => [
				'type'			=> 'VARCHAR',
				'constraint'	=> '100',
			],
			'country' => [
				'type'			=> 'VARCHAR',
				'constraint'	=> '100',
			],
			'address1' => [
				'type'			=> 'TEXT',
			],
			'address2' => [
				'type'			=> 'TEXT',
			],
			'postal_code' => [
				'type'			=> 'VARCHAR',
				'constraint'	=> '10',
			],
			'description' => [
				'type'			=> 'TEXT',
				'null'			=> true,
			],
			'status' => [
				'type'			=> 'SMALLINT',
				'unsigned'		=> true,
			],
			'source' => [
				'type'			=> 'SMALLINT',
				'unsigned'		=> true,
			],
			'industry' => [
				'type'			=> 'SMALLINT',
				'unsigned'		=> true,
			],
			'amount' => [
				'type'			=> 'INT',
			],
			'creation_date' => [
				'type'			=> 'DATETIME',
			],
			'edit_date' => [
				'type'			=> 'DATETIME',
			],
			'user_id' => [
				'type'			=> 'INT',
				'unsigned'		=> true,
			],
			'active' => [
				'type'			=> 'SMALLINT',
				'unsigned'		=> true,
				'constraint'	=> '1',
			],

		]);

		$this->forge->addKey('id', true);
		$this->forge->createTable('mc_leads', true, $attributes);






		$this->forge->addField([
			'id' => [
				'type'			=> 'SMALLINT',
				'unsigned'		=> true,
				'auto_increment'=> true,
			],
			'parent'			=> [
				'type'			=> 'TEXT',
			],
			'url'			=> [
				'type'			=> 'TEXT',
			],
			'type'			=> [
				'type'			=> 'SMALLINT',
			],

		]);
		$this->forge->addKey('id', true);
		$this->forge->createTable('mc_posts_parents', true, $attributes);


		 $data = [

			['id' => 1,'parent' => "Accounts", 'url' => "crm/company/", 'type' => 1 ],
			['id' => 2,'parent' => "Contacts", 'url' => "crm/person/", 'type' => 1 ],
			['id' => 3,'parent' => "Leads", 'url' => "crm/lead/", 'type' => 1 ],
			['id' => 4,'parent' => "Calls", 'url' => "crm/activities/call/", 'type' => 2 ],
			['id' => 5,'parent' => "Meetings", 'url' => "crm/activities/meeting/", 'type' => 2 ],
			['id' => 6,'parent' => "Emails", 'url' => "crm/activities/email/", 'type' => 2 ],
			['id' => 7,'parent' => "Tasks", 'url' => "crm/activities/task/", 'type' => 2 ],
			['id' => 8,'parent' => "Opportunities", 'url' => "crm/opportunity/", 'type' => 3 ],
			['id' => 9,'parent' => "Users", 'url' => "", 'type' => 4 ],
		];

		$this->db->table('mc_posts_parents')->insertBatch($data);


		$this->forge->addField([
			'id' => [
				'type'			=> 'INT',
				'unsigned'		=> true,
				'auto_increment'=> true,
			],
			'title'	=> [
				'type'			=> 'TEXT',
			],
			'description'	=> [
				'type'			=> 'TEXT',
			],
			'start_date'	=> [
				'type'			=> 'DATETIME',
				'null' => true,
			],
			'end_date'	=> [
				'type'			=> 'DATETIME',
				'null' => true,
			],
			'status' => [
				'type'			=> 'SMALLINT',
				'unsigned'		=> true,
				'constraint'	=> '1',
			],
			'priority' => [
				'type'			=> 'SMALLINT',
				'unsigned'		=> true,
				'constraint'	=> '1',
			],
			'parent_type' => [
				'type'			=> 'SMALLINT',
				'unsigned'		=> true,
			],
			'parent_id' => [
				'type'			=> 'INT',
				'unsigned'		=> true,
			],
			'user_id' => [
				'type'			=> 'INT',
				'unsigned'		=> true,
			],
			'creation_date' => [
				'type'			=> 'DATETIME',
			],
			'edit_date' => [
				'type'			=> 'DATETIME',
			],
			'active' => [
				'type'			=> 'SMALLINT',
				'unsigned'		=> true,
				'constraint'	=> '1',
			],
		]);

		$this->forge->addKey('id', true);
		$this->forge->addForeignKey('parent_type', 'mc_posts_parents', 'id');
		$this->forge->createTable('mc_tasks', true, $attributes);







		$this->forge->addField([
			'id' =>				[
				'type'			=> 'INT',
				'unsigned'		=> true,
				'auto_increment'=> true,
			],
			'subject'		=> [
				'type'			=> 'TEXT',
			],
			'body'			=> [
				'type'			=> 'TEXT',
			],
			'from_email'	=> [
				'type'			=> 'TEXT',
			],
			'from_name'		=> [
				'type'			=> 'TEXT',
			],
			'to_email'		=> [
				'type'			=> 'TEXT',
			],
			'cc'			=> [
				'type'			=> 'TEXT',
			],
			'bcc'			=> [
				'type'			=> 'TEXT',
			],
			'action_type'	=> [
				'type'			=> 'SMALLINT',
				'unsigned'		=> true,
				'constraint'	=> '1',
			],
			'parent_type'=> [
				'type'			=> 'SMALLINT',
				'unsigned'		=> true,
			],
			'parent_id'		=> [
				'type'			=> 'INT',
				'unsigned'		=> true,
			],
			'user_id'		=> [
				'type'			=> 'INT',
				'unsigned'		=> true,
			],
			'email_date' => [
				'type'			=> 'DATETIME',
			],
			'creation_date' => [
				'type'			=> 'DATETIME',
			],
			'edit_date'		=> [
				'type'			=> 'DATETIME',
			],
			'active' => [
				'type'			=> 'SMALLINT',
				'unsigned'		=> true,
				'constraint'	=> '1',
			],
		]);

		$this->forge->addKey('id', true);
		$this->forge->addForeignKey('parent_type', 'mc_posts_parents', 'id');
		$this->forge->createTable('mc_emails', true, $attributes);






		$this->forge->addField([
			'id'			=>[
				'type'			=> 'INT',
				'unsigned'		=> true,
				'auto_increment'=> true,
			],
			'file_name'		=>[
				'type'			=> 'TEXT',
			],
			'parent_type'=>[
				'type'			=> 'SMALLINT',
				'unsigned'		=> true,
			],
			'parent_id'		=>[
				'type'			=> 'INT',
				'unsigned'		=> true,
			],
			'user_id'		=>[
				'type'			=> 'INT',
				'unsigned'		=> true,
			],
			'creation_date'	=>[
				'type'			=> 'DATETIME',
			],

		]);

		$this->forge->addKey('id', true);
		$this->forge->addForeignKey('parent_type', 'mc_posts_parents', 'id');
		$this->forge->createTable('mc_files', true, $attributes);





		$this->forge->addField([
			'id' => [
				'type'			=> 'INT',
				'unsigned'		=> true,
				'auto_increment'=> true,
			],
			'action_type' => [
				'type'			=> 'TINYTEXT',
			],
			'parent_type'=>[
				'type'			=> 'SMALLINT',
				'unsigned'		=> true,
			],
			'parent_id'		=>[
				'type'			=> 'INT',
				'unsigned'		=> true,
			],
			'super_parent_type'=>[
				'type'			=> 'INT',
				'unsigned'		=> true,
			],
			'super_parent_id'		=>[
				'type'			=> 'INT',
				'unsigned'		=> true,
			],
			'user_id'		=>[
				'type'			=> 'INT',
				'unsigned'		=> true,
			],
			'creation_date'	=>[
				'type'			=> 'DATETIME',
			],
			'data'		=> [
				'type'			=> 'TEXT',
			],
			'active' => [
				'type'			=> 'SMALLINT',
				'unsigned'		=> true,
				'constraint'	=> '1',
			],
		]);

		$this->forge->addKey('id', true);
		$this->forge->createTable('mc_action_history', true, $attributes);



		$this->forge->addField([
			'id' => [
				'type'			=> 'INT',
				'unsigned'		=> true,
				'auto_increment'=> true,
			],
			'setting' => [
				'type'			=> 'VARCHAR',
				'constraint'	=> '100',
			],
			'value'		=> [
				'type'			=> 'TEXT',
			],
		]);
		$this->forge->addKey('id', true);
		$this->forge->createTable('mc_settings', true, $attributes);



		 $data = [
			['setting' => "allowToSeeOtherUsersRecords",'value' => '0'],
			['setting' => "smtpServer",'value' => ''],
			['setting' => "smtpUser",'value' => ''],
			['setting' => "smtpPass",'value' => ''],
			['setting' => "smtpPort",'value' => ''],
			['setting' => "smtpEncryption",'value' => ''],
			['setting' => "useSmtp",'value' => '0'],
			['setting' => "language",'value' => 'en'],
			['setting' => "roundCurrencyDecimalPlaces",'value' => '1'],
			['setting' => "defaultCurrency",'value' => '1'],
		];

		$this->db->table('mc_settings')->insertBatch($data);



		$this->forge->addField([
			'id' 		=> [
				'type'			=> 'INT',
				'unsigned'		=> true,
				'auto_increment'=> true,
			],
			'currency_code'	=> [
				'type'			=> 'TINYTEXT',
			],
			'currency_sign'	=> [
				'type'			=> 'TINYTEXT',
			],
			'currency_name'	=> [
				'type'			=> 'TINYTEXT',
			],
			'rate'=> [
				'type' =>		'DECIMAL',
				'constraint' =>	'10,4',
			],
		]);


		$this->forge->addKey('id', true);
		$this->forge->createTable('mc_currencies', true, $attributes); // 


		$data = [
			['currency_code' => "EUR",'currency_name' => "Euro", 'currency_sign' => "€", 'rate' => '1'],
			['currency_code' => "USD",'currency_name' => "US Dollar", 'currency_sign' => "$",  'rate' => '1.04'],
		];

		$this->db->table('mc_currencies')->insertBatch($data);




		$this->forge->addField([
			'id' => [
				'type'			=> 'INT',
				'unsigned'		=> true,
				'auto_increment'=> true,
			],
			'title'	=> [
				'type'			=> 'TEXT',
			],
			'description'	=> [
				'type'			=> 'TEXT',
			],
			'stage' => [
				'type'			=> 'SMALLINT',
				'unsigned'		=> true,
			],
			'amount'=> [
				'type' =>		'DECIMAL',
				'constraint' =>	'15,4',
			],
			'probability' => [
				'type'			=> 'SMALLINT',
				'unsigned'		=> true,
			],
			'currency' => [
				'type'			=> 'VARCHAR',
				'constraint'	=> '3',
			],
			'close_date'	=> [
				'type'			=> 'DATETIME',
			],
			'parent_id' => [
				'type'			=> 'INT',
				'unsigned'		=> true,
			],
			'parent_type' => [
				'type'			=> 'SMALLINT',
				'unsigned'		=> true,
			],
			'lead_source' => [
				'type'			=> 'SMALLINT',
				'unsigned'		=> true,
			],
			'user_id' => [
				'type'			=> 'INT',
				'unsigned'		=> true,
			],
			'creation_date' => [
				'type'			=> 'DATETIME',
			],
			'edit_date' => [
				'type'			=> 'DATETIME',
			],
			'active' => [
				'type'			=> 'SMALLINT',
				'unsigned'		=> true,
				'constraint'	=> '1',
			],
		]);

		$this->forge->addKey('id', true);
		$this->forge->addForeignKey('parent_type', 'mc_posts_parents', 'id');
		$this->forge->createTable('mc_opportunities', true, $attributes);







		$this->forge->addField([
			'id' => [
				'type'			=> 'INT',
				'unsigned'		=> true,
				'auto_increment'=> true,
			],
			'title'	=> [
				'type'			=> 'TEXT',
			],
			'description'	=> [
				'type'			=> 'TEXT',
			],
			'start_date'	=> [
				'type'			=> 'DATETIME',
			],
			'end_date'	=> [
				'type'			=> 'DATETIME',
			],
			'status' => [
				'type'			=> 'SMALLINT',
				'unsigned'		=> true,
				'constraint'	=> '1',
			],
			'parent_id' => [
				'type'			=> 'INT',
				'unsigned'		=> true,
			],
			'parent_type' => [
				'type'			=> 'SMALLINT',
				'unsigned'		=> true,
			],
			'user_id' => [
				'type'			=> 'INT',
				'unsigned'		=> true,
			],
			'creation_date' => [
				'type'			=> 'DATETIME',
			],
			'edit_date' => [
				'type'			=> 'DATETIME',
			],
			'active' => [
				'type'			=> 'SMALLINT',
				'unsigned'		=> true,
				'constraint'	=> '1',
			],
		]);

		$this->forge->addKey('id', true);
		$this->forge->addForeignKey('parent_type', 'mc_posts_parents', 'id');
		$this->forge->createTable('mc_meetings', true, $attributes);



		$this->forge->addField([
			'id' 		=> [
				'type'			=> 'INT',
				'unsigned'		=> true,
				'auto_increment'=> true,
			],
			'meeting_id'	=> [
				'type'			=> 'INT',
				'unsigned'		=> true,
			],
			'parent_type' => [
				'type'			=> 'SMALLINT',
				'unsigned'		=> true,
			],
			'parent_id' => [
				'type'			=> 'INT',
				'unsigned'		=> true,
			],
		]);


		$this->forge->addKey('id', true);
		$this->forge->addForeignKey('meeting_id', 'mc_meetings', 'id');
		$this->forge->addForeignKey('parent_type', 'mc_posts_parents', 'id');
		$this->forge->createTable('mc_meetings_participants', true, $attributes);



		$this->forge->addField([
			'id' => [
				'type'			=> 'INT',
				'unsigned'		=> true,
				'auto_increment'=> true,
			],
			'title'	=> [
				'type'			=> 'TEXT',
			],
			'description'	=> [
				'type'			=> 'TEXT',
			],
			'start_date'	=> [
				'type'			=> 'DATETIME',
			],
			'end_date'	=> [
				'type'			=> 'DATETIME',
			],
			'status' => [
				'type'			=> 'SMALLINT',
				'unsigned'		=> true,
				'constraint'	=> '1',
			],
			'type' => [
				'type'			=> 'SMALLINT',
				'unsigned'		=> true,
				'constraint'	=> '1',
			],
			'parent_id' => [
				'type'			=> 'INT',
				'unsigned'		=> true,
			],
			'parent_type' => [
				'type'			=> 'SMALLINT',
				'unsigned'		=> true,
			],
			'user_id' => [
				'type'			=> 'INT',
				'unsigned'		=> true,
			],
			'creation_date' => [
				'type'			=> 'DATETIME',
			],
			'edit_date' => [
				'type'			=> 'DATETIME',
			],
			'active' => [
				'type'			=> 'SMALLINT',
				'unsigned'		=> true,
				'constraint'	=> '1',
			],
		]);

		$this->forge->addKey('id', true);
		$this->forge->addForeignKey('parent_type', 'mc_posts_parents', 'id');
		$this->forge->createTable('mc_calls', true, $attributes);



		$this->forge->addField([
			'id' 		=> [
				'type'			=> 'INT',
				'unsigned'		=> true,
				'auto_increment'=> true,
			],
			'call_id'	=> [
				'type'			=> 'INT',
				'unsigned'		=> true,
			],
			'parent_type' => [
				'type'			=> 'SMALLINT',
				'unsigned'		=> true,
			],
			'parent_id' => [
				'type'			=> 'INT',
				'unsigned'		=> true,
			],
		]);

		$this->forge->addKey('id', true);
		$this->forge->addForeignKey('call_id', 'mc_calls', 'id');
		$this->forge->addForeignKey('parent_type', 'mc_posts_parents', 'id');
		$this->forge->createTable('mc_calls_participants', true, $attributes);




	}

	public function down()
	{
		//
	}
}
