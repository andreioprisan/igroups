<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" debug="true">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>Jeditable Edit In Place Demo</title>
	<link type="text/css" rel="stylesheet" href="/asset/css/new/fonts.css" />
	<link type="text/css" rel="stylesheet" href="/asset/css/bootstrap-1.4/bootstrap.css" />
	<link type="text/css" rel="stylesheet" href="/asset/css/site1.css" />
	<link type="text/css" rel="stylesheet" href="/asset/css/style1.css" />
	<link type="text/css" rel="stylesheet" href="/asset/css/jquery.ui.all.css" />
	<link type="text/css" rel="stylesheet" href="/asset/css/dp_calendar.css" />
	<link type="text/css" rel="stylesheet" href="/asset/css/new/theme_azure.css" />
	<link type="text/css" rel="stylesheet" href="/asset/css/new/ribbons.css" />
	<link type="text/css" rel="stylesheet" href="/asset/css/new/uploadbar.css" />
	<link type="text/css" rel="stylesheet" href="/asset/css/new/theme_azure_sidebar.css" />
	<!-- Le HTML5 shim, for IE6-8 support of HTML elements -->
	    <!--[if lt IE 9]>
	      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	    <![endif]-->
	<!--	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js" type="text/javascript" charset="utf-8"></script>-->
	
	<script type="text/javascript" src="/asset/js/jquery.min.1.6.4.js"></script>
	<script type="text/javascript" src="/asset/js/jquery.ui.core.js"></script>
	<script type="text/javascript" src="/asset/js/jquery.ui.position.js"></script>
	<script type="text/javascript" src="/asset/js/jquery.ui.datepicker.js"></script>
	<script type="text/javascript" src="/asset/js/date.js"></script>
	<script type="text/javascript" src="/asset/js/jquery.dp_calendar.min.js"></script>
	<script type="text/javascript" src="/asset/js/bootstrap-1.4/bootstrap-modal.js"></script>
	<script type="text/javascript" src="/asset/js/bootstrap-1.4/bootstrap-dropdown.js"></script>
	<script type="text/javascript" src="/asset/js/bootstrap-1.4/bootstrap-tabs.js"></script>
	<script type="text/javascript" src="/asset/js/bootstrap-1.4/bootstrap-twipsy.js"></script>
	<script type="text/javascript" src="/asset/js/bootstrap-1.4/bootstrap-popover.js"></script>
	<script type="text/javascript" src="/asset/js/bootstrap-1.4/bootstrap-alerts.js"></script>
	<script type="text/javascript" src="/asset/js/bootstrap-1.4/bootstrap-scrollspy.js"></script>
	<script type="text/javascript" src="/asset/js/bootstrap-1.4/bootstrap-buttons.js"></script>
	<script type="text/javascript" src="/asset/js/application.js"></script>
	<script type="text/javascript" src="/asset/js/new/sha1.js"></script>
	<script type="text/javascript" src="/asset/js/new/members.js"></script>
	<script type="text/javascript" src="/asset/js/new/dynamic.js"></script>
	<script type="text/javascript" src="/asset/js/plupload/plupload.js"></script>
	<script type="text/javascript" src="/asset/js/plupload/plupload.gears.js"></script>
	<script type="text/javascript" src="/asset/js/plupload/plupload.silverlight.js"></script>
	<script type="text/javascript" src="/asset/js/plupload/plupload.flash.js"></script>
	<script type="text/javascript" src="/asset/js/plupload/plupload.browserplus.js"></script>
	<script type="text/javascript" src="/asset/js/plupload/plupload.html4.js"></script>
	<script type="text/javascript" src="/asset/js/plupload/plupload.html5.js"></script>
	<script type="text/javascript" src="/asset/js/new/file.js"></script>
	<script type="text/javascript" src="/asset/js/new/calendar.js"></script>
	<script type="text/javascript" src="/asset/js/new/jquery.jeditable.mini.js"></script>
	<script type="text/javascript">
		// global params
		OpenVBX = {home: null, assets: null, client_capability: null};
		OpenVBX.home = '<?php echo preg_replace("|/$|", "", site_url('')); ?>';
		OpenVBX.assets = '<?php echo site_url('');?>';
	</script>
	
	<script type="text/javascript">
	$(function() {
		$('.edit').editable('http://www.example.com/save.php');

		var events_array = new Array();
		//events_array[] = [ DATE, TITLE, DESCRIPTION, PRIORITY ];
		events_array[0] = [new Date(2011, 07, 20, 13, 50), "Title 1", "Description 1", 1];
		events_array[1] = [new Date(2011, 07, 20, 14, 30), "Title 2", "Description 2", 3];
		events_array[2] = [new Date(2011, 07, 20, 10, 25), "Title 3", "Description 3", 2];
		events_array[3] = [new Date(2011, 07, 22, 10, 25), "Title 4", "Description 3", 3];

		events_array[4] = [new Date(2011, 08, 15, 13, 50), "Title 1", "Description 1", 1];
		events_array[5] = [new Date(2011, 08, 15, 14, 30), "Title 2", "Description 2", 3];
		events_array[6] = [new Date(2011, 08, 13, 10, 25), "Title 3", "Description 3", 2];
		events_array[7] = [new Date(2011, 08, 10, 10, 25), "Title 4", "Description 3", 3];

		events_array[8] = [new Date(2011, 09, 12, 13, 50), "Title 1", "Description 1", 1];
		events_array[9] = [new Date(2011, 09, 18, 14, 30), "Title 2", "Description 2", 3];
		events_array[10] = [new Date(2011, 09, 18, 10, 25), "Title 3", "Description 3", 2];
		events_array[11] = [new Date(2011, 09, 20, 10, 25), "Title 4", "Description 3", 3];


		$("#calendar").dp_calendar({
		    events_array: events_array
		});
		
	});

	$(document).ready(function() {
		//$('#twipsy').twipsy('show');
	
	
	});

	$(function() {
        
	  $(".editable_select").editable("http://www.appelsiini.net/projects/jeditable/php/save.php", { 
	    indicator : '<img src="img/indicator.gif">',
	    data   : "{'Lorem ipsum':'Lorem ipsum','Ipsum dolor':'Ipsum dolor','Dolor sit':'Dolor sit'}",
	    type   : "select",
	    submit : "OK",
	    style  : "inherit",
	    submitdata : function() {
	      return {id : 2};
	    }
	  });
	  $(".editable_select_json").editable("http://www.appelsiini.net/projects/jeditable/php/save.php", { 
	    indicator : '<img src="img/indicator.gif">',
	    loadurl : "http://www.appelsiini.net/projects/jeditable/php/json.php",
	    type   : "select",
	    submit : "OK",
	    style  : "inherit"
	  });
	  $(".editable_textarea").editable("http://www.appelsiini.net/projects/jeditable/php/save.php", { 
	      indicator : "<img src='img/indicator.gif'>",
	      type   : 'textarea',
	      submitdata: { _method: "put" },
	      select : true,
	      submit : 'OK',
	      cancel : 'cancel',
	      cssclass : "editable"
	  });
	  $(".editable_textile").editable("http://www.appelsiini.net/projects/jeditable/php/save.php?renderer=textile", { 
	      indicator : "<img src='img/indicator.gif'>",
	      loadurl   : "http://www.appelsiini.net/projects/jeditable/php/load.php",
	      type      : "textarea",
	      submit    : "OK",
	      cancel    : "Cancel",
	      tooltip   : "Click to edit..."
	  });
  
	  $(".click").editable("http://www.appelsiini.net/projects/jeditable/php/echo.php", { 
	      indicator : "<img src='img/indicator.gif'>",
	      tooltip   : "Click to edit...",
	      style  : "inherit"
	  });
	  $(".dblclick").editable("http://www.appelsiini.net/projects/jeditable/php/echo.php", { 
	      indicator : "<img src='img/indicator.gif'>",
	      tooltip   : "Doubleclick to edit...",
	      event     : "dblclick",
	      style  : "inherit"
	  });
	  $(".mouseover").editable("http://www.appelsiini.net/projects/jeditable/php/echo.php", { 
	      indicator : "<img src='img/indicator.gif'>",
	      tooltip   : "Move mouseover to edit...",
	      event     : "mouseover",
	      style  : "inherit"
	  });
  
	  /* Should not cause error. */
	  $("#nosuch").editable("http://www.appelsiini.net/projects/jeditable/php/echo.php", { 
	      indicator : "<img src='img/indicator.gif'>",
	      type   : 'textarea',
	      submit : 'OK'
	  });

	});

	</script>
	

	<style type="text/css">


	.editable input[type=submit] {
	  color: #F00;
	  font-weight: bold;
	}
	.editable input[type=button] {
	  color: #0F0;
	  font-weight: bold;
	}


	</style>

</head>

<body>
  <div id="wrap"> 
    <div id="content">
      
    <div class="entry">
            
    <p>You might also want to check <a href="custom.html">custom inputs demo</a>.

    <h2>Normal textarea</h2>
    
    <p class="edit" id="paragraph_1">Ghyuisadasd</p>

    <h2>Inlined select</h2>
    <p><b class="editable_select" id="select_1" style="display: inline"> Dolor sit</b> dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh <b class="editable_select_json" id="select_2" style="display: inline"> G</b> euismod tincidunt ut laoreet dolore magna aliquam erat volutp</p>    

    <h2>Textile renderer</h2>
    <div class="editable_textile" id="paragraph_2">	<p>öjhjkhlhlhj</p></div>

    <h2>Different events</h2>
    <p>
      <b class="click" style="display: inline">Click me if you dare!</b></> or maybe you should 
      <b class="dblclick" style="display: inline">doubleclick</b> instead? Really lazy people can just
      <b class="mouseover" style="display: inline">mouseover me</b>...
    </p>

	<div id="calendar"></div>
    
    </div>
<!--
	<script type="text/javascript" src="/asset/js/new/membersgroups_prereq.js"></script>
	<script type="text/javascript" src="/asset/js/new/membersgroups_manager.js"></script>
-->
    <div id="sidebar">

  </div>
  
  <div id="footer">
	
  </div>

</body>
</html>