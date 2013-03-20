<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * "The contents of this file are subject to the Mozilla Public License
 *  Version 1.1 (the "License"); you may not use this file except in
 *  compliance with the License. You may obtain a copy of the License at
 *  http://www.mozilla.org/MPL/
 
 *  Software distributed under the License is distributed on an "AS IS"
 *  basis, WITHOUT WARRANTY OF ANY KIND, either express or implied. See the
 *  License for the specific language governing rights and limitations
 *  under the License.

 *  The Original Code is OpenVBX, released June 15, 2010.

 *  The Initial Developer of the Original Code is Twilio Inc.
 *  Portions created by Twilio Inc. are Copyright (C) 2010.
 *  All Rights Reserved.

 * Contributor(s):
 **/

class DashboardException extends Exception {}

class Dashboard extends User_Controller {

	const PAGE_SIZE = 20;

	function __construct()
	{
		parent::__construct();
		$this->section = 'dashboard';
		$this->template->write('title', 'Dashboard');
		
		$this->load->helper('date');
		
		$this->load->model('vbx_user');
		$this->load->model('phoneresources');
		$this->load->model('vbx_incoming_numbers');
		$this->load->model('vbx_tenant');
		$this->load->model('billing');
	}

	function index()
	{
		return $this->inbox();
	}

	private function inbox()
	{
		$ci=& get_instance();
		
		$user_id = $this->session->userdata('user_id');
		$twiliosid = $this->session->userdata('twilioaccount');
		$data['twiliosid'] = strlen($twiliosid) > 1 ? $twiliosid : false;
		$userdata = VBX_User::get($user_id);
		$tenant_id = $userdata->values['tenant_id'];
		$data['tenant_id'] = $tenant_id;
		
		// get phone usage statistics
		$resources = $this->phoneresources->get($tenant_id);
		$data['resources'] = $resources;
		$data['path'] = $ci->uri->uri_string();

		$numbers = $this->vbx_incoming_numbers->get_numbers();
		$numbers_tenant = $this->vbx_tenant->getNumbers($tenant_id);
		
		//$this->vbx_tenant->getBalance($tenant_id);
		
		/*
		$amount = "2.00";
		$itemType = "localnumber";
		$itemReference = "a37fhwivueah3792hrwefiuakhsduvkajshdfkjasdhfjkhsdfj";
		$this->vbx_tenant->chargeDebitCreditTenant($tenant_id, $chargeType = "debit", $amount, $itemType, $itemReference);
		*/
		
		$pnumbers = array();
		foreach ($numbers as $number)
		{
			foreach ($numbers_tenant as $numbert)
			{
				if ($numbert == $number->phone_number)
				{
					$pnumbers[] = $number->phone_number;
				}
			}
		}
		
		$data['pnumbers'] = $pnumbers;
		
		$callsdata = $this->vbx_tenant->getUsage($tenant_id, $pnumbers);
		$data['callsdata'] = $callsdata;

		$cards = $this->billing->getCards($tenant_id);
		$data['cards'] = $cards;
		
		$this->respond('Dashboard', 'dashboard/index', $data);

//		echo $this->vbx_tenant->isUnavailableMinutes($tenant_id);
		
	}

}