<?php

class TasksM extends CI_Model {

	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
	}
	
	function get_group_tasks($group_id, $user_id)
	{
		$query = $this->db->query('SELECT DATE_FORMAT(datetime, \'%m/%d/%y\' ) as dateformat, DATE_FORMAT(due, \'%m/%d/%y\' ) as duedate, tasks.*, concat(users.first_name, " ", users.last_name) as fromMember FROM tasks left join users on tasks.user_id=users.id WHERE tasks.group_id = ? AND (tasks.to_user_id = ? OR tasks.to_user_id = \'0\' OR tasks.to_user_id = \'\') ORDER BY datetime desc', array('group_id' => $group_id, 'user_id' => $user_id));
		return $query->result();
	}
	
	function get_user_tasks($user_id)
	{
		$query = $this->db->query('SELECT DATE_FORMAT(datetime, \'%m/%d/%y\' ) as dateformat, DATE_FORMAT(due, \'%m/%d/%y \' ) as duedate, tasks.*, concat(users.first_name, " ", users.last_name) as fromMember FROM tasks left join users on tasks.user_id=users.id WHERE tasks.to_user_id = ?  ORDER BY datetime desc', array('user_id' => $user_id));
		return $query->result();
	}
	
	function get_tasks_userhasaccessto($user_id)
	{
//		$query = $this->db->query('SELECT distinct DATE_FORMAT(datetime, \'%m/%d/%y %h:%i%p\' ) as dateformat, DATE_FORMAT(due, \'%m/%d/%y %h:%i%p\' ) as duedate, tasks.*, concat(users.first_name, " ", users.last_name) as fromMember FROM tasks left join users on tasks.user_id=users.id WHERE (tasks.to_user_id = ? or tasks.group_id in (select groups.id from groups_users left join groups on groups.id = groups_users.group_id where groups_users.user_id = ? order by groups.id) or tasks.group_id = 0)  ORDER BY datetime desc', array('to_user_id' => $user_id,'user_id' => $user_id));

		$query = $this->db->query('SELECT distinct DATE_FORMAT(datetime, \'%m/%d/%y\' ) as dateformat, DATE_FORMAT(due, \'%m/%d/%y\' ) as duedate, tasks.*, concat(users.first_name, " ", users.last_name) as fromMember FROM tasks left join users on tasks.user_id=users.id WHERE (tasks.to_user_id = ? or (tasks.to_user_id = ? and tasks.group_id = 0) or (tasks.group_id in (select groups.id from groups_users left join groups on groups.id = groups_users.group_id where groups_users.user_id = ? order by groups.id))) ORDER BY datetime desc', array('to_user_id' => $user_id,'user_id' => $user_id,'groups_users.user_id' => $user_id));
		return $query->result();
	}
	
	function get_user_sent_tasks($user_id)
	{
//		$query = $this->db->query('SELECT DATE_FORMAT(datetime, \'%m/%d/%y %h:%i%p\' ) as dateformat, DATE_FORMAT(due, \'%m/%d/%y %h:%i%p\' ) as duedate, tasks.*, concat(users.first_name, " ", users.last_name) as toMember FROM tasks left join users on tasks.to_user_id=users.id WHERE tasks.user_id = ?  ORDER BY datetime desc', array('user_id' => $user_id));
		$query = $this->db->query('SELECT DATE_FORMAT(datetime, \'%m/%d/%y\' ) as dateformat, DATE_FORMAT(due, \'%m/%d/%y %h:%i%p\' ) as duedate, tasks.*, concat(users.first_name, " ", users.last_name) as toMember FROM tasks left join users on tasks.to_user_id=users.id WHERE tasks.user_id = ?  ORDER BY datetime desc', array('user_id' => $user_id));
		return $query->result();
	}
	
	function update($data, $id)
	{
		$this->db->where('id', $id);
		$query = $this->db->update('tasks', $data);
		
		return $query;		
	}
	
	function add($data)
	{
		$query = $this->db->insert('tasks', $data); 
		return $query;
	}
	
	function delete($id)
	{
		$query = $this->db->delete('tasks', array('id' => $id)); 
		return $query;
	}
	
}
