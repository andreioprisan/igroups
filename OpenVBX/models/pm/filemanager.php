<?php

class Filemanager extends CI_Model {

	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
	}
	
	function get_group_files($groupid, $userid)
	{
		$query = $this->db->get_where('filemanager', array('group_id' => $groupid, 'user_id' => $userid));
		return $query->result();
	}
	
	function get_file($encID)
	{
		$query = $this->db->get_where('filemanager', array('encID' => $encID));
		return $query->row();
	}
	
	function del_file($encID)
	{
		$this->db->delete('filemanager', array('encID' => $encID)); 
	}
	
	function add_file($data)
	{
		$this->db->insert('filemanager', $data); 
	}
	
	// checks to see if the owner is allowed to see this group page
	function check_group_access_permission($group_id, $owner_id)
	{
		$query = $this->db->get_where('groups_users', array('owner_id' => $owner_id, 'group_id' => $group_id));
		
		return $query->result();
	}
	
	function format_bytes($bytes = 0) {
		if ($bytes < 1024) return $bytes.' B';
		elseif ($bytes < 1048576) return round($bytes / 1024, 2).' KB';
		elseif ($bytes < 1073741824) return round($bytes / 1048576, 2).' MB';
		elseif ($bytes < 1099511627776) return round($bytes / 1073741824, 2).' GB';
		else return round($bytes / 1099511627776, 2).' TB';
	}
}
