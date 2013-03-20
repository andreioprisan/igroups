<?php

class Igroupsc extends CI_Controller {
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
		$this->load->model('modules/messages', 'messages_model');

		//$this->load->library('facebook');

		$this->load->model('igroups_group');
		$this->load->model('igroups_user');
		$this->load->model('filemanager');
		
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
		$this->template->write('title', 'Home');

		$data['fullname'] = $this->fullname;
		$data['logoutUrl'] = $this->logoutUrl;
		$data['user_id'] = $this->user_id;
		$data['fbuid'] = $this->fbuid;
		$data['group_id'] = "0";
		
		$data['inGroupView'] = "0";
		$data['view'] = "groupsManage";
		
		$data['group_files'] = $this->filemanager->get_group_files($this->group_id, $this->user_id);
		
		$data['groups_data'] = $this->usergroups_model->get_user_membership_groups($this->user_id);

		$data['all_users'] = $this->igroups_group->get_users(array('owner_id' => $this->owner_id));
		$data['users_groups_assoc'] = $this->igroups_group->get_users_groups_assoc($this->owner_id);

		$data['distinct_groups_users_pairing_gmpage'] = $this->igroups_group->get_distinct_groups_users_pairing_gmpage($this->owner_id);
		
		//$data['groups_data'] = $this->usergroups_model->get_groups_by_owner($this->owner_id);
		$data['owner_id'] = $this->owner_id;
		
		$this->addCSS();
		$this->addJS();
		$this->writeTemplate($data);
		$this->template->render();
	}
	
	function simple() {
		$this->load->view("simple");
	}
	
	function slim() {
		//slim?module=feed&group_id=40&user_id=1&inGroupView=1
		
		$data = array();
		foreach ($_GET as $var => $val)
		{
			$data[$var] = $val;
		}
		$data['slim'] = 1;
		
		$a = $this->load->view('layout/content/modules/'.$data['module'], $data, TRUE);
		
		if (isset($_GET['nojson']))
		{
			echo $a;
		} else {
			$b = array('result' => $a);
			echo json_encode($b);
		}
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
		
		$dashboard_view = $this->load->view('layout/content/modules/dashboard', $data, TRUE);
		
		$dashboard = array('result' => $dashboard_view);
		echo json_encode($dashboard);
		//echo $a;
	}
	
	function writeTemplate($data, $type = "all") {
		if ($type == "all")
		{
			$this->template->write_view('leftbar', 'layout/content/leftbar', $data, TRUE);
			$this->template->write_view('topbar', 'layout/content/topbar', $data, TRUE);
			$this->template->write_view('main', 'layout/content/main', $data, TRUE);
			$this->template->write_view('header', 'layout/content/header', $data, TRUE);
			$this->template->write_view('footer2', 'layout/content/footer2', $data, TRUE);
		} else if ($type == "slim"){
			$this->template->write_view('slim', 'layout/content/slim', $data, TRUE);
		} else if ($type == "gm"){
			$this->template->write_view('leftbar', 'layout/content/leftbar', $data, TRUE);
			$this->template->write_view('topbar', 'layout/content/topbar', $data, TRUE);
			$this->template->write_view('main', 'layout/content/main', $data, TRUE);
			$this->template->write_view('header', 'layout/content/header', $data, TRUE);
			$this->template->write_view('footer2', 'layout/content/footer2', $data, TRUE);
			$this->template->write_view('groupsmanagepage', 'layout/content/modules/groups', $data, TRUE);
		}
	}
	
	function addJS($version = "all") {
		if ($version == "all")
		{
			// core jquery
			$this->template->add_js('asset/js/jquery.min.1.6.4.js');
			
			$this->template->add_js('asset/js/jquery.ui.core.js');
			$this->template->add_js('asset/js/jquery.ui.position.js');
//			$this->template->add_js('asset/js/jquery-ui.min.js');
//			$this->template->add_js('asset/js/ui.selectmenu.js');
			
			// visual search
			/*
			$this->template->add_js('asset/js/visualsearch/jquery.ui.widget.js');
			$this->template->add_js('asset/js/visualsearch/jquery.ui.autocomplete.js');
			$this->template->add_js('asset/js/visualsearch/underscore-1.1.5.js');
			$this->template->add_js('asset/js/visualsearch/backbone-0.5.0.js');
			$this->template->add_js('asset/js/visualsearch/visualsearch.js');
			$this->template->add_js('asset/js/visualsearch/views/search_box.js');
			$this->template->add_js('asset/js/visualsearch/views/search_facet.js');
			$this->template->add_js('asset/js/visualsearch/views/search_input.js');
			$this->template->add_js('asset/js/visualsearch/models/search_facets.js');
			$this->template->add_js('asset/js/visualsearch/models/search_query.js');
			$this->template->add_js('asset/js/visualsearch/utils/backbone_extensions.js');
			$this->template->add_js('asset/js/visualsearch/utils/hotkeys.js');
			$this->template->add_js('asset/js/visualsearch/utils/jquery_extensions.js');
			$this->template->add_js('asset/js/visualsearch/utils/search_parser.js');
			$this->template->add_js('asset/js/visualsearch/utils/inflector.js');
			$this->template->add_js('asset/js/visualsearch/templates/templates.js');
			*/
			
			$this->template->add_js('asset/js/jquery.ui.datepicker.js');
			
			$this->template->add_js('asset/js/date.js');
//			$this->template->add_js('asset/js/jquery.dp_calendar.max.js');

			$this->template->add_js('asset/js/bootstrap-1.4/bootstrap-modal.js');
			$this->template->add_js('asset/js/bootstrap-1.4/bootstrap-dropdown.js');
			$this->template->add_js('asset/js/bootstrap-1.4/bootstrap-tabs.js');
			$this->template->add_js('asset/js/bootstrap-1.4/bootstrap-twipsy.js');
			$this->template->add_js('asset/js/bootstrap-1.4/bootstrap-popover.js');
			$this->template->add_js('asset/js/bootstrap-1.4/bootstrap-alerts.js');
			$this->template->add_js('asset/js/bootstrap-1.4/bootstrap-scrollspy.js');
			$this->template->add_js('asset/js/bootstrap-1.4/bootstrap-buttons.js');

			$this->template->add_js('asset/js/application.js');

			$this->template->add_js('asset/js/new/sha1.js');
			$this->template->add_js('asset/js/new/members.js');
			$this->template->add_js('asset/js/new/dynamic.js');
			
			$this->template->add_js('asset/js/plupload/plupload.js');
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
//			$this->template->add_js('asset/js/new/jquery.autoSuggest.packed.js');
			
			
			
		} else if ($version == "base") {
			// core jquery
			$this->template->add_js('asset/js/jquery.min.1.6.4.js');
			$this->template->add_js('asset/js/jquery.ui.core.js');
			$this->template->add_js('asset/js/jquery.ui.position.js');
			// visual search
			$this->template->add_js('asset/js/visualsearch/jquery.ui.widget.js');
			$this->template->add_js('asset/js/visualsearch/jquery.ui.autocomplete.js');
			$this->template->add_js('asset/js/visualsearch/underscore-1.1.5.js');
			$this->template->add_js('asset/js/visualsearch/backbone-0.5.0.js');
			$this->template->add_js('asset/js/visualsearch/visualsearch.js');
			
			$this->template->add_js('asset/js/visualsearch/views/search_box.js');
			$this->template->add_js('asset/js/visualsearch/views/search_facet.js');
			$this->template->add_js('asset/js/visualsearch/views/search_input.js');
			$this->template->add_js('asset/js/visualsearch/models/search_facets.js');
			$this->template->add_js('asset/js/visualsearch/models/search_query.js');
			$this->template->add_js('asset/js/visualsearch/utils/backbone_extensions.js');
			$this->template->add_js('asset/js/visualsearch/utils/hotkeys.js');
			$this->template->add_js('asset/js/visualsearch/utils/jquery_extensions.js');
			$this->template->add_js('asset/js/visualsearch/utils/search_parser.js');
			$this->template->add_js('asset/js/visualsearch/utils/inflector.js');
			$this->template->add_js('asset/js/visualsearch/templates/templates.js');
			
			// calendar
			$this->template->add_js('asset/js/jquery.ui.datepicker.js');
			$this->template->add_js('asset/js/date.js');
			$this->template->add_js('asset/js/jquery.dp_calendar.max.js');

			// bootstrap js effects
			$this->template->add_js('asset/js/bootstrap-1.4/bootstrap-modal.js');
			$this->template->add_js('asset/js/bootstrap-1.4/bootstrap-alerts.js');
			$this->template->add_js('asset/js/bootstrap-1.4/bootstrap-twipsy.js');
			$this->template->add_js('asset/js/bootstrap-1.4/bootstrap-dropdown.js');
			$this->template->add_js('asset/js/bootstrap-1.4/bootstrap-scrollspy.js');
			$this->template->add_js('asset/js/bootstrap-1.4/bootstrap-buttons.js');
			$this->template->add_js('asset/js/bootstrap-1.4/bootstrap-tabs.js');
			$this->template->add_js('asset/js/bootstrap-1.4/bootstrap-popover.js');
			$this->template->add_js('asset/js/application.js');

			$this->template->add_js('asset/js/new/file.js');
			$this->template->add_js('asset/js/new/sha1.js');
			$this->template->add_js('asset/js/new/members.js');
		
//			$this->template->add_js('asset/js/new/jquery.fcbkcomplete.js');
//			$this->template->add_js('asset/js/new/jquery.fcbkcomplete.min.js');
			$this->template->add_js('asset/js/new/jquery.autoSuggest.packed.js');
			
			
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
			$this->template->add_css('asset/css/dp_calendar.css');

			$this->template->add_css('asset/css/new/theme_azure.css');
			$this->template->add_css('asset/css/new/ribbons.css');
			$this->template->add_css('asset/css/new/uploadbar.css');
			$this->template->add_css('asset/css/new/theme_azure_sidebar.css');
			
			$this->template->add_css('asset/css/navglass.css');
			//visual search
			$this->template->add_css('asset/css/visualsearch/reset.css');
			$this->template->add_css('asset/css/visualsearch/icons.css');
			$this->template->add_css('asset/css/visualsearch/workspace.css');
			
			//new leftbar navigation
			$this->template->add_css('asset/css/new/navac.css');

			$this->template->add_css('asset/css/new/autocomplete.css');
//			$this->template->add_css('asset/css/new/autoSuggest.css');
			$this->template->add_css('asset/css/site1.css');
			$this->template->add_css('asset/css/style1.css');
			
		
		} else if ($version == "calendar") {
			
		} else if ($version == "nogroupmanage") {
			$this->template->add_css('asset/css/new/fonts.css');

			$this->template->add_css('asset/css/bootstrap-1.4/bootstrap.css');
			$this->template->add_css('asset/css/site1.css');
			$this->template->add_css('asset/css/style1.css');
			$this->template->add_css('asset/css/dp_calendar.css');
			$this->template->add_css('asset/css/jquery.ui.all.css');

			$this->template->add_css('asset/css/new/theme_azure.css');
			$this->template->add_css('asset/css/new/ribbons.css');
			$this->template->add_css('asset/css/new/uploadbar.css');
			$this->template->add_css('asset/css/new/theme_azure_sidebar.css');
		} else if ($version == "base") {
			$this->template->add_css('asset/css/new/fonts.css');
			$this->template->add_css('asset/css/bootstrap-1.4/bootstrap.css');
			$this->template->add_css('asset/css/new/theme_azure.css');
			$this->template->add_css('asset/css/new/ribbons.css');
			$this->template->add_css('asset/css/new/uploadbar.css');
			$this->template->add_css('asset/css/new/theme_azure_sidebar.css');
		} else if ($version == "none") {

		} 
	}
	
	function groupsManage() {
		$data = array();

		$data['fullname'] = $this->fullname;
		$data['user_id'] = $this->user_id;
		$data['fbuid'] = $this->fbuid;
		$data['owner_id'] = $this->user_id;

		$data['view'] = "groupsManage";
		$data['groups_data'] = $this->usergroups_model->get_user_membership_groups($this->user_id);
		$data['all_users'] = $this->igroups_group->get_users(array('owner_id' => $this->user_id));
		$data['users_groups_assoc'] = $this->igroups_group->get_users_groups_assoc($this->user_id);
		$data['distinct_groups_users_pairing_gmpage'] = $this->igroups_group->get_distinct_groups_users_pairing_gmpage($this->user_id);
		//$data['groups_data'] = $this->usergroups_model->get_groups_by_owner($this->owner_id);

//		$data['groups_data'] = $this->usergroups_model->get_groups_by_owner($this->owner_id);

		$this->addCSS();
		$this->addJS();
		$this->writeTemplate($data, "gm");
		$this->template->render();
		
//		$this->template->render();
		
	}
	
	function format_bytes($bytes = 0) {
	   if ($bytes < 1024) return $bytes.' B';
	   elseif ($bytes < 1048576) return round($bytes / 1024, 2).' KB';
	   elseif ($bytes < 1073741824) return round($bytes / 1048576, 2).' MB';
	   elseif ($bytes < 1099511627776) return round($bytes / 1073741824, 2).' GB';
	   else return round($bytes / 1099511627776, 2).' TB';
	}
	
	function group() {
		$data = array();
		
		$group_id = ( $this->uri->segment(3) ? $this->uri->segment(3) : 0 );
		$this->group_id = $group_id;
		if ($group_id == 0) {
			redirect('https://'.$_SERVER['HTTP_HOST'].'/igroupsc', 'refresh');
		}
		
		$mygroup = $this->usergroups_model->check_group_access_permission($group_id, $this->user_id);
		
		if (!$mygroup) {
			redirect('https://'.$_SERVER['HTTP_HOST'].'/igroupsc', 'refresh');
		} 
		
//		$data['groups_data'] = $this->usergroups_model->get_groups_by_owner($this->user_id);
		$data['groups_data'] = $this->usergroups_model->get_user_membership_groups($this->user_id);
		$data['group_files'] = $this->filemanager->get_group_files($this->group_id);

		$data['owner_id'] = $this->owner_id;
		$data['group_id'] = $this->group_id;
		$data['user_id'] = $this->user_id;
		$data['fullname'] = $this->fullname;
		$data['inGroupView'] = "0";

		$i = 0;
		foreach ($data['group_files'] as $file)
		{
			$data['group_files'][$i]->size = $this->format_bytes($file->size);
			$udata = $this->igroups_user->get_user_details($file->user_id);
			$data['group_files'][$i]->author = $udata->first_name." ".$udata->last_name;
			$data['group_files'][$i]->delete = "user_id=".$file->user_id."&group_id=".$file->group_id."&encID=".$file->encID."&encFileName=".$file->encFileName;

			$i++;
		}
		
		$this->template->write('title', 'Group');
		// module arangement
		$data['modules'] = array(
			'feed' => 'left', 
			'members' => 'left',
			
			'calendar' => 'right',
			'messages' => 'right', 
			'files' => 'right'
			
			);
		
		// page breakdown
		$data['horizontal_spans'] = array(
			'cols' => '2', 
			'spans' => array('span11', 'span8')
		);
		
		// replace by db query
		$this_group = $this->usergroups_model->get_group($group_id, $this->owner_id);
		
		$data['header'] = array(	
			'title'	=>	$this_group->name,
			'description'	=>	$this_group->summary);
		
		$data['fullname'] = $this->fullname;
		$data['logoutUrl'] = $this->logoutUrl;
		
		//$this->template->add_css('asset/css/site1.css');
		//$this->template->add_css('asset/css/style1.css');
		
		$data['view'] = "groupsManage";
		$data['groups_data'] = $this->usergroups_model->get_groups_by_owner($this->owner_id);

		$data['all_users'] = $this->igroups_group->get_users(array('owner_id' => $this->owner_id));
		$data['users_groups_assoc'] = $this->igroups_group->get_users_groups_assoc($this->owner_id);
		
		$this->addCSS("none");
		$this->addJS("none");
		$this->writeTemplate($data, "slim");
		
		$this->template->render();
		
	}

	function n() {
		
		$this->load->view("layout/content/nl");
	}
	
	function ns() {
		$data = array();
		
		$group_id = ( $this->uri->segment(3) ? $this->uri->segment(3) : 0 );
		$this->group_id = $group_id;
		if ($group_id == 0) {
			redirect('https://'.$_SERVER['HTTP_HOST'].'/igroupsc', 'refresh');
		}
		
		$mygroup = $this->usergroups_model->check_group_access_permission($group_id, $this->user_id);
		
		if (!$mygroup) {
			redirect('https://'.$_SERVER['HTTP_HOST'].'/igroupsc', 'refresh');
		} 
		
//		$data['groups_data'] = $this->usergroups_model->get_groups_by_owner($this->user_id);
		$data['groups_data'] = $this->usergroups_model->get_user_membership_groups($this->user_id);
		$data['group_files'] = $this->filemanager->get_group_files($this->group_id);

		$data['owner_id'] = $this->owner_id;
		$data['group_id'] = $this->group_id;
		$data['user_id'] = $this->user_id;
		$data['fullname'] = $this->fullname;
		$data['inGroupView'] = "0";

		$i = 0;
		foreach ($data['group_files'] as $file)
		{
			$data['group_files'][$i]->size = $this->format_bytes($file->size);
			$udata = $this->igroups_user->get_user_details($file->user_id);
			$data['group_files'][$i]->author = $udata->first_name." ".$udata->last_name;
			$data['group_files'][$i]->delete = "user_id=".$file->user_id."&group_id=".$file->group_id."&encID=".$file->encID."&encFileName=".$file->encFileName;

			$i++;
		}
		
		$this->template->write('title', 'Group');
		// module arangement
		$data['modules'] = array(
			'feed' => 'left', 
			'Tasks' => 'left',
			'members' => 'left',
			
			'calendar' => 'left',
			'messages' => 'left', 
			'files' => 'left'
			
			);
		
		// page breakdown
		$data['horizontal_spans'] = array(
			'cols' => '2', 
			'spans' => array('span5', 'span14')
		);
		
		// replace by db query
		$this_group = $this->usergroups_model->get_group($group_id, $this->owner_id);
		
		$data['header'] = array(	
			'title'	=>	$this_group->name,
			'description'	=>	$this_group->summary);
		
		$data['fullname'] = $this->fullname;
		$data['logoutUrl'] = $this->logoutUrl;
		
		$this->addCSS();
		$this->addJS();
		$this->writeTemplate($data);
		$this->template->render();
	}
}

?>
