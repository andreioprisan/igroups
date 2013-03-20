<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Twilio_tracker extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
		$this->load->model('twiliom', 'twiliotracker');
    }

	function sms_handler()
	{
		$request = $this->getRequestData($_GET, $_POST);
		
		if (count($request) > 0)
		{
			$this->track2db($request);
			$this->track2email($request);
		}
		
		$this->twml_sms("default", NULL, $request);
		
	}

	function call_handler()
	{
		$request = $this->getRequestData($_GET, $_POST);
		
		if (count($request) > 0)
		{
			$this->track2db($request);
			$this->track2email($request);
		}
		
		$this->twml_call("default", NULL, $request);
		
	}

	function twml_call($type, $params = NULL, $request)
	{
		header("Content-type: text/xml");

		if ($type == "default")
		{
			echo '<?xml version="1.0" encoding="UTF-8" ?>
			<Response>
			<Say voice="woman" language="en-gb" loop="1">Hello, welcome to eye Groups. Please visit us at www.i g r o u dot p s</Say>
			</Response>';
			
			return;

			/*
			<Dial action="https://athena.igrou.ps/twilio_tracker/call">843-327-2696</Dial>
			<Say>We are now connecting you to a conference call. Please wait.</Say>
			*/
		}
		
		
	}

	function twml_sms($type, $params = NULL, $request)
	{
		header("Content-type: text/xml");

		if ($type == "default")
		{
			echo "<Response>
				<Sms statusCallback='https://athena.igrou.ps/twilio_tracker/sms'>Got ".$request['Body']." from ".$request['From']."</Sms>
			</Response>";
			
			return;
		}
		
		
	}
	
	function sms() 
	{
		$request = $this->getRequestData($_GET, $_POST);
		
		if (count($request) > 0)
		{
			$this->track2db($request);
			$this->track2email($request);
		}
	} 
	
	function call() 
	{
		$request = $this->getRequestData($_GET, $_POST);
		
		if (count($request) > 0)
		{
			$this->track2db($request);
			$this->track2email($request);
		}
	}

	// saves call or sms request to db
	function track2db($data)
	{
		$this->twiliotracker->save($data);
	}
	
	// saves call or sms request to email
	function track2email($data)
	{
		if (isset($data['CallSid']))
		{
			$this->sendEmailNotification("phone call", $data);
		} else {
			$this->sendEmailNotification("sms", $data);
		}
	}
	
	// returns POSTEed or GETed input
	function getRequestData($GET, $POST)
	{
		if (isset($GET['From'])) 
		{
			return $GET;
		} else {
			return $POST;
		}

		return array();
	}
	
	// send raw logger email
	function sendEmailNotification($subject, $data)
	{
		$to      = 'voiplogger.raw@igrou.ps';
		$headers = 'From: voiplogger.raw@igrou.ps' . "\r\n" .
		    'Reply-To: voiplogger.raw@igrou.ps' . "\r\n" .
		    'X-Mailer: iGroups Athena 1.0';
		
		mail($to, $subject, print_r($data, true), $headers);
	}

}
