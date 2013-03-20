<?php

class Usergroups extends CI_Model {

	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
	}
	
	function get_groups_by_owner($owner_id)
	{
		$query = $this->db->get_where('groups', array('owner_id' => $owner_id, 'is_active' => '1'));
		return $query->result();
	}
	
	function get_groups_by_member($user_id)
	{
//		$query = $this->db->get_where('groups', array('owner_id' => $user_id, 'is_active' => '1'));
//		return $query->result();
	}
	
	function get_users_in_groups($group_ids_array) 
	{
		$group_ids = implode(",", $group_ids_array);
		$sql = "select distinct users.id, users.first_name, users.last_name from groups_users left join users on users.id = groups_users.user_id where groups_users.group_id in (".$group_ids.") order by users.first_name";
		$query = $this->db->query($sql);
		
		return $query->result();
	}
	
	function get_user_membership_groups($user_id)
	{
		$sql = "select groups.* from groups_users left join groups on groups.id = groups_users.group_id where groups_users.user_id = ? order by groups.id";
		$query = $this->db->query($sql, array('groups_users.user_id' => $user_id));
		
		return $query->result();
	}
	
	function get_group($group_id, $owner_id)
	{
		$query = $this->db->get_where('groups', array('id' => $group_id, 'owner_id' => $owner_id, 'is_active' => '1'));
		return $query->row();
	}
	
	function get_group_by_id($group_id)
	{
		$query = $this->db->get_where('groups', array('id' => $group_id, 'is_active' => '1'));
		return $query->row();
	}
	
	// checks to see if the owner is allowed to see this group page
	function check_group_access_permission($group_id, $user_id)
	{
		$query = $this->db->get_where('groups_users', array('user_id' => $user_id, 'group_id' => $group_id));
		return $query->result() ? $query->result() : NULL;
	}
}
