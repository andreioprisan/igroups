<?php

class Phone extends CI_Controller {
	var $loginUrl;
	var $logoutUrl;
	
	var $fullname;
	var $email;
	var $fbuid;
	
	var $owner_id = "1";
	var $group_id = "0";
	var $user_id = "1";

	var $appId = '242774152447632';
	var $secret = 'df380003366d6771cb3f57b6913de542';
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('usergroups', 'usergroups_model');
		$this->load->model('modules/feed', 'feed_model');
		$this->load->model('modules/tasksm', 'tasks_model');
		$this->load->model('users', 'usersm');
		$this->load->model('phonenumbers', 'phonenumbersm');
		$this->load->model('modules/messages', 'messages_model');
		
		
		$this->load->model('igroups_group');
		$this->load->model('igroups_user');
		
		$this->load->library('facebook', array(
		  'appId'  => $this->appId,
		  'secret' => $this->secret,
		  //'cookie' => 'true'
		));
	
		$this->setupLoginLogoutLinks();
		$this->setUserDataFromFB();
	}
	
	function setUserDataFromFB()
	{
		$this->fbuid = $this->facebook->getUser();
		if (!$this->fbuid || $this->fbuid == NULL || $this->fbuid == 0)
		{
			redirect('https://'.$_SERVER['HTTP_HOST'].'/login/');
		}
		
		$userdata = $this->facebook->api("/me");
		if (!$userdata || $userdata == NULL || $userdata == 0)
		{
			redirect('https://'.$_SERVER['HTTP_HOST'].'/login/');
		}

		$this->email = $userdata['email'];
		$this->fullname = $userdata['name'];
	}
	
	function setupLoginLogoutLinks()
	{
		$loginUrl	= $this->facebook->getLoginUrl(
		            array(
		                'scope'         => 'email,offline_access,publish_stream,user_about_me',
		                'redirect_uri'  => "https://".$_SERVER['HTTP_HOST']."/facebook_auth/login"
		            )
		    	);

		$logoutUrl	= $this->facebook->getLogoutUrl(
					array(
						'next'	=>	'https://'.$_SERVER['HTTP_HOST'].'/facebook_auth/logout',
						'session_key'	=>	session_id()
					)
				);
		
		$this->loginUrl = $loginUrl;
		$this->logoutUrl = $logoutUrl;
	}
	
	
	function index()
	{
		$this->home();
	}

	function home() {
		$data = array();

		$data['fullname'] = $this->fullname;
		$data['logoutUrl'] = $this->logoutUrl;
		$data['user_id'] = $this->user_id;
		$data['fbuid'] = $this->fbuid;
		$data['group_id'] = "0";
		$data['inGroupView'] = "0";
		
		$data['owner_id'] = $this->owner_id;
		
		$data['phonenumbers_data'] = $this->phonenumbersm->get_for_user_id($this->user_id);
		
		$this->addCSS();
		$this->addJS();
		$this->writeTemplate($data);
		$this->template->render();
	}
	
	function dashboard() {
		//slim?module=feed&group_id=40&user_id=1&inGroupView=1
		
		$data = array();
		foreach ($_GET as $var => $val)
		{
			$data[$var] = $val;
		}
		
		if ($data['user_id'] != $this->user_id) {
			echo json_encode(array('result' => 'unauthorized access detected'));
			return;
		}	
		
		$dashboard_view = $this->load->view('layout/phone/modules/dashboard', $data, TRUE);
		
		$dashboard = array('result' => $dashboard_view);
		echo json_encode($dashboard);
		//echo $a;
	}
	
	
	function slim() {
		$data = array();
		foreach ($_GET as $var => $val)
		{
			$data[$var] = $val;
		}
		$data['slim'] = 1;
		
		$a = $this->load->view('layout/phone/modules/'.$data['module'], $data, TRUE);
		
		if (isset($_GET['nojson']))
		{
			echo $a;
		} else {
			$b = array('result' => $a);
			echo json_encode($b);
		}
	}
	
	function writeTemplate($data, $type = "all") {
		if ($type == "all")
		{
			$this->template->write_view('leftbar', 'layout/phone/leftbar', $data, TRUE);
			$this->template->write_view('main', 'layout/phone/main', $data, TRUE);
			$this->template->write_view('header', 'layout/phone/header', $data, TRUE);
			$this->template->write_view('footer', 'layout/phone/footer', $data, TRUE);
		} else if ($type == "slim"){
			$this->template->write_view('slim', 'layout/phone/slim', $data, TRUE);
		}
	}
	
	function addJS($version = "all") {
		if ($version == "all")
		{
			// core jquery
			$this->template->add_js('asset/js/jquery.min.1.6.4.js');
			
//			$this->template->add_js('asset/js/jquery.ui.core.js');
//			$this->template->add_js('asset/js/jquery.ui.position.js');


//			$this->template->add_js('asset/js/jquery.ui.datepicker.js');
			
//			$this->template->add_js('asset/js/date.js');
//			$this->template->add_js('asset/js/jquery.dp_calendar.max.js');

//			$this->template->add_js('asset/js/bootstrap-1.4/bootstrap-modal.js');
//			$this->template->add_js('asset/js/bootstrap-1.4/bootstrap-dropdown.js');
//			$this->template->add_js('asset/js/bootstrap-1.4/bootstrap-tabs.js');
//			$this->template->add_js('asset/js/bootstrap-1.4/bootstrap-twipsy.js');
//			$this->template->add_js('asset/js/bootstrap-1.4/bootstrap-popover.js');
//			$this->template->add_js('asset/js/bootstrap-1.4/bootstrap-alerts.js');
//			$this->template->add_js('asset/js/bootstrap-1.4/bootstrap-scrollspy.js');
			$this->template->add_js('asset/js/bootstrap-1.4/bootstrap-buttons.js');

			$this->template->add_js('asset/js/phone/application.js');

//			$this->template->add_js('asset/js/new/sha1.js');
			$this->template->add_js('asset/js/phone/members.js');
			$this->template->add_js('asset/js/phone/dynamic.js');

			$this->template->add_js('asset/js/highcharts/highcharts.js');
			
/*			$this->template->add_js('asset/js/plupload/plupload.js');
			$this->template->add_js('asset/js/plupload/plupload.gears.js');
			$this->template->add_js('asset/js/plupload/plupload.silverlight.js');
			$this->template->add_js('asset/js/plupload/plupload.flash.js');
			$this->template->add_js('asset/js/plupload/plupload.browserplus.js');
			$this->template->add_js('asset/js/plupload/plupload.html4.js');
			$this->template->add_js('asset/js/plupload/plupload.html5.js');
			$this->template->add_js('asset/js/new/file.js');
			
			$this->template->add_js('asset/js/new/calendar.js');
			$this->template->add_js('asset/js/new/jquery.jeditable.mini.js');
			$this->template->add_js('asset/js/new/jquery.validate.min.js');
			//$this->template->add_js('https://js.stripe.com/v1/');
			$this->template->add_js('asset/js/new/v1.js');
			$this->template->add_js('asset/js/new/pay.js');
			
			$this->template->add_js('asset/js/new/jquery.fcbkcomplete.js');
*/
		} else if ($version == "none") {
			
		}
		
	}
	
	function addCSS($version = "all") {
		if ($version == "all")
		{
			$this->template->add_css('asset/css/new/openlook.css');
			
			$this->template->add_css('asset/css/new/fonts.css');

			$this->template->add_css('asset/css/bootstrap-1.4/bootstrap.css');
			$this->template->add_css('asset/css/site1.css');
			$this->template->add_css('asset/css/style1.css');
			$this->template->add_css('asset/css/jquery.ui.all.css');


			$this->template->add_css('asset/css/new/theme_azure.css');
			$this->template->add_css('asset/css/new/ribbons.css');
			$this->template->add_css('asset/css/new/uploadbar.css');
			$this->template->add_css('asset/css/new/theme_azure_sidebar.css');
			
			$this->template->add_css('asset/css/navglass.css');
			//visual search

			//new leftbar navigation
			$this->template->add_css('asset/css/new/navac.css');

			$this->template->add_css('asset/css/site1.css');
			$this->template->add_css('asset/css/style1.css');
			
		} else if ($version == "none") {

		} 
	}
}

?>
