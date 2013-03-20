<?php

class Charge extends CI_Controller {
	
	function __construct()
	{
		parent::__construct();
		
		$this->load->model('billing');

		require_once('./application/libraries/stripe/Stripe.php');
		$this->load->library('stripe/Stripe', 'stripe');
		// dev
		$this->stripe->setApiKey('5GobgwO2KWLgW1Ynhehlks80n8o5etJb');
	}
	
	function index()
	{
		$this->load->view('charge/index');
		//var_dump($this->stripe);
		
		/*
		// dev
		$this->stripe->setApiKey('5GobgwO2KWLgW1Ynhehlks80n8o5etJb');
		// live
		$this->stripe->setApiKey('92STA8OAoZ8eyXNP1bVh1RJEOsz8W5gZ');

		$myCard = array(	'number' => '4111111111111111', 
							'exp_month' => 6, 
							'exp_year' => 2014,
							'name' => 'Andrei Oprisan',
							'address_line1' => '86 Saint Botolph St, Apt 10',
							'address_line2' => '02116',
							'address_state' => 'MA',
							'address_country' => 'US'
							);
		$myCharge = array(	'card' => $myCard, 
							'amount' => 2000, 
							'currency' => 'usd',
							'description' => 'charge for igroups'
							);
							
		try
		{
			$charge = Stripe_Charge::create($myCharge);
		} catch (Exception $e) {
			throw new Exception('Problem with Stripe Charge: ', 1, $e);
		}

		//var_dump($charge);
		$result = $charge->__toArrayNested();
		var_dump($result);
		if (isset($result['error'])) {
			echo "<h1>charge failed</h1>";
		} else if (isset($result['paid']) == true) {
			echo "<h1>charge successful</h1>";
		}
		echo "<hr>";
		//$this->getAllCharges();
		*/

	}
	
	function processtoken() {
		if (!isset($_GET['id']))
			return;
		else {
			$token = $_GET['id'];
		}
		
		$myCharge = array(	'card' => $token, 
							'amount' => 100, 
							'currency' => 'usd',
							'description' => 'charge for igroups'
							);
							
		try
		{
			$charge = Stripe_Charge::create($myCharge);
		} catch (Exception $e) {
			throw new Exception('Problem with Stripe Charge: ', 1, $e);
		}

		//var_dump($charge);
		$result = $charge->__toArrayNested();
		var_dump($result);
		if (isset($result['error'])) {
			echo "<h1>charge failed</h1>";
		} else if (isset($result['paid']) == true) {
			echo "<h1>charge successful</h1>";
		}
		echo "<hr>";
		
		echo $token;
	}
	
	function savecustfromtoken() {
		if (!isset($_GET['id']))
			echo json_encode(array('result' => "0", 'error' => 'missing id'));
		else {
			$token = $_GET['id'];
		}

		if (!isset($_GET['amount']))
			echo json_encode(array('result' => "0", 'error' => 'missing amount'));
		else {
			$amount = $_GET['amount'];
		}
		
		if (!isset($_GET['name']))
			$custname = "new customer";
		else {
			$custname = $_GET['name'];
		}
		
		$customerID = $this->createCustomerToken($token, $custname);
		//echo $customerID;
		if ($customerID == "0") {
			echo json_encode(array('result' => "0", 'error' => 'customer token creation failed'));
		}
		
		$chargeResult = $this->chargeCustomerToken($customerID, $amount);
		if ($chargeResult == 1)
		{
			echo json_encode(array('result' => "1", 'error' => 'charge successful'));
		} else {
			echo json_encode(array('result' => "0", 'error' => 'charge failed'));
		}
	}
	
	function processCustTokenAmount() {
		if (!isset($_GET['customerID']))
			echo json_encode(array('result' => "0", 'error' => 'missing customerID'));
		else {
			$customerID = $_GET['customerID'];
		}

		if (!isset($_GET['amount']))
			echo json_encode(array('result' => "0", 'error' => 'missing amount'));
		else {
			$amount = $_GET['amount'];
		}
		
		$chargeResult = $this->chargeCustomerToken($customerID, $amount);
		if ($chargeResult == 1)
		{
			echo json_encode(array('result' => "1"));
		} else {
			echo json_encode(array('result' => "0"));
		}
	}

	
	function createCustomerToken($token, $custname) {
		$id = 0;
		
		$myCustomer = array(	'card' => $token, 
								'description' => $custname
							);
		
		$customer = Stripe_Customer::create($myCustomer);

		$customer_result = $customer->__toArrayNested();

		if (isset($customer_result['error'])) {
			//echo "<h1>customer creation failed</h1>";
		} else if (isset($customer_result['id'])) {
			//echo "<h1>customer creation successful, id ".$customer_result['id']."</h1>";
			$id = $customer_result['id'];
			
			$address_line1_check = $customer_result['active_card']['address_line1_check'] == "pass" ? 1 : 0;
			$address_zip_check = $customer_result['active_card']['address_zip_check'] == "pass" ? 1 : 0;
			$cvc_check = $customer_result['active_card']['cvc_check'] == "pass" ? 1 : 0;
			
			$cardDetails = array(	'address_line1'			=>	$customer_result['active_card']['address_line1'],
									'address_zip'			=>	$customer_result['active_card']['address_zip'],
									'country'				=>	$customer_result['active_card']['country'],
									'address_line1_check'	=>	$address_line1_check,
									'address_zip_check'		=>	$address_zip_check,
									'cvc_check'				=>	$cvc_check,
									'exp_month'				=>	$customer_result['active_card']['exp_month'],
									'exp_year'				=>	$customer_result['active_card']['exp_year'],
									'last4'					=>	$customer_result['active_card']['last4'],
									'type'					=>	$customer_result['active_card']['type'],
									'created'				=>	$customer_result['created'],
									'stripeCustomerID'		=>	$customer_result['id']
								);
			
			$cardID = $this->billing->addCard($cardDetails);
			
			$customerDetails = array(	'stripeCustomerID'			=>	$customer_result['id'],
										'cardID'					=>	$cardID,
										'livemode'					=>	$customer_result['livemode'],
										'name'						=>	$custname,
										'created'					=>	$customer_result['created'],
										'userID'					=>	''
								);
			
			$customerID = $this->billing->addCustomer($customerDetails);
		}

		//var_dump($customer_result);
		//echo "<hr>";
		
		return $id;
	}
	
	
	function chargeCustomerToken($token, $amount) {
		$success = 0;
		
		$myCharge = array(		'amount'	=> $amount,
								'currency' => 'usd', 
								'customer' => $token
							);
		
		$charge = Stripe_Charge::create($myCharge);

		$charge_result = $charge->__toArrayNested();
		
		if (isset($charge_result['error'])) {
			//echo "<h1>charge failed</h1>";
		} else if (isset($charge_result['paid']) && $charge_result['paid'] == true) {
			//echo "<h1>charge successful</h1>";
			
			$chargeDetails = array(		'stripeCustomerID'			=>	$token,
										'stripeChargeID'			=>	$charge_result['id'],
										'currency'					=>	$charge_result['currency'],
										'amount'					=>	$charge_result['amount'],
										'fee'						=>	$charge_result['fee'],
										'live'						=>	$charge_result['livemode'],
										'paid'						=>	$charge_result['paid'],
										'refunded'					=>	$charge_result['refunded'],
										'created'					=>	$charge_result['created']
								);
			
			$chargeID = $this->billing->addCharge($chargeDetails);
			
			
			$success = 1;
		}
		
		//var_dump($charge_result);
		
		return $success;
	}
	
	function getAllCharges() {
		$a = Stripe_Charge::all();
		echo($a['count']);
		foreach ($a['data'] as $b)
		{
			echo "<hr>";
			var_dump($b->__toArrayNested());
		}
	}
	
	function getCustomerCards() {
		if (!isset($_GET['id']))
			return;
		else {
			$user_id = $_GET['id'];
		}
		
		$cards = $this->billing->getCards($user_id);
		
		$cardsArray = array();
		foreach($cards as $card) {
			$cardID = $card->cardID."|".$card->stripeCustomerID;
			$cardText = $card->type."|".$card->last4;
			
			$cardsArray[] = array(	'id' 		=> $card->cardID, 
									'unique' 	=> $card->stripeCustomerID, 
									'type' 		=> $card->type, 
									'last4'		=> $card->last4);
									
		}
		
		echo json_encode($cardsArray);
	}
}
