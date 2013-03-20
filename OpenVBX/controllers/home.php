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

class HomeException extends Exception {}

class Home extends User_Controller {

	const PAGE_SIZE = 20;

	function __construct()
	{
		parent::__construct();
		$this->section = 'dashboard';

	}

	function index()
	{
//		die("inhomepage");
//		$_COOKIE['last_known_url'] = "/home/index";
//		var_dump($_COOKIE);
//		echo "asdf";
		//die();
/*
		if($this->session->userdata('loggedin'))
		{
			if(VBX_User::signature($this->user_id) == $this->session->userdata('signature'))
			{
				$ci=& get_instance();
				//if (!$ci->uri->rsegments[1]);
				//echo "loggedin";
//				return $this->redirect('/dashboard/index');
			}
		}
		*/
		
		$this->load->view("home/index");
	}

	function about()
	{
		$this->load->view("home/about");
	}

	function tos()
	{
		$this->load->view("home/tos");
	}

	function privacy()
	{
		$this->load->view("home/privacy");
	}

}
