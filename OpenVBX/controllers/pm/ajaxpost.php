<?php

class Ajaxpost extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->model('modules/tasksm', 'tasksm');
	}


	function tasks_delete()
	{
		$id = $_GET['id'];
		 
		$result = "false";
		$result = $this->tasksm->delete($id);
		echo json_encode(array('result' => "$result"));

	}

	function tasks_update()
	{
		if ($_GET['user_id'] == $_GET['to_user_id']) {
			$toself = "1";
		} else {
			$toself = "0";
		}
		
		if ($_GET['private'] == "yes") {
			$private = "1";
		} else if ($_GET['private'] == "no" || $_GET['private'] == ""){
			$private = "0";
		}
		
		$date = $_GET['due'];
		if (trim($date) == "" || $date == "now" || $date == "asap") { 
			$date = date("Y-m-d H:m:s"); 
		}
		
		$payload = array(	'due' 			=> date("Y-m-d H:m:s", strtotime($date)),
							'type'		 	=> "task",
							'priority' 		=> $_GET['priority'],
							'private' 		=> $private,
							'content' 		=> str_replace('\n','<br>', $_GET['what']),
							'group_id' 		=> $_GET['group_id'],
							'user_id' 		=> $_GET['user_id'],
							'to_user_id' 	=> $_GET['to_user_id'],
							'toself' 		=> $toself,
							'datetime'		=> date("Y-m-d H:m:s")
						);
		
		$id = $_GET['id'];
		
		$result = "false";
		$result = $this->tasksm->update($payload, $id);
		echo json_encode(array('result' => "$result"));
	}
	
	function tasks_add()
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
		
		if ($_GET['private'] == "yes") {
			$private = "1";
		} else if ($_GET['private'] == "no" || $_GET['private'] == ""){
			$private = "0";
		}
		
		$payload = array(	'due' 			=> date("Y-m-d H:m:s", strtotime($date)),
							'type'		 	=> "task",
							'priority' 		=> $_GET['priority'],
							'private' 		=> $private,
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
