<?php

class Charge extends User_Controller {
	function __construct()
	{
		parent::__construct();
		
		$this->load->model('billing');

		require_once('./OpenVBX/libraries/stripe/Stripe.php');
		$this->load->library('stripe/Stripe', 'stripe');
		// dev
		$this->stripe->setApiKey('key');
		
		$this->load->model('vbx_tenant');
		
	}
	
	function index()
	{
		$this->load->view('charge/index');


	}
	
	function chargeToken() {		
		$this->tenant_id = $_POST['tenant_id'];
		
		if ($_POST['purchase_cardtype'] == "new")
		{
			$token = $_POST['stripeToken'];
			$planid = $_POST['purchase_planid'];
			$amount = $_POST['purchase_total_amount'];
			$tenant_id = $_POST['tenant_id'];
			
			$customerid = $this->createCustomerToken($token, $tenant_id);
			if ($customerid == "0") {
				echo json_encode(array('result' => "0", 'error' => 'customer token creation failed'));
			}
			
		} else if ($_POST['purchase_cardtype'] == "existing")
		{
			$customerid = $_POST['purchase_cardid'];
			$planid = $_POST['purchase_planid'];
			$amount = $_POST['purchase_total_amount'];
			$tenant_id = $_POST['tenant_id'];
		}
		
		$chargeResult = $this->chargeCustomerToken($customerid, $amount);
		if ($chargeResult == 1)
		{
			if ($planid == "99")
			{
				$this->vbx_tenant->chargeDebitCreditTenant($tenant_id, "credit", floatval(floatval($amount)/floatval(100)), "creditcard", $customerid);
			} else {
				if ($planid == "1")
				{
					$this->vbx_tenant->addMinutesToResources($tenant_id, "250");
					$this->vbx_tenant->addTFMinutesToResources($tenant_id, "");
					$this->vbx_tenant->addSMSsToResources($tenant_id, "100");
				} else 	if ($planid == "2")
				{
					$this->vbx_tenant->addMinutesToResources($tenant_id, "500");
					$this->vbx_tenant->addTFMinutesToResources($tenant_id, "500");
					$this->vbx_tenant->addSMSsToResources($tenant_id, "200");
					$this->vbx_tenant->chargeDebitCreditTenant($tenant_id, "credit", floatval(2.00), "creditcard", $customerid);
				} else	if ($planid == "3")
				{
					$this->vbx_tenant->addMinutesToResources($tenant_id, "1000");
					$this->vbx_tenant->addTFMinutesToResources($tenant_id, "1000");
					$this->vbx_tenant->addSMSsToResources($tenant_id, "400");
					$this->vbx_tenant->chargeDebitCreditTenant($tenant_id, "credit", floatval(4.00), "creditcard", $customerid);
				} else	if ($planid == "4")
				{
					$this->vbx_tenant->addMinutesToResources($tenant_id, "2000");
					$this->vbx_tenant->addTFMinutesToResources($tenant_id, "2000");
					$this->vbx_tenant->addSMSsToResources($tenant_id, "800");
					$this->vbx_tenant->chargeDebitCreditTenant($tenant_id, "credit", floatval(6.00), "creditcard", $customerid);
				}
			}	
			
			echo json_encode(array('result' => "1", 'error' => 'charge successful', 'minutes' => $this->vbx_tenant->getMinutesFromResources($tenant_id), 'tfminutes' => $this->vbx_tenant->getTFMinutesFromResources($tenant_id), 'sms' => $this->vbx_tenant->getSMSsFromResources($tenant_id), 'balance' => $this->vbx_tenant->getBalance($tenant_id) ));
		} else {
			echo json_encode(array('result' => "0", 'error' => 'charge failed', 'minutes' => $this->vbx_tenant->getMinutesFromResources($tenant_id), 'tfminutes' => $this->vbx_tenant->getTFMinutesFromResources($tenant_id), 'sms' => $this->vbx_tenant->getSMSsFromResources($tenant_id), 'balance' => $this->vbx_tenant->getBalance($tenant_id)));
		}
		
		
	}
	
	function createCustomerToken($token, $tenant_id) {
		$id = 0;
		
		$myCustomer = array(	'card' => $token );
		
		$customer = Stripe_Customer::create($myCustomer);

		$customer_result = $customer->__toArrayNested();

		if (isset($customer_result['error'])) {
			//echo "<h1>customer creation failed</h1>";
		} else if (isset($customer_result['id'])) {
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
										'created'					=>	$customer_result['created'],
										'tenant_id'					=>	$tenant_id
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
										'net'						=>	floatval(floatval($charge_result['amount']) - floatval($charge_result['fee'])),
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
		if (!isset($_POST['id']))
			return;
		else {
			$user_id = $_POST['id'];
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
