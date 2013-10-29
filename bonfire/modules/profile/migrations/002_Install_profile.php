<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Install_profile extends Migration {

	public function up()
	{
		$prefix = $this->db->dbprefix;

		$fields = array(
			'profileID' => array(
				'type' => 'INT',
				'constraint' => 11,
				'auto_increment' => TRUE,
			),
			'name' => array(
				'type' => 'VARCHAR',
				'constraint' => 150,
				
			),
			'bio' => array(
				'type' => 'LONGTEXT',
				
			),
			'email' => array(
				'type' => 'VARCHAR',
				'constraint' => 1000,
				
			),
			'created_on' => array(
				'type' => 'datetime',
				'default' => '0000-00-00 00:00:00',
			),
			'modified_on' => array(
				'type' => 'datetime',
				'default' => '0000-00-00 00:00:00',
			),
		);
		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('profileID', true);
		$this->dbforge->create_table('profile');

	}

	//--------------------------------------------------------------------

	public function down()
	{
		$prefix = $this->db->dbprefix;

		$this->dbforge->drop_table('profile');

	}

	//--------------------------------------------------------------------

}