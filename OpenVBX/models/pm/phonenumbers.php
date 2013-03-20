<?php

class Phonenumbers extends CI_Model {

	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
	}
	
	function get_by_id($id)
	{
		$query = $this->db->get_where('phonenumbers', array('id' => $id));
		return $query->result();
	}

	function get_for_user_id($id)
	{
		$query = $this->db->query('SELECT * FROM phonenumbers WHERE user_id = ?', array('user_id' => $id));
		return $query->result();
	}
	
	function update($data, $id)
	{
		$this->db->where('id', $id);
		$query = $this->db->update('phonenumbers', $data);
		
		return $query;		
	}
	
	function add($data)
	{
		$query = $this->db->insert('phonenumbers', $data); 
		return $query;
	}
	
	function delete($id)
	{
		$query = $this->db->delete('phonenumbers', array('id' => $id)); 
		return $query;
	}
	
}
