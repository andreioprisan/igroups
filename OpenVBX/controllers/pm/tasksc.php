<?php

class TasksC extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->model('modules/tasksm', 'tasksm');
		$this->load->model('modules/users', 'usersm');
		
	}
	
	function jsonupdate()
	{
		error_log(serialize($_GET));
		
		$payload = array(	'due' 			=> date("Y-m-d H:m:s", strtotime($_GET['due'])),
							'type'		 	=> $_GET['eventtype'],
							'priority' 		=> $_GET['priority'],
							'private' 		=> $_GET['private'],
							'content' 		=> str_replace('\n','<br>', $_GET['what'])
							//'datetime'	=> date("Y-m-d H:m:s")
						);
		
		$id = $_GET['id'];
		
		$result = "false";
		$result = $this->tasksm->update($payload, $id);
		echo json_encode(array('result' => "$result"));
	}
	
	function jsoninsert()
	{
		$date = $_GET['due'];
		
		
		if ($_GET['user_id'] == $_GET['to_user_id']) {
			$toself = "1";
		} else {
			$toself = "0";
		}

		$date = $_GET['due'];
		if (trim($date) == "" || $date == "now" || $date == "asap") { 
			$date = date("Y-m-d H:m:s"); 
		}
		
		$payload = array(	'due' 			=> date("Y-m-d H:m:s", strtotime($date)),
							'type'		 	=> "task",
							'priority' 		=> $_GET['priority'],
							'private' 		=> $_GET['private'],
							'group_id' 		=> $_GET['group_id'],
							'user_id' 		=> $_GET['user_id'],
							'to_user_id' 	=> $_GET['to_user_id'],
							'toself' 		=> $toself,
							'content' 		=> str_replace('\n','<br>', $_GET['what']),
							'datetime'		=> date("Y-m-d H:m:s")
						);
		
		
		$result = "false";
		$result = $this->tasksm->add($payload);
		echo json_encode(array('result' => "$result"));
	}
}
