<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Twilio_sms extends CI_Controller
{
	public static $account_sid   = 'ACc223f6e1d1d2488d8efeeb319286f22c';
	public static $auth_token    = '9ed18b079156d238b7b1517e34a4e2a9';
	public static $api_version   = '2010-04-01';
	public static $from          = '+16175000771';
	public static $from_b        = '4158675309';
	public static $sms_tml_url  			= 'http://athena.igrou.ps/twilio_tracker/sms_tml';
	public static $sms_statusupdate_url  	= 'http://athena.igrou.ps/twilio_tracker/sms';
	
    function __construct()
    {
        parent::__construct();
		$this->load->library('twilio');
		$this->load->model('twiliom', 'twiliotracker');

    }

    function index()
    {
	 	try {
			$data = array(	'To'						=>	'+12123005446',
							'From'						=>	self::$from, 
							'Body'						=>	'Test',
							'StatusCallback'			=>	self::$sms_statusupdate_url,
							'StatusCallbackMethod'		=>	'POST'
							);
			
			$sms = $this->twilio->request("/".self::$api_version."/Accounts/".self::$account_sid."/SMS/Messages", "POST", $data);

		} catch (Exception $e) {
			echo 'Error: ' . $e->getMessage();
		}
		
		$xml = simplexml_load_string($sms->ResponseText);
		$json = json_encode($xml);
		$twilio_resp_array = json_decode($json,TRUE);
		$twilio_resp_array = $twilio_resp_array['SMSMessage'];

		$trackingData = array(
						'SmsSid'			=>		$twilio_resp_array['Sid'],
						'AccountSid'		=>		$twilio_resp_array['AccountSid'],
						'To'				=>		$twilio_resp_array['To'],
						'From'				=>		$twilio_resp_array['From'],
						'SmsStatus'			=>		$twilio_resp_array['Status'],
						'Direction'			=>		$twilio_resp_array['Direction'],
						'ApiVersion'		=>		$twilio_resp_array['ApiVersion']
						);
						
		$this->twiliotracker->sms_tracker($trackingData);
		
		return $trackingData['SmsStatus'];

	}
}