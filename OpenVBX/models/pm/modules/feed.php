<?php

class Feed extends CI_Model {

	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
	}
	
	function group($group_id)
	{
		$query = $this->db->query('SELECT feed.*, concat(users.first_name, " ", users.last_name, " ", feed.content) as contentAmend, concat(users.first_name, " ", users.last_name) as author FROM feed left join users on feed.user_id=users.id WHERE group_id = ?  ORDER BY datetime desc', array('group_id' => $group_id));
		return $query->result();
	}
	
	function user($user_id)
	{
		$query = $this->db->query('SELECT feed.*, concat(users.first_name, " ", users.last_name, " ", feed.content) as contentAmend, concat(users.first_name, " ", users.last_name) as author FROM feed left join users on feed.user_id=users.id WHERE user_id = ?  ORDER BY datetime desc', array('user_id' => $user_id));
		return $query->result();
	}
	
	function add($data)
	{
		$this->db->insert('feed', $data); 
	}
	
}
