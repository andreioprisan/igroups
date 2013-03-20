var dashboard = 0;
var paymentid = 0;
var paymentcusid = "";
var paymentamount = "99";

var objecttype = "0";
var objectid = "0";

var toggle_groupandmember = "0";

var data_to_user_id = "";
var data_group_id = "";


function parseJSON(data) {
    return JSON ? JSON.parse(data) : eval('(' + data + ')');
}

function newtaskpane() {
	var model = []; 
	model[0]=['header','New Task','','','','',								'order','0']; 
	model[1]=['desc','group','elemType','text','elemLabel','New Task',		'order','1']; 
	model[2]=['desc','due','elemType','text','elemLabel','',				'order','2']; 
	model[3]=['desc','group','elemType','autocomplete','elemLabel','',		'order','5']; 
	model[4]=['desc','member','elemType','autocomplete','elemLabel','',		'order','6']; 
	model[5]=['desc','priority','elemType','text','elemLabel','',			'order','3'];
	model[6]=['desc','private','elemType','text','elemLabel','0',			'order','4']; 
	model[7]=['desc','what','elemType','text','elemLabel','',				'order','7']; 
	model[8]=['desc','control','elemType','text','elemLabel','',			'order','8']; 
	model[9]=['desc','objecttype','elemType','text','elemLabel','tasks',	'order','9']; 
	model[10]=['desc','objectid','elemType','text','elemLabel','new',		'order','10']; 
	
	setMRP(model); 

	loadautocompletes(); 

	$('.opl_item_readonly').hide(); 
	$('.opl_item_edit').show(); 
	$('#olk_rightform_submit_button').show();

}
function doActivateModule(module, userid, groupid, groupviewmode)
{
	user_id = userid;
	group_id = groupid;
	
	document.getElementById('pane1content').innerHTML = '<img src="/asset/images/ajax-loader-circle.gif" style="top: 250px; left: 250px; position: relative;">';
	document.getElementById('modalrightpane').setAttribute('class', 'modalrightpane hide fade out');
	
	document.getElementById('toolbar').getElementsByTagName('h2')[0].innerHTML = module;

	if (module == "tasks")
	{
		var button_txt = '<input type="button" class="btn primary" value="new task" onclick="newtaskpane()">';
		
//		console.log(button_txt);
		$('#toolbar_right').html(button_txt);
		
	}

	if (module == "files")
	{
		$.get('/igroupsc/slim?module=file_slim&group_id='+groupid+'&user_id='+userid+'&inGroupView='+groupviewmode+'', function(data) {
			document.getElementById('pane1content').innerHTML = data.result;
			$('#'+module+'_module').fadeIn('fast');
			$('#files_container').fadeIn('fast');
		});
		
		uploader.settings.url = '/uploader/upload?user_id='+userid+'&group_id='+groupid+'';
	} else if (module == "groupsusersmanage") {
		$('#files_container').fadeOut('fast');
		//document.getElementById('jsin').innerHTML = data.result;
		document.getElementById('pane1content').innerHTML = "<iframe src='/igroupsc/slim?module=groups&user_id="+user_id+"&nojson=1#edit' style='border-style: none; width: 100%; height: 100%; background-color: #fff;'>";
		//$('#'+module+'_module').fadeIn('fast');

	} else {
		$('#files_container').fadeOut('fast');
		
		$.get('/igroupsc/slim?module='+module+'&group_id='+groupid+'&user_id='+userid+'&inGroupView='+groupviewmode+'', function(data) {
			if (module == "files")
			{
				document.getElementById('jsin').innerHTML = data.result;
			} else {
				document.getElementById('pane1content').innerHTML = data.result;
			}
			$('#'+module+'_module').fadeIn('fast');
		});
		
	}

}

function backToGroupView(group_id, group_name, user_id)
{
	user_id = user_id;
	group_id = group_id;
	
	document.getElementById('groupselectedredtab_header').innerHTML = group_name; 
	$('#groupselectedredtab').show('fast'); 
	
	a=document.getElementById('feed_sidebar_header'); 
	a.setAttribute('onclick','doActivateModule(\'feed\','+user_id+','+group_id+',\'1\')');
	a=document.getElementById('tasks_sidebar_header'); 
	a.setAttribute('onclick','doActivateModule(\'tasks\','+user_id+','+group_id+',\'1\')');
	a=document.getElementById('messages_sidebar_header'); 
	a.setAttribute('onclick','doActivateModule(\'messages\','+user_id+','+group_id+',\'1\')');
	a=document.getElementById('calendar_sidebar_header'); 
	a.setAttribute('onclick','doActivateModule(\'calendar\','+user_id+','+group_id+',\'1\')');
	a=document.getElementById('files_sidebar_header'); 
	a.setAttribute('onclick','doActivateModule(\'files\','+user_id+','+group_id+',\'1\')');
	a=document.getElementById('groups_sidebar_header'); 
	a.setAttribute('onclick','doActivateModule(\'groups\','+user_id+','+group_id+',\'1\')');
}

function backToDashboardView(user_id) 
{
	user_id = user_id;
	group_id = "0";
	
	// hide modal pane, just in case
	$('#modalrightpane').fadeOut('fast');
	
	// enable main pane with correct dimensions
	maxPane1(dashboard);
	
	$('#files_container').fadeOut('fast');
	
	// hide group name red tab

	// reset midpane 
	document.getElementById('toolbar').getElementsByTagName('h2')[0].innerHTML = 'Dashboard';
	document.getElementById('pane1content').innerHTML = '<img src="/asset/images/ajax-loader-circle.gif" style="top: 250px; left: 450px; position: relative;">';
	$.get('/igroupsc/dashboard?user_id='+user_id+'', function(data) {
		document.getElementById('pane1content').innerHTML = data.result; 
	});
	
/*	
	$.get('/igroupsc/slim?module=feed&user_id='+user_id+'&inGroupView=0&context=dashboard', function(data) {
		//if (document.getElementById('dashboardfeed_module')) {
		//	document.getElementById('dashboardfeed_module').innerHTML = data.result;
		//	isdashboardfeed = 1;
		//}
		if (document.getElementById('feed_module'))
			document.getElementById('feed_module').style.display = 'block';
		
		dashboard = 1;
	});
*/

	if (document.getElementById('feed_module'))
		document.getElementById('feed_module').style.display = 'block';
	
	// set module tags back to group view
	a=document.getElementById('feed_sidebar_header'); 
	a.setAttribute('onclick','doActivateModule(\'feed\','+user_id+',\'\',\'0\')');
	a=document.getElementById('tasks_sidebar_header'); 
	a.setAttribute('onclick','doActivateModule(\'tasks\','+user_id+',\'\',\'0\')');
	a=document.getElementById('messages_sidebar_header'); 
	a.setAttribute('onclick','doActivateModule(\'messages\','+user_id+',\'\',\'0\')');
	a=document.getElementById('calendar_sidebar_header'); 
	a.setAttribute('onclick','doActivateModule(\'calendar\','+user_id+',\'\',\'0\')');
	a=document.getElementById('files_sidebar_header'); 
	a.setAttribute('onclick','doActivateModule(\'files\','+user_id+',\'\',\'0\')');
//	a=document.getElementById('groups_sidebar_header'); 
//	a.setAttribute('onclick','doActivateModule(\'groups\','+user_id+',\'\',\'0\')');
	
}

function olk_rightform_delete(objecttype, objectid) {
	$.get('/ajaxpost/'+objecttype+'_delete?id=' + objectid,
	function(data) {
		console.log(data.result);
	});

	var inGroupViewShow = "1";
	if (group_id == "" || group_id == "0")
	{
		inGroupViewShow = "0";
	}
	doActivateModule(objecttype,user_id,group_id,inGroupViewShow);
	
	
	return false;
}


function olk_rightform_submit(objecttype, objectid, form) {
	var id = objectid;
	var due_val = $('#due').val();
	var eventtype_val = objecttype	;
	var priority_val = "0";
	var private_val = "0";
	var groupid = "0";
	var memberid = "0";
	var what_val = "";
	
	if (objecttype == "task") 
	{
		eventtype_val = "task";
	} else {
		eventtype_val = "";
	}
	
	if ($('#eventtype'))
	{
		eventtype_val = $('#eventtype').val();
	}
	
	//autocomplete
	if ($('#priority .selected'))
		priority_val = $('#priority .selected').val();
		
	if ($('#private_btn'))
		private_val = $('#private_btn').val();
	
	if ($('#groupname .selected'))
		groupid = $('#groupname .selected').val();
	
	if ($('#member .selected'))
		memberid = $('#member .selected').val();
	
	what_val = $('#what').val();
	
	
//	alert(what_var);
	
	if (id != "new")
	{
		//update items
		var token = "id="+id;
		token += "&due="+due_val;
		token += "&eventtype="+eventtype_val;
		token += "&priority="+priority_val;
		token += "&private="+private_val;
		token += "&what="+encodeURIComponent(what_val);
		token += "&user_id="+user_id;
		token += "&to_user_id="+memberid;
		token += "&group_id="+groupid;
		
		console.log('/ajaxpost/'+objecttype+'_update?' + token);
		if (objecttype == "tasks")
		{
			
			$.get('/ajaxpost/'+objecttype+'_update?' + token,
			function(data) {
				console.log(data.result);
			});
		}
	} else {
		// insert new
		
		console.log('/ajaxpost/'+objecttype+'_add?' + token);
		
		if (objecttype == "tasks")
		{
			var token = "due="+due_val;
			
			token += "&eventtype="+eventtype_val;
			token += "&priority="+priority_val;
			token += "&private="+private_val;
			token += "&what="+encodeURIComponent(what_val);
			token += "&user_id="+user_id;
			token += "&to_user_id="+memberid;
			token += "&group_id="+groupid;
			
			$.get('/ajaxpost/'+objecttype+'_add?' + token,
	        function(data) {
	            console.log(data.result);

	        });
		}
		
	}
	
	var inGroupViewShow = "1";
	if (group_id == "" || group_id == "0")
	{
		inGroupViewShow = "0";
	}
	doActivateModule(objecttype,user_id,group_id,inGroupViewShow);
	
	
	return false;
}

/**
 * Build right panel modal via model array
 * 
 * example:
 * var model = []; 
 * model[0]=['header','stream details']; 
 * model[1]=['desc','group','elemType','text','elemLabel','Harvard F11: CS160 Project']; 
 * model[2]=['desc','event type','elemType','text','elemLabel','fileupload']; 
 * model[3]=['desc','who','elemType','text','elemLabel','Andrei Oprisan']; 
 * model[4]=['desc','when','elemType','text','elemLabel','0000-00-00 00:00:00']; 
 * model[5]=['desc','what','elemType','text','elemLabel','Andrei Oprisan uploaded file.woff']; 
 * setMRP(model);
 */

function setMRP(model)
{
	text_elemId=1;
	input_elemId=11;
	var model_backup = model;
	
	var rightcontent = "";
	var countribbons = 0;
	var groupname = "";
	
	for (var i=0; i<model.length; i++)
	{
		item=model[i];
		if (item[1] == "objecttype") 
		{
			objecttype = item[5];
		} else if (item[1] == "objectid") {
			objectid = item[5];
		}
	}
	
	var model2 = [];
	var outcounter = "1";
	for (var i=0; i<model.length; i++)
	{
		item=model[i];
		model2[item[7]] = item;
	}
	
	model = model2;
//	console.log(model2);

	rightcontent += "<form id='olk_rightform' onsubmit='olk_rightform_submit(objecttype, objectid, this.form);return false;'>";
	
	for (var i=0; i<model.length; i++)
	{
		item=model[i];
		if (item[0] == "header")
		{

		} else {

			if (item.length == "0") {
				continue;
			}
			
			if (item[1] == "group") {
				if (item[3] == "autocomplete")
				{
					rightcontent += "<div id='groupname_readonly' class='opl_item_readonly' style='display: inline;'></div> ";
					
					rightcontent += "<div id='groupname_edit' class='opl_item_edit' style='display: none; '>";
					rightcontent += "<div class='input-prepend'>";
					rightcontent += "<label class='add-on' style='width:80px; float: left;'>&nbsp;<font color='black' style='float: left; padding-left: 5px;'>group name</font> &nbsp;</label>";
					rightcontent += "<input class='large' id='groupname' name='groupname' size='16' type='text' value='"+item[5]+"'> ";
					rightcontent += "</div></div><br/>";
					
				} else {
					if (item[5]) {
						groupname = item[5];
					
						var item = '<h3 style="display:inline;"><a href="#">'+groupname+'</a></h3>';
						$('#olk-details #indepth').html(item);
					}
				}
			} else {
 				if (item[1] == "what") {
					rightcontent += "<div id='"+item[1]+"_readonly' class='opl_item_readonly' style='display: inline; '>";
					rightcontent += "<dt>"+item[1]+"</dt>";
					rightcontent += "<dd>"+item[5]+"</dd>";
					rightcontent += "</div>";
					
					rightcontent += "<div id='"+item[1]+"_edit' class='opl_item_edit' style='display: none; '><b>"+item[1]+"</b><br /><br /><textarea style='width: 300px; height: 150px;' id='what'>"+item[5].replace(/(<br \/>)/gm,'\n')+"</textarea> </div>";
					
				} else {
					if (item[1] == "@") {
						rightcontent += "<div id='"+item[1]+"_readonly' class='opl_item_readonly' style='display: inline; '> <b>"+item[1]+"</b> "+item[5]+"<br/><br/></div>";
						rightcontent += "<div id='"+item[1]+"_edit' class='opl_item_edit' style='display: none; '><b>"+item[1]+"</b> "+item[5]+" </div>";
					} else if (item[1] == "by") {
						rightcontent += "<div id='"+item[1]+"_readonly' class='opl_item_readonly' style='display: inline; '><b>"+item[1]+"</b> "+item[5]+"</div>";
						rightcontent += "<div id='"+item[1]+"_edit' class='opl_item_edit' style='display: none; '><b>"+item[1]+"</b> "+item[5]+" </div>";
					} else if (item[1] == "priority") {
						if (item[5] == "1") {
							rightcontent += "<div id='"+item[1]+"_readonly' class='opl_item_readonly' style='display: inline;'><br><b>medium</b> priority<br></div> ";
						} else if (item[5] == "2") {
							rightcontent += "<div id='"+item[1]+"_readonly' class='opl_item_readonly' style='display: inline;'><br><b>high</b> priority<br></div> ";
						}

						rightcontent += "<div id='"+item[1]+"_edit' class='opl_item_edit' style='display: none; '>";
						rightcontent += "<div class='input-prepend'>";
						rightcontent += "<label class='add-on' style='width:80px; float: left;'>&nbsp;<font color='black' style='float: left; padding-left: 5px;'>"+item[1]+"</font> &nbsp;</label>";
						rightcontent += "<input class='large' id='"+item[1].replace(' ', '')+"' name='"+item[1]+"' size='16' type='text' value='"+item[5]+"'> ";
						rightcontent += "</div><br/></div>";

					} else if (item[1] == "private") {
						if (item[5] == "1") {
							rightcontent += "<div id='"+item[1]+"|*|*|"+item[5]+"' class='opl_item_readonly' style='display: inline;'><br><b>private</b><br /></div>";
						}
						
						rightcontent += "<div id='"+item[1]+"_edit' class='opl_item_edit' style='display: none; '>";
						rightcontent += "<div class='input-prepend'>";
						rightcontent += "<label class='add-on' style='width:80px; float: left;'>&nbsp;<font color='black' style='float: left; padding-left: 5px;'>"+item[1]+"</font> &nbsp;</label>";
						
						if (item[5] == "1") {
							buttonval = "yes";
							buttonclass = "danger";
						} else {
							buttonval = "no";
							buttonclass = "primary";
						}
						
						rightcontent += '<input class="btn '+buttonclass+'" id="private_btn" name="private" size="16" type="button" value="'+buttonval+'" onclick="toggle_private_btn();">';
						rightcontent += "</div><br/></div>";
						
						toggle_private_btn();
						
					} else if (item[1] == "control") {
						// control buttons
						// edit and delete buttons for tasks
						if (item[5] == "editdelete") {
							var item = '<h3 style="display:inline;"><a href="#">'+groupname+'</a></h3>';
							item += '<div style="display:inline; float:right; padding-top:5px; right:10px; position:absolute;">';
							item += '<img style="padding:2px; height:19px;" src="/asset/icons/sticker/24x24/edit_item.png" class="btn primary" onclick="$(\'.opl_item_readonly\').hide(); $(\'.opl_item_edit\').show(); $(\'#olk_rightform_submit_button\').show(); loadautocompletes(); ">';
							item += '&nbsp;&nbsp;<div style="display:inline; padding-left:10px; ">';
							item += '<img style="padding:2px; height:19px;" src="/asset/icons/sticker/24x24/trash.png" class="btn danger" onclick=\'olk_rightform_delete(objecttype, objectid);\' ">';
							item += '</div></div>';
						} else if (item[5] == "") {
							var item = '<h3 style="display:inline;"><a href="#">'+groupname+'</a></h3>';
						}

						$('#olk-details #indepth').html(item);
					} else if (item[1] == "objecttype" || item[1] == "objectid") {
						
					
					} else if (item[1] == "groupid") {
						
					} else if (item[1] == "event type") {
						if (objecttype == "feed") 
						{
							rightcontent += "<div id='"+item[1]+"_readonly' class='opl_item_readonly' style='display: inline;'><b>"+item[1]+"</b> "+item[5]+" <br/><br/></div> ";
						}
					} else {
						if (item[3] == "autocomplete")
						{
							rightcontent += "<div id='"+item[1]+"_readonly' class='opl_item_readonly' style='display: inline;'></div> ";
						} else {
							rightcontent += "<div id='"+item[1]+"_readonly' class='opl_item_readonly' style='display: inline; '><b>"+item[1]+"</b> "+item[5]+" </div>";
						}
						rightcontent += "<div id='"+item[1]+"_edit' class='opl_item_edit' style='display: none; '>";
						if (item[1] == "due")
							rightcontent += "<br/><br/>";
						rightcontent += "<div class='input-prepend'>";
						rightcontent += "<label class='add-on' style='width:80px; float: left;'>&nbsp;<font color='black' style='float: left; padding-left: 5px;'>"+item[1]+"</font> &nbsp;</label>";
						rightcontent += "<input class='large' id='"+item[1].replace(' ', '')+"' name='"+item[1]+"' size='16' type='text' value='"+item[5]+"'> ";
						rightcontent += "</div></div><br />";
						
						//rightcontent += "<b>"+item[1]+"</b> "+item[5]+" <br /><br />";
					}
				}
			}
			
			
		}
	}

	rightcontent += "<br /><br /><input type='submit' class='btn primary' id='olk_rightform_submit_button' value='save' style='display: none;'></form>";

	$('#olk-details #avail-status').html(rightcontent);

	$('#olk-details').fadeIn();
	
	
	$('#due').datepicker({
		dateFormat: "mm/dd/y"
//		changeMonth: true,
//		changeYear: true
		
	});
	
	
	for (var i=0; i<model_backup.length; i++)
	{
		var itemt = model_backup[i];
		if (itemt[3] == "data")
		{
			if (itemt[1] == "groupid") {
				data_group_id = itemt[5];
				
				/*
				
				$("#priority").fcbkcomplete({
				        json_url: "/autocomplete/priority",
				        addontab: true,                   
				        maxitems: 1,
				        height: 5,
						firstselected: true,
				        cache: false,
						filter_case: false,
						filter_hide: false,
						newel: true
				    });

				$("#groupname").fcbkcomplete({
				        json_url: "/autocomplete/groups?id="+user_id,
				        addontab: true,                   
				        maxitems: 1,
				        height: 5,
						firstselected: true,
				        cache: false,
						filter_case: false,
						filter_hide: false,
						newel: true
				    });

				$("#member").fcbkcomplete({
				        json_url: "/autocomplete/members_in_thisusers_groups?id="+user_id,
				        addontab: true,                   
				        maxitems: 1,
				        height: 5,
						firstselected: true,
				        cache: false,
						filter_case: false,
						filter_hide: false,
						newel: true
				    });

				*/
				
				//groupname
				//member
				
				
			} else if (itemt[1] == "to_user_id") {
				data_to_user_id = itemt[5];
			}
		}
	}
	
	
	//$("priority").trigger("addItem",[{"title": "test", "value": "test"}]);
	//groupname
	//member
	
	
	//$('#listings').width('640px');
	
//	minPane1(dashboard);

//	document.getElementById('modalrightpane').setAttribute('class', 'modalrightpane hide fade in');
//	$('#modalrightpane').fadeIn('fast');
}

function toggle_private_btn()
{
	$("#private_btn").removeClass("danger");
	$("#private_btn").removeClass("success");
	$("#private_btn").removeClass("primary");

	if ($("#private_btn").val() == "yes")
	{
		$("#private_btn").addClass("primary");
		$("#private_btn").val("no");
		
//		$("#groupname_edit").show();
//		$("#member_edit").show();
	} else {
		$("#private_btn").addClass("danger");
		$("#private_btn").val("yes");
		
//		$("#groupname_edit").hide();
//		$("#member_edit").hide();
	}
}

function loadautocompletes() {
	//$("priority").trigger("addItem",[{"title": "test", "value": "test"}]);
	//groupname
	//member
	
    /*
	$("#priority").autocomplete({
			source: "/autocomplete/priority"
		});
	*/
	
	$("#priority").fcbkcomplete({
	        json_url: "/autocomplete/priority",
	        addontab: true,                   
	        maxitems: 1,
	        height: 5,
			firstselected: true,
	        cache: false,
			filter_case: false,
			filter_hide: false,
			newel: true
	    });
	
	$("#groupname").fcbkcomplete({
	        json_url: "/autocomplete/groups?id="+user_id,
	        addontab: true,                   
	        maxitems: 1,
	        height: 5,
			firstselected: true,
	        cache: false,
			filter_case: false,
			filter_hide: false,
			newel: true
	    });
	
	if (data_group_id != "")
	{
		$.get("/autocomplete/groups?id="+user_id+"&groupid="+data_group_id, function(data) {
			if (data != "") 
			{
				$("#groupname").trigger("addItem",[{"title": ""+data[0]['value']+"", "value": ""+data_group_id+""}]);
			}
		});
	}
	
	$("#member").fcbkcomplete({
	        json_url: "/autocomplete/members_in_thisusers_groups?id="+user_id,
	        addontab: true,                   
	        maxitems: 1,
	        height: 5,
			firstselected: true,
	        cache: false,
			filter_case: false,
			filter_hide: false,
			newel: true
	    });
	
	if (data_to_user_id != "")
	{
		$.get("/autocomplete/members_in_thisusers_groups?id="+user_id+"&userid="+data_to_user_id, function(data) {
			if (data != "") 
			{
				$("#member").trigger("addItem",[{"title": ""+data[0]['value']+"", "value": ""+data_to_user_id+""}]);
			}
		});
	}
	
	$('.input-prepend .holder').css("clear","none");
	
	toggle_private_btn();
	toggle_private_btn();
	
	
	/*
	a = $('#priority .selected')
	a.each(function(index) {
	    alert($(this).text() + ': ' + $(this).val());
	});
	*/
	
}

function maxPane1(context) {
	if (context == "Dashboard" || context == 1)
	{
		if (document.getElementById('pane1'))
			document.getElementById('pane1').style.width = '1000px';
		if (document.getElementById('pane1content'))
			document.getElementById('pane1content').style.width = '1000px';
		if (document.getElementById('toolbar'))
			document.getElementById('toolbar').style.width = '990px';

		if (document.getElementById('dashboard_left')) 
			document.getElementById('dashboard_left').style.width = '700px';
		if (document.getElementById('dashboard_right'))	
			document.getElementById('dashboard_right').style.display = "block";
	} else {
		if (document.getElementById('pane1'))
			document.getElementById('pane1').style.width = '1000px';
		if (document.getElementById('pane1content'))
			document.getElementById('pane1content').style.width = '1000px';
		if (document.getElementById('toolbar'))
			document.getElementById('toolbar').style.width = '990px';
	}
}

function minPane1(context) {
	if (context == "Dashboard" || context == 1)
	{
		if (document.getElementById('pane1'))
			document.getElementById('pane1').style.width = '500px';
		if (document.getElementById('pane1content'))
			document.getElementById('pane1content').style.width = '500px';
		if (document.getElementById('toolbar'))
			document.getElementById('toolbar').style.width = '490px';

		if (document.getElementById('dashboard_left')) 
			document.getElementById('dashboard_left').style.width = '500px';
		if (document.getElementById('dashboard_right'))	
			document.getElementById('dashboard_right').style.display = "none";
	} else {
		if (document.getElementById('pane1'))
			document.getElementById('pane1').style.width = '500px';
		if (document.getElementById('pane1content'))
			document.getElementById('pane1content').style.width = '500px';
		if (document.getElementById('toolbar'))
			document.getElementById('toolbar').style.width = '490px';
	}
}

function randomString() {
	var chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXTZabcdefghiklmnopqrstuvwxyz";
	var string_length = 16;
	var randomstring = '';
	for (var i=0; i<string_length; i++) {
		var rnum = Math.floor(Math.random() * chars.length);
		randomstring += chars.substring(rnum,rnum+1);
	}
	return randomstring;
}

function getUserCards(id) {
	document.getElementById('cardslistchoose').innerHTML = "";

	var resultCard = '<div class="input">';
	var gotcards = 0;
	$.get('/charge/getCustomerCards?id='+id+'&other='+randomString()+'', function(data) {
		for (var card in data) {
			gotcards = 1;
			var cType = data[card]['type'];
		
			resultCard += "<input class='existingcard' onChange='hidenewbillingcard()' onClick='hidenewbillingcard()' onSelect='hidenewbillingcard()' type='radio' name='existingcard' id='cardchoose' value='"+data[card]['unique']+"'> ";
//			resultCard += "<img src='/asset/icons/creditcards/"+cType.toLowerCase()+".png' height='25'>";
			resultCard += "<b>"+cType.toLowerCase()+"</b>";
			resultCard += " "+data[card]['last4']+" &nbsp;";
			resultCard += " ";
		
			/*
			"<a href='#' id='"+data[card]['id']+"|" +data[card]['unique']+"' class='btn'>";
			resultCard += "<img src='/asset/icons/creditcards/"+cType.toLowerCase()+".png' height='24'>";
			resultCard += " ("+data[card]['last4']+")";
			resultCard += "</a>";
			*/
		}

		if (gotcards == 0) {
			resultCard += "";
		}
		//resultCard += "<input onChange='shownewbillingcard()' onClick='shownewbillingcard()' onSelect='shownewbillingcard()' type='radio' name='cardchoose' id='newcard'> <button id='addnewbillingcontactbtn' class='btn primary' onclick='shownewbillingcard(); return false;'>new card</button></div>";
		resultCard += "<input onChange='shownewbillingcard()' onClick='shownewbillingcard()' onSelect='shownewbillingcard()' type='radio' name='newcard' id='cardchoose' value='new'> <b><font color='green'>new card</font></b></div>";

		$('#addnewbillingcontactbtn').removeClass('input');

		var temp1 = document.getElementById('cardslistchoose').innerHTML;
		document.getElementById('cardslistchoose').innerHTML = temp1 + resultCard;

	});


}

function shownewbillingcard() {
	$('#newbillingcontact').fadeIn('fast');
	$("input[name=existingcard]").attr('checked', false);
	$("input[name=newcard]").attr('checked', true);
	
	paymentid = 0;
	dovalidate(paymentid);
}

function hidenewbillingcard() {
	$("input[name=newcard]").attr('checked', false);
	paymentcusid = $("#cardchoose:checked").val()
	paymentid = 1;
	$('#newbillingcontact').fadeOut('fast');
	removerequirementsbillingdetails();
}

function removerequirementsbillingdetails() {
	$("#cardNumber").removeClass("required");
	$("#cardNumber").removeClass("error");

	$("#cardCVC").removeClass("required");
	$("#cardCVC").removeClass("error");

	$("#cardExpiry").removeClass("required");
	$("#cardExpiry").removeClass("error");

	$("#card-cvc").removeClass("required");
	$("#card-cvc").removeClass("error");

	$("#card-number").removeClass("required");
	$("#card-number").removeClass("error");

	$("#address-line1").removeClass("required");
	$("#address-line1").removeClass("error");
	
	$("#address-zip").removeClass("required");
	$("#address-zip").removeClass("error");

	$("#card-expiry-year").removeClass("required");
	$("#card-expiry-year").removeClass("error");
	
	$("#name").removeClass("required");
	$("#name").removeClass("error");
	
	$("#email").removeClass("required");
	$("#email").removeClass("error");
	
	var settings = $('#example-form').validate().settings;
	delete settings.rules;
	/*
	delete settings.rules.address-line1;
	delete settings.rules.address-zip;
	delete settings.rules.card-expiry-year;
	delete settings.rules.card-cvc;
	delete settings.rules.card-number;
	*/
}



