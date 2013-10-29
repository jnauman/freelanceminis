<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Profile_model extends BF_Model {

	protected $table		= "profile";
	protected $key			= "profileID";
	protected $soft_deletes	= false;
	protected $date_format	= "datetime";
	protected $set_created	= true;
	protected $set_modified = true;
	protected $created_field = "created_on";
	protected $modified_field = "modified_on";
}
