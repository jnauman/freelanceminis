<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class developer extends Admin_Controller {

	//--------------------------------------------------------------------


	public function __construct()
	{
		parent::__construct();

		$this->auth->restrict('Profile.Developer.View');
		$this->load->model('profile_model', null, true);
		$this->lang->load('profile');
		
		Template::set_block('sub_nav', 'developer/_sub_nav');
	}

	//--------------------------------------------------------------------



	/*
		Method: index()

		Displays a list of form data.
	*/
	public function index()
	{

		// Deleting anything?
		if (isset($_POST['delete']))
		{
			$checked = $this->input->post('checked');

			if (is_array($checked) && count($checked))
			{
				$result = FALSE;
				foreach ($checked as $pid)
				{
					$result = $this->profile_model->delete($pid);
				}

				if ($result)
				{
					Template::set_message(count($checked) .' '. lang('profile_delete_success'), 'success');
				}
				else
				{
					Template::set_message(lang('profile_delete_failure') . $this->profile_model->error, 'error');
				}
			}
		}

		$records = $this->profile_model->find_all();

		Template::set('records', $records);
		Template::set('toolbar_title', 'Manage Profile');
		Template::render();
	}

	//--------------------------------------------------------------------



	/*
		Method: create()

		Creates a Profile object.
	*/
	public function create()
	{
		$this->auth->restrict('Profile.Developer.Create');

		if ($this->input->post('save'))
		{
			if ($insert_id = $this->save_profile())
			{
				// Log the activity
				$this->activity_model->log_activity($this->current_user->id, lang('profile_act_create_record').': ' . $insert_id . ' : ' . $this->input->ip_address(), 'profile');

				Template::set_message(lang('profile_create_success'), 'success');
				Template::redirect(SITE_AREA .'/developer/profile');
			}
			else
			{
				Template::set_message(lang('profile_create_failure') . $this->profile_model->error, 'error');
			}
		}
		Assets::add_module_js('profile', 'profile.js');

		Template::set('toolbar_title', lang('profile_create') . ' Profile');
		Template::render();
	}

	//--------------------------------------------------------------------



	/*
		Method: edit()

		Allows editing of Profile data.
	*/
	public function edit()
	{
		$id = $this->uri->segment(5);

		if (empty($id))
		{
			Template::set_message(lang('profile_invalid_id'), 'error');
			redirect(SITE_AREA .'/developer/profile');
		}

		if (isset($_POST['save']))
		{
			$this->auth->restrict('Profile.Developer.Edit');

			if ($this->save_profile('update', $id))
			{
				// Log the activity
				$this->activity_model->log_activity($this->current_user->id, lang('profile_act_edit_record').': ' . $id . ' : ' . $this->input->ip_address(), 'profile');

				Template::set_message(lang('profile_edit_success'), 'success');
			}
			else
			{
				Template::set_message(lang('profile_edit_failure') . $this->profile_model->error, 'error');
			}
		}
		else if (isset($_POST['delete']))
		{
			$this->auth->restrict('Profile.Developer.Delete');

			if ($this->profile_model->delete($id))
			{
				// Log the activity
				$this->activity_model->log_activity($this->current_user->id, lang('profile_act_delete_record').': ' . $id . ' : ' . $this->input->ip_address(), 'profile');

				Template::set_message(lang('profile_delete_success'), 'success');

				redirect(SITE_AREA .'/developer/profile');
			} else
			{
				Template::set_message(lang('profile_delete_failure') . $this->profile_model->error, 'error');
			}
		}
		Template::set('profile', $this->profile_model->find($id));
		Assets::add_module_js('profile', 'profile.js');

		Template::set('toolbar_title', lang('profile_edit') . ' Profile');
		Template::render();
	}

	//--------------------------------------------------------------------


	//--------------------------------------------------------------------
	// !PRIVATE METHODS
	//--------------------------------------------------------------------

	/*
		Method: save_profile()

		Does the actual validation and saving of form data.

		Parameters:
			$type	- Either "insert" or "update"
			$id		- The ID of the record to update. Not needed for inserts.

		Returns:
			An INT id for successful inserts. If updating, returns TRUE on success.
			Otherwise, returns FALSE.
	*/
	private function save_profile($type='insert', $id=0)
	{
		if ($type == 'update') {
			$_POST['profileID'] = $id;
		}

		
		$this->form_validation->set_rules('profile_name','Name','required|trim|xss_clean|max_length[150]');
		$this->form_validation->set_rules('profile_bio','Bio','trim|xss_clean');
		$this->form_validation->set_rules('profile_email','email','required|trim|valid_email|max_length[1000]');

		if ($this->form_validation->run() === FALSE)
		{
			return FALSE;
		}

		// make sure we only pass in the fields we want
		
		$data = array();
		$data['name']        = $this->input->post('profile_name');
		$data['bio']        = $this->input->post('profile_bio');
		$data['email']        = $this->input->post('profile_email');

		if ($type == 'insert')
		{
			$id = $this->profile_model->insert($data);

			if (is_numeric($id))
			{
				$return = $id;
			} else
			{
				$return = FALSE;
			}
		}
		else if ($type == 'update')
		{
			$return = $this->profile_model->update($id, $data);
		}

		return $return;
	}

	//--------------------------------------------------------------------



}