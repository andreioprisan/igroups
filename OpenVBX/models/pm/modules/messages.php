<?php

class Messages extends CI_Model {

	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
	}
	
	function get_group_messages($group_id, $user_id)
	{
		$query = $this->db->query('SELECT DATE_FORMAT(datetime, \'%m/%d/%y %h:%i%p\' ) as dateformat, messages.*, concat(users.first_name, " ", users.last_name) as fromMember FROM messages left join users on messages.user_id=users.id WHERE messages.group_id = ? AND (messages.to_user_id = ? OR messages.to_user_id = \'0\' OR messages.to_user_id = \'\') ORDER BY datetime desc', array('group_id' => $group_id, 'user_id' => $user_id));
		return $query->result();
	}
	
	function get_user_messages($user_id)
	{
		$query = $this->db->query('SELECT DATE_FORMAT(datetime, \'%m/%d/%y %h:%i%p\' ) as dateformat, messages.*, concat(users.first_name, " ", users.last_name) as fromMember FROM messages left join users on messages.user_id=users.id WHERE (messages.to_user_id = ? or (messages.to_user_id = ? and messages.group_id = 0) or (messages.group_id in (select groups.id from groups_users left join groups on groups.id = groups_users.group_id where groups_users.user_id = ? order by groups.id))) ORDER BY datetime desc', array('messages.to_user_id' => $user_id, 'to_user_id' => $user_id, 'groups_users.user_id' => $user_id));
		return $query->result();
	}
	
	function get_user_sent_messages($user_id)
	{
		$query = $this->db->query('SELECT DATE_FORMAT(datetime, \'%m/%d/%y %h:%i%p\' ) as dateformat, messages.*, concat(users.first_name, " ", users.last_name) as toMember FROM messages left join users on messages.to_user_id=users.id WHERE messages.user_id = ?  ORDER BY datetime desc', array('user_id' => $user_id));
		return $query->result();
	}
	
	function add($data)
	{
		$this->db->insert('messages', $data); 
	}
	
}
