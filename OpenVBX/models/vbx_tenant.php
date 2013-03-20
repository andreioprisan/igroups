<?php

class VBX_Tenant extends Model {

	function __construct()
	{
		parent::__construct();
	}
	
	function getNumbers($tenant_id)
	{
		$query = $this->db->get_where('phone_numbers', array('tenant_id' => $tenant_id, 'status' => 'active'));
		
		$numbers = array();
		foreach ($query->result() as $row)
		{
			$numbers[] = $row->number;
		}
		
		return $numbers;
	}
	

	function getCallDetails($tenant_id, $numbers)
	{
		$glue = implode(",", $numbers);
		$query_raw = "select distinct concat(CallStatus, CallSid, Date), concat(FromCity, ' ', FromState, ' ', FromZip, ' ', FromCountry) as FromGeoIP, CallStatus, CallSid, `Date`, `To`, `From`, Called, Caller, Duration, CallDuration, Direction   from tracker_calls where (`Caller` in (".$glue.")) OR (`To` in (".$glue.")) OR (`From` in (".$glue.")) OR (`Called` in (".$glue."))";
		
		$result = array();
		$query = $this->db->query($query_raw);
		$result = $query->result();
		
		return $result;
		
	}
	
	function getUsage($tenant_id, $numbers)
	{
		$glue = implode(",", $numbers);
		$query_raw = "select distinct concat(CallStatus, CallSid, Date), CallStatus, CallSid, `Date`, `To`, `From`, Called, Caller, Duration  from tracker_calls where (`Caller` in (".$glue.")) OR (`To` in (".$glue.")) OR (`From` in (".$glue.")) OR (`Called` in (".$glue."))";
		
		$result = array();
		$query = $this->db->query($query_raw);

		$datesList = array();

		if ($query->num_rows() > 0)
		{
		   foreach ($query->result() as $row)
		   {
				$dateTime = $row->Date;
				$date = explode(" ", $dateTime);
				$datesList[] = $date[0];
				
				if (in_array($row->To, $numbers) || in_array($row->Called, $numbers))
				{
					if (isset($result['To '.$row->To][$date[0]]))
					{
						$counter = $result['To '.$row->To][$date[0]];
						$result['To '.$row->To][$date[0]] = $counter + 1;
					} else {
						$result['To '.$row->To][$date[0]] = 1;
					}
				}
				
				if (in_array($row->From, $numbers) || in_array($row->Caller, $numbers))
				{
					if (isset($result['From '.$row->From][$date[0]]))
					{
						$counter = $result['From '.$row->From][$date[0]];
						$result['From '.$row->From][$date[0]] = $counter + 1;
					} else {
						$result['From '.$row->From][$date[0]] = 1;
					}
				}
				
		   }
		} else {
			return array();
		}

		// insert 0 stats for those without any stats for days that
		// other numbers have stats for
		foreach ($result as $phonenumber => $numberSet)
		{
			$numberSetUpdate = NULL;
			foreach ($datesList as $dateWithStats)
			{
				if (!isset($numberSet[$dateWithStats]))
				{
					$result[$phonenumber][$dateWithStats] = 0;
				}
			}
		}
		
		// sort results by day
		foreach ($result as $phonenumber => $numberSet)
		{
			ksort($numberSet);
			$result[$phonenumber] = $numberSet;
		}
		
		return $result;
	}
	
	function addNumber($tenant_id, $number)
	{
		$data = array(	'tenant_id' 		=> 		$tenant_id,
						'number' 			=> 		$number,
						'status' 			=> 		'active',
						'addedon' 			=> 		date('Y-m-d H:i:s')
					);
		$this->db->insert('phone_numbers', $data); 
	}

	function updateNumberStatus($tenant_id, $number, $status = "deleted")
	{
		$data = array(	'tenant_id' 		=> 		$tenant_id,
						'number' 			=> 		$number,
						'status' 			=> 		'deleted'
					);
		
		$this->db->update('phone_numbers', $data, "tenant_id = $tenant_id");
	}

	function hasFunds($tenant_id, $amount)
	{
		$balance = $this->getBalance($tenant_id);
		if (floatval($balance) >= floatval($amount))
		{
			return true;
		} else {
			return 0;
		}
	}
	
	function getBalance($tenant_id)
	{
		// get current balance
		$result = $this->db->from('phone_resources')->where('tenant_id', $tenant_id)->get()->result();
		
		if (count($result) != 1)
			return floatval(0);
		else 
			return $result[0]->balance;
	}

	function getNumberTenant($phone_number)
	{
		// get current balance
		$query = $this->db->from('phone_numbers')->where('number', $phone_number);
		$result = $query->get()->result();
		
		if (count($result) != 1)
			return floatval(0);
		else 
			return $result[0]->tenant_id;
	}

	function getMinutesFromResources($tenant_id)
	{
		// get current balance
		$result = $this->db->from('phone_resources')->where('tenant_id', $tenant_id)->get()->result();
		
		if (count($result) != 1)
			return 0;
		else 
			return $result[0]->minutes_available;
	}
	
	function getTFMinutesFromResources($tenant_id)
	{
		// get current balance
		$result = $this->db->from('phone_resources')->where('tenant_id', $tenant_id)->get()->result();
		
		if (count($result) != 1)
			return 0;
		else 
			return $result[0]->tfminutes_available;
	}
	

	function getSMSsFromResources($tenant_id)
	{
		// get current balance
		$result = $this->db->from('phone_resources')->where('tenant_id', $tenant_id)->get()->result();
		
		if (count($result) != 1)
			return 0;
		else 
			return $result[0]->sms_available;
	}

	function removeMinutesFromResources($tenant_id, $amount)
	{
		$balance = $this->getMinutesFromResources($tenant_id);
		$updated = floatval($balance) - floatval($amount);
		$data = array('minutes_available' => $updated);
		$this->db->update('phone_resources', $data, "tenant_id = $tenant_id");
	}

	function removeTFMinutesFromResources($tenant_id, $amount)
	{
		$balance = $this->getTFMinutesFromResources($tenant_id);
		$updated = floatval($balance) - floatval($amount);
		$data = array('tfminutes_available' => $updated);
		$this->db->update('phone_resources', $data, "tenant_id = $tenant_id");
	}
	
	function removeSMSsFromResources($tenant_id, $amount)
	{
		$balance = $this->getSMSsFromResources($tenant_id);
		$updated = floatval($balance) - floatval($amount);
		$data = array('sms_available' => $updated);
		$this->db->update('phone_resources', $data, "tenant_id = $tenant_id");
	}
	
	function addMinutesToResources($tenant_id, $amount)
	{
		$balance = $this->getMinutesFromResources($tenant_id);
		$updated = floatval($balance) + floatval($amount);
		$data = array('minutes_available' => $updated);
		$this->db->update('phone_resources', $data, "tenant_id = $tenant_id");
	}

	function addTFMinutesToResources($tenant_id, $amount)
	{
		$balance = $this->getTFMinutesFromResources($tenant_id);
		$updated = floatval($balance) + floatval($amount);
		$data = array('tfminutes_available' => $updated);
		$this->db->update('phone_resources', $data, "tenant_id = $tenant_id");
	}
	
	function addSMSsToResources($tenant_id, $amount)
	{
		$balance = $this->getSMSsFromResources($tenant_id);
		$updated = floatval($balance) + floatval($amount);
		$data = array('sms_available' => $updated);
		$this->db->update('phone_resources', $data, "tenant_id = $tenant_id");
	}
	
	function updateBalance($tenant_id, $amount)
	{
		$data = array('balance' => $amount);
		$this->db->update('phone_resources', $data, "tenant_id = $tenant_id");
	}
	
	function isUnavailableMinutes($tenant_id)
	{
		if ($this->getMinutesFromResources($tenant_id) > 0)
		{
			return 0;
		} else {
			return true;
		}
	}
	
	function isUnavailableTFMinutes($tenant_id)
	{
		if ($this->getMinutesFromResources($tenant_id) > 0)
		{
			return 0;
		} else {
			return true;
		}
	}
	
	function isUnavailableSMSs($tenant_id)
	{
		if ($this->getSMSsFromResources($tenant_id) > 0)
		{
			return 0;
		} else {
			return true;
		}
	}
	
	function chargeDebitCreditTenant($tenant_id, $chargeType = "debit", $amount, $itemType, $itemReference)
	{
		// save new charge
		$data = array(	'tenant_id' 		=> 		$tenant_id,
						'chargeType' 		=> 		$chargeType,
						'itemType' 			=> 		$itemType,
						'itemReference' 	=> 		$itemReference,
						'amount' 			=> 		$amount,
						'datetime' 			=> 		date('Y-m-d H:i:s')
					);
		$this->db->insert('charges', $data); 
		
		// let's see if we have enough money in here first
		//if ($this->hasFunds($tenant_id, $amount))
		//{
		//	return 0;
		//}
		
		// get current balance
		$balance = $this->getBalance($tenant_id);

		// calculate new balance
		if ($chargeType == "credit")
		{
			$newbalance = floatval($balance) + floatval($amount);
		} else {
			$newbalance = floatval($balance) - floatval($amount);
		}

		// write new balance
		$this->updateBalance($tenant_id, $newbalance);
		
		return true;
	}
	
	function getTwilioAccountSID($user_id)
	{
		// get current balance
		$result = $this->db->from('users')->where('id', $user_id)->get()->result();
		
		if (count($result) != 1)
			return 0;
		else 
			return $result[0]->twilioaccount;
	}
	
	function setTwilioAccountSID($user_id, $sid)
	{
		$data = array('twilioaccount' => $sid);
		$this->db->update('users', $data, "user_id = $user_id");
	}
	
	
}
