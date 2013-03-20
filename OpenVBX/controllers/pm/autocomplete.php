<?php

class Autocomplete extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->model('usergroups', 'usergroups_model');
		
//		$this->load->model('modules/tasksm', 'tasksm');
	}

	function index() 
	{
		$val = array(	array("key"	=>	"abc", "value"	=>	"1"),
						array("key"	=>	"def", "value"	=>	"2"),
						array("key"	=>	"ghi", "value"	=>	"3")
						);
		
		echo json_encode($val);
	}
	
	function priority() 
	{
		$val = array(	array("key"	=>	"2", "value"	=>	"high"),
						array("key"	=>	"1", "value"	=>	"medium"),
						array("key"	=>	"0", "value"	=>	"low")
						);
		
		echo json_encode($val);
	}
	
	function members_in_thisusers_groups()
	{
		if (!isset($_GET['id'])) { echo json_encode(array());  return; }

		$id = $_GET['id'];
		$groups = $this->usergroups_model->get_user_membership_groups($id);
		
		$group_ids = array();
		foreach ($groups as $group)
		{
			//array_push($group_ids, $group->id);
			$group_ids[] = $group->id;
		}
		
		$group_users = $this->usergroups_model->get_users_in_groups($group_ids);

		$res_encode = array();
		if (isset($_GET['userid']))
		{
			foreach ($group_users as $user)
			{
				if ($user->id == $_GET['userid']) {
					$res_encode[] = array("key"	=>	$user->id, "value"	=>	$user->first_name." ".$user->last_name); 
				}
			}
		} else {
			foreach ($group_users as $user)
			{
				$res_encode[] = array("key"	=>	$user->id, "value"	=>	$user->first_name." ".$user->last_name); 
			}
		}
		
		echo json_encode($res_encode);
		
//		var_dump($group_ids);
	}
	
	function groups() 
	{
		if (!isset($_GET['id'])) { echo json_encode(array());  return; }

		$id = $_GET['id'];
		$groups = $this->usergroups_model->get_user_membership_groups($id);

		$val = array();
		
		if (isset($_GET['groupid']))
		{
			foreach ($groups as $group)
			{
				if ($group->id == $_GET['groupid'])
				{
					array_push($val, array("key"	=>	$group->id, "value"	=>	$group->name));
				}
			}
		} else {
			foreach ($groups as $group)
			{
				array_push($val, array("key"	=>	$group->id, "value"	=>	$group->name));
			}
		}
		
		echo json_encode($val);
		return;
	}
}
