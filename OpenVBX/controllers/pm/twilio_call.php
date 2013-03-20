<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Twilio_call extends CI_Controller
{
	public static $account_sid   = 'ACc223f6e1d1d2488d8efeeb319286f22c';
	public static $auth_token    = '9ed18b079156d238b7b1517e34a4e2a9';
	public static $api_version   = '2010-04-01';
	public static $from          = '+16175000771';
	public static $from_b        = '4158675309';
	public static $call_tml_url  			= 'http://athena.igrou.ps/twilio_tracker/call_tml';
	public static $call_statusupdate_url  	= 'http://athena.igrou.ps/twilio_tracker/call';
	public static $sms_tml_url   			= 'http://athena.igrou.ps/twilio_tracker/sms_tml';
	
    function __construct()
    {
        parent::__construct();
		$this->load->library('twilio');
		$this->load->model('twiliom', 'twiliotracker');

    }

	function call()
	{
		$a = '<?xml version="1.0" encoding="UTF-8" ?>
		<Response>
		     <Say voice="woman" language="en-gb" loop="2">Hello</Say>
		</Response>';
		
		header('Content-type: text/xml');
		echo $a;
	} 

    function index()
    {
	 	try {
			$data = array(	'To'						=>	'+12123005446',
							'From'						=>	self::$from, 
							'Url'						=>	self::$call_tml_url,
							'StatusCallback'			=>	self::$call_statusupdate_url,
							'StatusCallbackMethod'		=>	'POST'
							
							);
			
			$call = $this->twilio->request("/".self::$api_version."/Accounts/".self::$account_sid."/Calls", "POST", $data);

		} catch (Exception $e) {
			echo 'Error: ' . $e->getMessage();
		}

		$xml = simplexml_load_string($call->ResponseText);
		$json = json_encode($xml);
		$twilio_resp_array = json_decode($json,TRUE);
		$twilio_resp_array = $twilio_resp_array['Call'];

		$trackingData = array(
						'CallSid'			=>		$twilio_resp_array['Sid'],
						'AccountSid'		=>		$twilio_resp_array['AccountSid'],
						'To'				=>		$twilio_resp_array['To'],
						'Called'			=>		$twilio_resp_array['To'],
						'From'				=>		$twilio_resp_array['From'],
						'Caller'			=>		$twilio_resp_array['From'],
						'CallStatus'		=>		$twilio_resp_array['Status'],
						'Direction'			=>		$twilio_resp_array['Direction'],
						'ApiVersion'		=>		$twilio_resp_array['ApiVersion']
						);
		
		$this->twiliotracker->call_tracker($trackingData);
		
		return $trackingData['CallStatus'];	
	}
}