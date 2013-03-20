<?php

class VBX_Tracker extends Model {

	function __construct()
	{
		parent::__construct();
	}
	
	function call_tracker($data)
	{
		$data['Date'] = date("Y-m-d H:i:s");
		unset($data['ApiVersion']);

		$this->db->insert('tracker_calls', $data); 

		return $this->db->insert_id();
	}
	
	function sms_tracker($data)
	{
		$data['Date'] = date("Y-m-d H:i:s");
		unset($data['ApiVersion']);

		$this->db->insert('tracker_sms', $data); 

		return $this->db->insert_id();
	}
	
	function save($data)
	{
		if (isset($data['SmsSid']))
		{
			return $this->sms_tracker($data);
		} else {
			return $this->call_tracker($data);
		}
	}
	
	
}
