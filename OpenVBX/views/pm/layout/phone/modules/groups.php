<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
	<title>igrou.ps group management</title>
	<link type="text/css" rel="stylesheet" href="/asset/css/new/openlook.css" /><link type="text/css" rel="stylesheet" href="/asset/css/new/fonts.css" /><link type="text/css" rel="stylesheet" href="/asset/css/bootstrap-1.4/bootstrap.css" /><link type="text/css" rel="stylesheet" href="/asset/css/site1.css" /><link type="text/css" rel="stylesheet" href="/asset/css/style1.css" /><link type="text/css" rel="stylesheet" href="/asset/css/jquery.ui.all.css" /><link type="text/css" rel="stylesheet" href="/asset/css/dp_calendar.css" /><link type="text/css" rel="stylesheet" href="/asset/css/new/theme_azure.css" /><link type="text/css" rel="stylesheet" href="/asset/css/new/ribbons.css" /><link type="text/css" rel="stylesheet" href="/asset/css/new/uploadbar.css" /><link type="text/css" rel="stylesheet" href="/asset/css/new/theme_azure_sidebar.css" /><link type="text/css" rel="stylesheet" href="/asset/css/navglass.css" /><link type="text/css" rel="stylesheet" href="/asset/css/visualsearch/reset.css" />	
	<!-- Le HTML5 shim, for IE6-8 support of HTML elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
	<script type="text/javascript" src="/asset/js/jquery.min.1.6.4.js"></script><script type="text/javascript" src="/asset/js/jquery.ui.core.js"></script><script type="text/javascript" src="/asset/js/jquery.ui.position.js"></script><script type="text/javascript" src="/asset/js/jquery.ui.datepicker.js"></script><script type="text/javascript" src="/asset/js/date.js"></script><script type="text/javascript" src="/asset/js/bootstrap-1.4/bootstrap-modal.js"></script><script type="text/javascript" src="/asset/js/bootstrap-1.4/bootstrap-dropdown.js"></script><script type="text/javascript" src="/asset/js/bootstrap-1.4/bootstrap-tabs.js"></script><script type="text/javascript" src="/asset/js/bootstrap-1.4/bootstrap-twipsy.js"></script><script type="text/javascript" src="/asset/js/bootstrap-1.4/bootstrap-popover.js"></script><script type="text/javascript" src="/asset/js/bootstrap-1.4/bootstrap-alerts.js"></script><script type="text/javascript" src="/asset/js/bootstrap-1.4/bootstrap-scrollspy.js"></script><script type="text/javascript" src="/asset/js/bootstrap-1.4/bootstrap-buttons.js"></script><script type="text/javascript" src="/asset/js/application.js"></script><script type="text/javascript" src="/asset/js/new/sha1.js"></script><script type="text/javascript" src="/asset/js/new/members.js"></script>
</head>
<body onload="">
	
<?php

$fullname = $this->fullname;
$user_id = $this->user_id;
$fbuid = $this->fbuid;
$owner_id = $this->user_id;

$groups_data = $this->usergroups_model->get_user_membership_groups($this->user_id);
$all_users = $this->igroups_group->get_users(array('owner_id' => $this->user_id));
$users_groups_assoc = $this->igroups_group->get_users_groups_assoc($this->user_id);
$distinct_groups_users_pairing_gmpage = $this->igroups_group->get_distinct_groups_users_pairing_gmpage($this->user_id);


?>

<div id="groups_module" style="display: block">

					<div id="ig-main">
						<div class="ig-content-banner info-banner hide">
							<a href="" class="close action"><span class="replace">Close</span></a>
							<div class="info-message">
								<h3>Heading</h3>
								<p>Content</p>
							</div>
						</div>

					<div class="ig-content-main">


<div class="igroups-ge accounts-section">
	
<div class="igroups-u first">	
	<div id="user-container">
		<h2><a id="adduserbutton" href="#" data-original-title="drag & drop your users" data-content="into groups to the right">users</a> <div style="display:inline;"></div>
		<button data-controls-modal="modal-from-dom" data-backdrop="true" data-keyboard="true" class="btn primary" OnMouseOver="clearAddMemberForm();"><b><font color=white >add</font></b> user</button>
</h2>
<!--
<button data-controls-modal="modal-delete-user" data-backdrop="true" data-keyboard="true" class="btn primary"><b><font color=white >delete</font></b> user</button>-->
</h2>
		<script type="text/javascript">
		   
		   $("#adduserbutton").popover({offset: 1, placement: 'right', delayOut: '1000'});
		</script>
		<ul class="user-list">
			<?php foreach ($all_users as $user) {?>
			<li class="user" rel="<?= $user->id?>">
				<div class="user-utilities">
					<a class="user-edit" href="#edit"><span class="replace">Edit</span></a>
					<a class="user-remove" href="#remove"><span class="replace">Remove</span></a>
				</div>
				<div class="user-info">
					<p class="user-name"><?= $user->first_name; ?> <?= $user->last_name; ?></p>
					<p class="user-email"><?= $user->email; ?></p>
				</div>
			</li>
			<?php } ?>
			<li class="user" rel="prototype" style="display:none;">
				<div class="user-utilities">
					<a class="user-edit" href="#edit"><span class="replace">Edit</span></a>
					<a class="user-remove" href="#remove"><span class="replace">Remove</span></a>
				</div>
				<div class="user-info">
					<p class="user-name">(prototype)</p>
					<p class="user-email"></p>
				</div>
			</li>
		</ul>
	</div><!-- #user-container -->
</div><!-- .igroups-u .first -->

<div class="igroups-u">

	<div id="group-container">
		<h2 style="color: red; font-color: red;"><a id="addgroupbutton" href="#" data-original-title="click on a group's name" data-content="to see each group's members"  style="color: red; font-color: red;">groups</a> <div style="display:inline; align:right; "><button id="button-add-group" class="btn danger"><span><b><font color=white>add</font></b> group</span></button></div></h2>
		<script type="text/javascript">
		   $("#addgroupbutton").popover({offset: 1, placement: 'left', delayOut: '1000'});
		</script>
		<ul class="group-list">
			<?php if (isset($distinct_groups_users_pairing_gmpage)) { 
				foreach($distinct_groups_users_pairing_gmpage as $g_id => $g_info) { ?>
			<li class="group" rel="<?= $g_id; ?>">
				<img class="group-counter-loader hide" src="/asset/images/ajax-loader-circle.gif" alt="loading" />
				<span class="group-counter"><?= count($g_info['users']); ?></span>

				<div class="group-utilities">
					<a class="group-edit" href="#edit">Edit Group</a>
					<a class="group-remove" href="#remove">Remove Group</a>
				</div>

				<div class="group-info">
					<p class="group-name"><?= $g_info['name']; ?></p>
				</div>

				<ul class="members">
					<?php foreach ($g_info['users'] as $u_id => $u_name) { ?>
					<li rel="<?= $u_id; ?>">
						<span><?= $u_name; ?></span>
						<a class="remove">Remove</a>
					</li>
					<?php } ?>
				</ul>
			</li>	
				<?php } ?>
			<?php } ?>
			<li class="group" rel="prototype" style="display:none;">
				<span class="group-counter">0</span>
				<div class="group-utilities">
					<a class="group-edit" href="#">Edit Group</a>
					<a class="group-remove" href="#">Remove Group</a>
				</div>

				<div class="group-info">
					<p class="group-name">(Prototype)</p>
				</div>
				<ul class="members"></ul>
			</li>
		</ul>
	</div><!-- #group-container -->

</div><!-- .igroups-u -->

</div><!-- .igroups-ge 3/4, 1/4 -->

</div><!-- .ig-content-main -->


<div id="modal-delete-user" class="modal hide fade" style="display: none; ">
<form id="deletememberform" onsubmit="return false;">
<input type="hidden" name="deletememberid" id="id" value="">
<div class="modal-header">
<a href="#" class="close primary">×</a>
<h3 id='modal-header-value'>delete user</h3>
</div>

<div class="modal-footer">
<input type="submit" class="btn danger deletememberformsubmitbutton" value="Yes, Delete" id="deletememberformsubmitbutton">
<input type="button" class="btn primary deletememberformsubmitbutton" value="No" id="deletememberformsubmitbutton">
<div class="input-prepend">
<b><font size="3.5">Are you sure that you wish to delete this user?</font></b>
</div>
</div>
</form>
</div>

<div id="modal-from-dom" class="modal hide fade" style="display: none; ">
<form id="addmemberform" onsubmit="return false;">
<input type="hidden" name="id" id="id" value="">
<div class="modal-header">
<a href="#" class="close primary">×</a>
<h3 id='modal-header-value'>add new user</h3>
</div>
<div class="modal-body">
<p>
		<div id="divresult"></div>
 <div class="alert-message error" style="display:none;" id="divfirst_nameerror">
<p><strong>Oh no!</strong> Please enter a valid first name.</p>
</div>
<div class="alert-message error" style="display:none;" id="divlast_nameerror">
<p><strong>Oh no!</strong> Please enter a valid last name.</p>
</div>
<div class="alert-message error" style="display:none;" id="divemailerror">
<p><strong>Oh no!</strong> Please enter a valid email address.</p>
</div>
<div class="alert-message error" style="display:none;" id="divmultipleerror">
<p><strong>Oh no!</strong> Please fill out the fields below:</p>
</div>
<fieldset>
<div class="clearfix" id="divfirst_name">
<label for="first_name">First Name</label>
<div class="input">
<input class="xlarge addmemberformtext" id="first_name" name="first_name" size="30" type="text">
		</div>
</div>
</fieldset>
<fieldset>
<div class="clearfix divlast_name" id="divlast_name">
<label for="last_name">Last Name</label>
<div class="input">
<input class="xlarge addmemberformtext" id="last_name" name="last_name" size="30" type="text">
</div>
</div>
</fieldset>
<fieldset>
<div class="clearfix divemail" id="divemail">
<label for="email">Email</label>
<div class="input">
<input class="xlarge addmemberformtext" id="email" name="email" size="30" type="text">
</div>
</div>
</fieldset>
<fieldset>
<div class="clearfix divphone_number">
<label for="phone_number">Phone Number</label>
<div class="input">
<input class="xlarge addmemberformtext" id="phone_number" name="phone_number" size="15" type="text">
</div>
</div>
</fieldset>
</p>
</div>
<div class="modal-footer">
<input type="submit" class="btn primary addmemberformsubmitbutton" value="Save" id="addmemberformsubmit">
<div class="input-prepend">
  <label class="add-on "><input type="checkbox" name="is_admin" id="is_admin" value="1" class="addmemberformtext"></label>
  <input class="mini" id="is_admintxt" name="is_admintxt" size="32" length="32" type="text" value="Make Administrator"  style="width: 116px;">
</div>
</div>
</form>
</div>
















<div id="dialog-invite-user" title="Invite User" class="hide dialog">
	<div class="error-message hide"></div>
		<form class="ig-form" onsubmit="return false;">
			<fieldset class="ig-input-container">
				<label class="field-label">Email
					<input type="text" class="medium" name="email" value="" />
				</label>
			</fieldset>
		</form>
	</div>


<div id="dialog-user-edit-or-add-prototype" title="Edit or Add User" class="hide dialog">
	<div class="error-message hide"></div>
	<form class="ig-form" onsubmit="return false;">
		<input type="hidden" name="id" />
		<fieldset class="ig-input-container">
			<label class="field-label" for="iFirstName">First Name
				<input type="text" id="iFirstName" class="medium" name="first_name" />
			</label>

			<label class="field-label" for="iLastName">Last Name
				<input type="text" id="iLastName" class="medium" name="last_name" />
			</label>

			<label class="field-label" for="iEmail">Email
				<input type="text" id="iEmail" class="medium" name="email" />
			</label>

			<div class="single-existing-number">
				<label class="field-label" for="iDeviceNumber">Existing Mobile or Land-line Number
					<input type="hidden" name="device_id" value="" />
					<input type="text" id="iDeviceNumber" class="medium" name="device_number" />
					<span style="font-style: italic; font-size: 11px;">When a call is routed to this person, this is the number that will be called.</span>
				</label>
			</div>

			<div class="multiple-existing-numbers">
				<br />
				<p>This person has multiple devices configured.  They'll<br />need to login to their account, and open My Account<br />to add or remove devices.</p>
			</div>
		</fieldset>

		<br />

		<fieldset class="ig-input-complex ig-input-container">
			<label class="field-label-inline" for="iIsAdmin">
				<input type="checkbox" id="iIsAdmin" name="is_admin" value="1" />
				Administrator
			</label>
		</fieldset>
	</form>
</div>


<div id="dialog-group-edit" title="Add New Group" class="hide dialog">
<div class="error-message hide"></div>
<p>Groups are collections of users who can be dialed and who can share voicemail messages. For example, "Sales Team" or "Technical Support</p>
<form class="ig-form" onsubmit="return false;">
<input type="hidden" name="id" />
<fieldset class="ig-input-container">
<label class="field-label" for="iGroup">Group Name
	<input type="text" id="iGroup" class="medium" name="name" />
</label>
</fieldset>
</form>
</div>

<div id="dialog-delete" title="Delete" class="hide dialog">
<div class="error-message hide"></div>
<div id="dConfirmMsg">
<p>Are you sure you want to delete?</p>
</div>
</div>
					</div>
					

</div>
<script type="text/javascript">
	// global params
	OpenVBX = {home: null, assets: null, client_capability: null};
	OpenVBX.home = 'https://igrou.ps.dev';
	OpenVBX.assets = 'https://igrou.ps.dev/';
</script>
<script type="text/javascript" src="/asset/js/new/membersgroups_prereq.js"></script>
<script type="text/javascript" src="/asset/js/new/membersgroups_manager.js"></script>

</body>
</html>

