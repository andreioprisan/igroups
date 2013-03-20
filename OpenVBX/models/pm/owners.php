<?php

class Owners extends CI_Model {

	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
	}
	
	function add($data)
	{
		$this->db->insert('owners', $data); 
		return $this->db->insert_id();
	}
	
	function get_by_id($id)
	{
		$query = $this->db->get_where('owners', array('id' => $id));
		return $query->result();
	}

}
