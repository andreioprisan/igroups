<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>igrou.ps</title>
    <meta name="description" content="">
    <meta name="author" content="">
	<link type="text/css" rel="stylesheet" href="http://openvpx/assets/c/site-1011.css" />		
	<link type="text/css" rel="stylesheet" href="http://openvpx/assets/themes/mandala/style.css" />
	<!--[if IE 7]>
		<link type="text/css" rel="stylesheet" href="http://openvpx/assets/c/ie.css" />
	<![endif]-->

    <!-- Le HTML5 shim, for IE6-8 support of HTML elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Le styles -->
    <link href="/asset/css/bootstrap.css" rel="stylesheet">

	<link href="/asset/css/dp_calendar.css" type="text/css" rel="stylesheet">
	<link href="/asset/css/jquery.ui.all.css" type="text/css" rel="stylesheet">
	


    <style type="text/css">
      /* Override some defaults */
      html, body {
        background-color: #eee;
      }
      body {
        padding-top: 40px; /* 40px to make the container go all the way to the bottom of the topbar */
      }
      .container > footer p {
        text-align: center; /* center align it with the container */
      }
      .container {
        width: 90%; /* downsize our container to make the content feel a bit tighter and more cohesive. NOTE: this removes two full columns from the grid, meaning you only go to 14 columns and not 16. */
      }

.container .brand {
	background-color: red;
}

      /* The white background content wrapper */
      .content {
        background-color: #fff;
        padding: 20px;
        margin: 0 -20px; /* negative indent the amount of the padding to maintain the grid system */
        -webkit-border-radius: 0 0 6px 6px;
           -moz-border-radius: 0 0 6px 6px;
                border-radius: 0 0 6px 6px;
        -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.15);
           -moz-box-shadow: 0 1px 2px rgba(0,0,0,.15);
                box-shadow: 0 1px 2px rgba(0,0,0,.15);
      }

      /* Page header tweaks */
      .page-header {
        background-color: #f5f5f5;
        padding: 20px 20px 10px;
        margin: -20px -20px 20px;
      }

      /* Styles you shouldn't keep as they are for displaying this base example only */
      .content .span10,
      .content .span4 {
        min-height: 500px;
      }
      /* Give a quick and non-cross-browser friendly divider */
      .content .span4 {
        margin-left: 0;
        padding-left: 19px;
        border-left: 1px solid #eee;
      }

      .topbar .btn {
        border: 0;
      }

	.topbar div > ul.mid-nav, .nav.mid-nav {
		font-color:black;

	}


	.topbar div > ul.secondary-nav, .nav.secondary-nav {
	  float: right;
	  margin-left: 0px;
	  margin-right: -20px;
	background-color: #5E9DC8;
	font-color:black;
	
	}
	
	
	.label {
		width:300px;
	}
	
	.label a {
		color: white;
		text-decoration: none;
	}
	
	.label a:hover {
		color: black;
		text-decoration: none;
	}

	/* Footer
	-------------------------------------------------- */
	.footer {
	  background-color: #eee;
	  min-width: 940px;
	  padding: 30px 0;
	  text-shadow: 0 1px 0 #fff;
	  border-top: 1px solid #e5e5e5;
	  -webkit-box-shadow: inset 0 5px 15px rgba(0,0,0,.025);
	     -moz-box-shadow: inset 0 5px 15px rgba(0,0,0,.025);
	/*          box-shadow: inset 0 5px 15px rgba(0,0,0,.025);
	*/}
	.footer p {
	  color: #555;
	}

    </style>

	<script src="/asset/js/jquery.min.1.6.4.js"></script>
	<script type="text/javascript" src="/asset/css/jquery.ui.core.js"></script> 
	<script type="text/javascript" src="/asset/css/jquery.ui.position.js"></script>
	<script type="text/javascript" src="/asset/css/jquery.ui.datepicker.js"></script>
	<script type="text/javascript" src="/asset/css/date.js"></script>
	<script type="text/javascript" src="/asset/css/jquery.dp_calendar.max.js"></script>

	<script src="/asset/js/bootstrap-modal.js"></script>
	<script src="/asset/js/bootstrap-dropdown.js"></script>
	<script src="/asset/js/bootstrap-twipsy.js"></script>
	<script src="/asset/js/bootstrap-scrollspy.js"></script>
	<script src="/asset/js/application.js"></script>

	<script type="text/javascript">
	$(document).ready(function(){  

		var events_array = new Array();
		//events_array[] = [ DATE, TITLE, DESCRIPTION, PRIORITY ];
		events_array[0] = [ new Date(2011,07, 20, 13, 50), "Title 1", "Description 1", 1 ];
		events_array[1] = [ new Date(2011,07, 20, 14, 30), "Title 2", "Description 2", 3 ];
		events_array[2] = [ new Date(2011,07, 20, 10, 25), "Title 3", "Description 3", 2 ];
		events_array[3] = [ new Date(2011,07, 22, 10, 25), "Title 4", "Description 3", 3 ];

		events_array[4] = [ new Date(2011,08, 15, 13, 50), "Title 1", "Description 1", 1 ];
		events_array[5] = [ new Date(2011,08, 15, 14, 30), "Title 2", "Description 2", 3 ];
		events_array[6] = [ new Date(2011,08, 13, 10, 25), "Title 3", "Description 3", 2 ];
		events_array[7] = [ new Date(2011,08, 10, 10, 25), "Title 4", "Description 3", 3 ];

		events_array[8] = [ new Date(2011,09, 12, 13, 50), "Title 1", "Description 1", 1 ];
		events_array[9] = [ new Date(2011,09, 18, 14, 30), "Title 2", "Description 2", 3 ];
		events_array[10] = [ new Date(2011,09, 18, 10, 25), "Title 3", "Description 3", 2 ];
		events_array[11] = [ new Date(2011,09, 20, 10, 25), "Title 4", "Description 3", 3 ];

		$("#calendar").dp_calendar({
			events_array: events_array
		}); 
	});  
	</script>
	
    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="images/favicon.ico">
    <link rel="apple-touch-icon" href="images/apple-touch-icon.png">
    <link rel="apple-touch-icon" sizes="72x72" href="images/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="114x114" href="images/apple-touch-icon-114x114.png">
  </head>

  <body>
    <div class="topbar">
      <div class="fill">
        <div class="container">
          <a class="brand" href="/igroupsc/?page=home&id=1"><!--<img src="/asset/images/groups.png" style="float:left;">-->igrou.ps</a>
          <ul class="nav">
			<li class="active"><a href="#">feed</a></li>
			<li class="dropdown">
				<a href="#" class="dropdown-toggle"><font color="red">2</font> groups</a>
				<ul class="dropdown-menu">
					<li><a href="/igroupsc/?page=group&id=1">group 1</a></li>
					<li><a href="#">group 2</a></li>
					<li class="divider"></li>
					<li><a href="#">add new group</a></li>
				</ul>
			</li>
            <li><a href="#allserviceplans"><font color="red">2</font> inbox</a></li>
          </ul>
		  <ul class="mid-nav">
			<li>
				<form class="pull-left" action=""  style="padding-left: 20px;padding-right: 20px;"><input type="text" placeholder="Search"></form>
			</li>
		  </ul>
		  <ul class="secondary-nav">
			<li class="dropdown" style="float: right;">
				<a href="#" class="dropdown-toggle">User Name</a>
				<ul class="dropdown-menu">
					<li><a href="#">Profile</a></li>
					<li><a href="#">Password</a></li>
					<li class="divider"></li>
					<li><a href="#">Sign Out</a></li>
				</ul>
			</li>
		  </ul>
        </div>
      </div>
    </div>
	<div class="container">
		<div class="content">
				<?php if (isset($header)) {?>
			<div class="page-header">
				<h1><?= $header['title']?> <small><?= $header['description']?></small></h1>
				<div class="alert-message <?= $header['alert-type']?>">
				  <p><?= $header['alert-message']?></p>
				</div>
			</div>
				<?php } ?>
			<div class="row">
				


						<?php } else if ($module_name == "calendar") {
								if ($modules_pos == "right" && $col_id % 2 == 1) { 
									//$this->load->view('layout/content/modules/calendar');
									
							
							 	} else { $remove_mod = false; } ?>
						<?php  } else { ?>
								<h2><?= $module_name ?></h2>
								
						<?php } ?>
						<?php } ?>
					<?php 
						if ($remove_mod) 
						{
							unset($modules[$module_name]);
						}
					 } ?>
				</div>
				<?php } ?>
			</div>


			<!--
			<p>
			<div class="input">
			<div class="input-prepend">
			<span class="add-on">search</span>
			<input class="medium" id="prependedInput" name="prependedInput" size="16" type="text">
			</div>
			</div>

			<br>
			<div class="input">
			<div class="input-append">
			<input class="reallysmall" type="text" style="width:18px;" value=" 2" style="background-color:red;">
			<label class="add-on" style="color:red;">messages</label>
			</div>
			</div>
			</p>
			-->


		</div> <!-- /content -->
		<?php echo $footer; ?>
	</div> <!-- /container -->
</body>
</html>
