<?php

class Users extends CI_Model {

	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
	}
	
	function add($data)
	{
		$this->db->insert('users', $data); 
		return $this->db->insert_id();
	}
	
	function update($fb_uid, $data)
	{
		$result = $this->db->update('users', $data, array('fb_uid' => $fb_uid)); 
		return $result;
	}
	
	function get_by_id($id)
	{
		$query = $this->db->get_where('users', array('id' => $id));
		return $query->result();
	}

	function get_by_fbuid($id)
	{
		$query = $this->db->get_where('users', array('fb_uid' => $id));
		return $query->result();
	}

	function get_name($id)
	{
		$query = $this->db->query('SELECT concat(users.first_name, " ", users.last_name) as fullname FROM users WHERE users.id = ?', array('id' => $id));
		return $query->row()->fullname;
	}


}
