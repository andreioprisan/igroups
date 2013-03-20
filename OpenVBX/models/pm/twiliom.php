<?php

class Twiliom extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}
	
	function call_tracker($data)
	{
		$data['Date'] = date("Y-m-d H:i:s");
		unset($data['ApiVersion']);

		$this->db->insert('twilio_call_inbound', $data); 

		return $this->db->insert_id();
	}
	
	function sms_tracker($data)
	{
		$data['Date'] = date("Y-m-d H:i:s");
		unset($data['ApiVersion']);

		$this->db->insert('twilio_sms_inbound', $data); 

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
