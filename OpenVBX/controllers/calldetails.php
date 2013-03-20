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

 **/

class CalldetailsException extends Exception {}

class Calldetails extends User_Controller {

	const PAGE_SIZE = 20;

	function __construct()
	{
		parent::__construct();
		$this->section = 'calldetails';
		$this->template->write('title', 'Call Details');
		
		$this->load->helper('date');
		
		$this->load->model('vbx_user');
		$this->load->model('phoneresources');
		$this->load->model('vbx_incoming_numbers');
		$this->load->model('vbx_tenant');
		
	}

	function index()
	{
		return $this->inbox();
	}

	private function inbox()
	{
		$ci=& get_instance();
		
		$userdata = VBX_User::get($this->session->userdata('user_id'));
		$tenant_id = $userdata->values['tenant_id'];
		
		// get phone usage statistics
		$resources = $this->phoneresources->get($tenant_id);
		$data['resources'] = $resources;
		$data['path'] = $ci->uri->uri_string();

		$numbers = $this->vbx_incoming_numbers->get_numbers();
		$numbers_tenant = $this->vbx_tenant->getNumbers($tenant_id);
		
		$callDetails = $this->vbx_tenant->getCallDetails($tenant_id, $numbers_tenant);
		
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
		
		$data['callDetails'] = $callDetails;
		
		$this->respond('Call Details', 'calldetails/index', $data);
	}

}