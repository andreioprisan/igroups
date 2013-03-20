<?php

class Accounts extends CI_Controller {
	var $owner_id = "1";

	function __construct()
	{
		parent::__construct();
		$this->load->model('igroups_group');
		$this->load->model('igroups_user');
		
	}

	function index()
	{
		//add
	}
	
	public function group($method)
	{
		switch($method) {
			case 'get':
				return $this->get_group();
			case 'save':
				return $this->save_group();
			case 'delete':
				return $this->delete_group();
			default:
				$json = array('success' => FALSE,
							  'error' => "No such method [$method]");
				echo json_encode($json);
				break;
		}

		//return $this->respond('', 'accounts', $data);
	}
	
	public function user($method)
	{
//		if(!$this->session->userdata('is_admin'))
//			redirect('');

		switch($method)
		{
			case 'get':
				return $this->get_user();
			case 'save':
				return $this->save_user();
			case 'delete':
				return $this->delete_user();
			default:
				$json = array('success' => FALSE,
							  'error' => "No such method [$method]");
				echo json_encode($json);
				break;
		}
	}
	
	public function group_user($method)
	{
//		if(!$this->session->userdata('is_admin'))
//			redirect('');

		switch($method)
		{
			case 'get':
				return $this->get_user();
			case 'save':
				return $this->save_user();
			case 'delete':
				return $this->groupuser_delete(); // ok
			case 'add':
				return $this->groupuser_add();
			default:
				$json = array('success' => FALSE,
							  'error' => "No such method [$method]");
				echo json_encode($json);
				break;
		}
	}
	
	public function groupuser_delete()
	{
		if ($this->input->post('group_id'))
		{
			$group_id = $this->input->post('group_id');
		} else if ($this->input->get('group_id'))
		{
			$group_id = intval($this->input->get('group_id'));
		} else {
			$group_id = NULL;
		}

		if ($this->input->post('user_id'))
		{
			$user_id = $this->input->post('user_id');
		} else if ($this->input->get('user_id'))
		{
			$user_id = intval($this->input->get('user_id'));
		} else {
			$user_id = NULL;
		}

		$success = false;
		$errors = "unknown";

		$user = $this->igroups_group->remove_groupuser($this->owner_id, $group_id, $user_id);
		//var_dump($user);
		if ($user)
		{
			$success = true;
			$errors = "";
		}

		$json = compact('success', 'errors');

		echo json_encode($json);
	}

	public function groupuser_add()
	{
		if ($this->input->post('group_id'))
		{
			$group_id = $this->input->post('group_id');
		} else if ($this->input->get('group_id'))
		{
			$group_id = intval($this->input->get('group_id'));
		} else {
			$group_id = NULL;
		}

		if ($this->input->post('user_id'))
		{
			$user_id = $this->input->post('user_id');
		} else if ($this->input->get('user_id'))
		{
			$user_id = intval($this->input->get('user_id'));
		} else {
			$user_id = NULL;
		}

		$success = false;
		$errors = "unknown";

		$user = $this->igroups_group->add_groupuser($this->owner_id, $group_id, $user_id);
		//var_dump($user);
		if ($user)
		{
			$success = true;
			$errors = "";
		}

		$json = compact('success', 'errors');

		echo json_encode($json);
		// TODO: delete it
	}	
	
	public function get_user()
	{
		if ($this->input->post('id'))
		{
			$user_id = $this->input->post('id');
		} else if ($this->input->get('id'))
		{
			$user_id = intval($this->input->get('id'));
		} else {
			$user_id = NULL;
		}
		
		$user = $this->igroups_group->get_user(array('id' => $user_id));
		
		echo json_encode($user);
	}

	public function save_user()
	{
		$user = false;
		$id = intval($this->input->post('id'));
		$auth_type = $this->input->post('auth_type');
		
		$errors = array();
		$error = false;
		$message = "Failed to save user for unknown reason.";
		
		$shouldGenerateNewPassword = false;
		
		$device_id_str = trim($this->input->post('device_id'));
		$device_number = trim($this->input->post('phone_number'));
		$shouldSendWelcome = false;
		//phone_number
		if($id > 0)
		{
			$user_obj = $this->igroups_group->get_user(array('id' => $id));
			foreach ($user_obj as $key => $item)
			{
				$user[$key] = $item;
			}
		}
		else
		{
			$user = $this->igroups_group->get_user(array('email' => $this->input->post('email')));
			if(!empty($user) && $user->is_active == 1)
			{
				$error = true;
				$message = 'Email address is already in use.';
			}
			elseif (!empty($user) && $user->is_active == 0)
			{
				// It's an old account that was made inactive.  By re-adding it, we're
				// assuming the user wants to re-instate the old account.
				$shouldSendWelcome = true;
			}
			else
			{
				// It's a new user
				$user = array();
				$shouldSendWelcome = true;
			}
		}

		
		if (!$error)
		{
			$fields = array('first_name',
							'last_name',
							'email',
							'is_admin',
							'phone_number');

			foreach($fields as $field)
			{
				$user[$field] = $this->input->post($field);
			}

			$user['owner_id'] = $this->owner_id;
			$user['is_active'] = true;
			$user['auth_type'] = isset($auth_type) ? $auth_type : 1;

			if ($id > 0) {
				$user_item = $this->igroups_group->update_user($user['id'], $user);
			} else {
				$user_item = $this->igroups_group->add_user($user);
			}
		}

		if ($error)
		{
			$json = array(
				'error' => $error,
				'message' => $message
			);
		}
		else
		{
			$json = array(
				'id' => $user_item->id,
				'first_name' => $user_item->first_name,
				'last_name' => $user_item->last_name,
				'is_active' => $user_item->is_active,
				'is_admin' => $user_item->is_admin,
				'phone_number' => $user_item->phone_number,
				'notification' => $user_item->notification,
				'auth_type' => $auth_type,
				'email' => $user_item->email,
				'error' => false,
				'message' => '',
				'online' => $user_item->online
			);
		}

		echo json_encode($json);
	}

	public function delete_user()
	{
		if ($this->input->post('id'))
		{
			$id = $this->input->post('id');
		} else if ($this->input->get('id'))
		{
			$id = intval($this->input->get('id'));
		} else {
			$id = NULL;
		}

		$success = false;
		$errors = "unknown";

		$user = $this->igroups_group->remove_user($this->owner_id, $id);

		if ($user)
		{
			$success = true;
			$errors = "";
		}

		$json = compact('success', 'errors');

		echo json_encode($json);
		// TODO: delete it
	}
	
	
	public function get_group()
	{
		if ($this->input->post('id'))
		{
			$id = $this->input->post('id');
		} else if ($this->input->get('id'))
		{
			$id = intval($this->input->get('id'));
		} else {
			$id = NULL;
		}
		
		$group = $this->igroups_group->get($id);
		$json = $group;

		echo json_encode($json);
	}

	public function save_group()
	{
		if ($this->input->post('id'))
		{
			$id = $this->input->post('id');
		} else if ($this->input->get('id'))
		{
			$id = intval($this->input->get('id'));
		} else {
			$id = NULL;
		}
		
		if ($this->input->post('name'))
		{
			$name = $this->input->post('name');
		} else if ($this->input->get('name'))
		{
			$name = $this->input->get('name');
		} else {
			$name = NULL;
		}
		
		$error = false;
		$message = '';

		if($id > 0)
		{
			$group = $this->igroups_group->update_group($id, array('name' => $name));
		}
		else
		{
			$group = $this->igroups_group->add_group(array('name' => $name, 'owner_id' => $this->owner_id));
		}

		$json = array('name' => $group->name,
					  'id' => $group->id,
					  'error' => $error,
					  'message' => $message);

		echo json_encode($json);
	}

	public function delete_group()
	{
		if ($this->input->post('id'))
		{
			$id = $this->input->post('id');
		} else if ($this->input->get('id'))
		{
			$id = intval($this->input->get('id'));
		} else {
			$id = NULL;
		}
		
		$json = array('message' => '',
					  'error' => false);

		$group = $this->igroups_group->remove_groupuser($this->owner_id, $id, NULL);
		$group = $this->igroups_group->delete(array('id' => $id));
		
		if (!$group){
			$json['message'] = 'Unable to deactivate';
			$json['error'] = true;
		}

		echo json_encode($json);
	}
	
}

?>