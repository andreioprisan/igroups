
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Login </title>
	<meta name="description" content="">
	<meta name="author" content="">
	<style type="text/css">

	@font-face {
	  font-family: 'Open Sans';
	  font-style: normal;
	  font-weight: 400;
	  src: local('Open Sans'), local('OpenSans'), url('/asset/images/cJZKeOuBrn4kERxqtaUH3bO3LdcAZYWl9Si6vvxL-qU.woff') format('woff');
	}
	@font-face {
	  font-family: 'Arimo';
	  font-style: normal;
	  font-weight: normal;
	  src: local('Arimo'), url('/asset/images/ZS0wkeOZuckNE3boyLYNt6CWcynf_cDxXwCLxiixG1c.woff') format('woff');
	}
	@font-face {
	  font-family: 'Actor';
	  font-style: normal;
	  font-weight: normal;
	  src: local('Actor Regular'), local('Actor-Regular'), url('/asset/images/SqA9OdmswJX8b4TrqlN76KCWcynf_cDxXwCLxiixG1c.woff') format('woff');
	}
	@font-face {
	  font-family: 'Muli';
	  font-style: normal;
	  font-weight: 300;
	  src: local('Muli Light'), local('Muli-Light'), url('/asset/images/TgrecWq39GVsTOFonFwGXQLUuEpTyoUstqEm5AMlJo4.woff') format('woff');
	}
	@font-face {
	  font-family: 'Cabin';
	  font-style: normal;
	  font-weight: 400;
	  src: local('Cabin Regular'), local('Cabin-Regular'), url('/asset/images/kJXt72Gt1LyFMZcEKAAvlKCWcynf_cDxXwCLxiixG1c.woff') format('woff');
	}
	@font-face {
	  font-family: 'Open Sans';
	  font-style: normal;
	  font-weight: 300;
	  src: local('Open Sans Light'), local('OpenSans-Light'), url('/asset/images/DXI1ORHCpsQm3Vp6mXoaTaRDOzjiPcYnFooOUGCOsRk.woff') format('woff');
	}
	@font-face {
	  font-family: 'Open Sans Cond Light';
	  font-style: normal;
	  font-weight: 300;
	  src: local('Open Sans Cond Light'), local('OpenSans-CondensedLight'), url('/asset/images/calfont.woff') format('woff');
	}

    </style>
	<!-- Le HTML5 shim, for IE6-8 support of HTML elements -->
	<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	
	<link type="text/css" rel="stylesheet" href="/asset/css/bootstrap-1.4/bootstrap.css" />
	<link type="text/css" rel="stylesheet" href="/asset/css/dp_calendar.css" />
	<link type="text/css" rel="stylesheet" href="/asset/css/jquery.ui.all.css" />
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
		align: left;
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

.navbar .btn {
	border: 0;
}

.navbar div > ul.mid-nav, .nav.mid-nav {
	font-color: black;
}


.navbar div > ul.secondary-nav, .nav.secondary-nav {
	float: right;
	margin-left: 0px;
	margin-right: -20px;
	background-color: #0064CD;
	font-color: black;
}


.label {
	width: 300px;
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
	/* box-shadow: inset 0 5px 15px rgba(0,0,0,.025);
	*/
}
.footer p {
	color: #555;
}

.inner .content {
	margin: 0px 0px
}

</style>
<script type="text/javascript" src="/asset/js/jquery.min.1.6.4.js"></script><script type="text/javascript" src="/asset/css/jquery.ui.core.js"></script><script type="text/javascript" src="/asset/css/jquery.ui.position.js"></script><script type="text/javascript" src="/asset/css/jquery.ui.datepicker.js"></script><script type="text/javascript" src="/asset/css/date.js"></script><script type="text/javascript" src="/asset/css/jquery.dp_calendar.max.js"></script><script type="text/javascript" src="/asset/js/bootstrap-modal.js"></script><script type="text/javascript" src="/asset/js/bootstrap-dropdown.js"></script><script type="text/javascript" src="/asset/js/bootstrap-twipsy.js"></script><script type="text/javascript" src="/asset/js/bootstrap-scrollspy.js"></script><script type="text/javascript" src="/asset/js/application.js"></script>
</head>

<body>
	<div class="topbar">
		<div class="fill">
			<div class="container">
				<a class="brand" href="/igroupsc/"><!--<img src="/asset/images/groups.png" style="float:left;">-->igrou.ps</a>

			</div>
		</div>
	</div> <div class="container">
		<div class="content">
			<div class="page-header">
				<h1><img src="/asset/img/calendar.png" width="38" style="margin: 0px 18px -9px 10px"> <font color=red>task management</font> <img src="/asset/img/wireframe.png" width="38" style="margin: 0px 18px -9px 18px"> <font color="#0064CD">group collaboration</font> <img src="/asset/img/board.png" width="38" style="margin: 0px 18px -9px 18px"> <font color="purple">social</font> <img src="/asset/img/pad.png" width="38" style="margin: 0px 18px -9px 18px"> redefined<small></small></h1>
			</div>

			<div class="row">
				<div class="span8">
					<br />
					<br />
					<form>
					<fieldset>
					          <legend>sign in to your account</legend>
					          <div class="clearfix">
					            <div class="input">
					              <div class="input-prepend">
					                <span class="add-on">&nbsp;<font color="black">email</font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span>
					                <input class="large" id="prependedInput" name="prependedInput" size="16" type="text">
					              </div>
					            </div></form>
					          </div><!-- /clearfix -->
					          <div class="clearfix">
					            <label for="prependedInput2"></label>
					            <div class="input">
					              <div class="input-prepend">
					                <label class="add-on">&nbsp;<font color="black">password</font> &nbsp;</label>
					                <input class="large" id="prependedInput2" name="prependedInput2" size="16" type="password"> 
					              </div>
					            </div>
					          </div><!-- /clearfix -->
							<div class="clearfix">
					            <label for="signin"></label>
					            <div class="input">
					              <div class="input-prepend">
									&nbsp;&nbsp;<button class="medium btn primary" id="signin" name="signin" size="4">sign in</button> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="">Forgot your password?</a><br/><br/><br/>
					              </div>
					            </div>
					          </div><!-- /clearfix -->
					
					          <div class="clearfix">
					            <div class="input">
					              <div class="input-append">
									<form action="<?php echo 'https://'.$_SERVER['HTTP_HOST'].'/facebook_auth/login';?>" method="post">
					                <img src="/asset/img/facebook_32.png"><input class="medium btn" id="submit" name="submit" size="16" type="submit" value="Sign in with Facebook">
									</form>
					              </div>
					            </div>
					          </div><!-- /clearfix -->

					        </fieldset>
					


				</div>
				<div class="span8" align="left">
					<br />
					<br />
					<form>
					<fieldset>
					          <legend>sign up today!</legend>
					         
					          <div class="clearfix">
					            <label for="prependedInput"></label>
					            <div class="input">
					              <div class="input-prepend">
					                <span class="add-on">&nbsp;<font color="black">name</font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span>
					                <input class="large" id="prependedInput" name="prependedInput" size="16" type="text">
					              </div>
					            </div></form>
					          </div><!-- /clearfix -->

							<div class="clearfix">
					            <label for="prependedInput"></label>
					            <div class="input">
					              <div class="input-prepend">
					                <span class="add-on">&nbsp;<font color="black">phone</font> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span>
					                <input class="large" id="prependedInput" name="prependedInput" size="16" type="text">
					              </div>
					            </div>
					          </div><!-- /clearfix -->


					          <div class="clearfix">
					            <label for="prependedInput"></label>
					            <div class="input">
					              <div class="input-prepend">
					                <span class="add-on">&nbsp;<font color="black">email</font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span>
					                <input class="large" id="prependedInput" name="prependedInput" size="16" type="text">
					              </div>
					            </div></form>
					          </div><!-- /clearfix -->

							 
					          <div class="clearfix">
					            <label for="prependedInput2"></label>
					            <div class="input">
					              <div class="input-prepend">
					                <label class="add-on">&nbsp;<font color="black">password</font> &nbsp;</label>
					                <input class="large" id="prependedInput2" name="prependedInput2" size="16" type="password"> 
					              </div>
					            </div>
					          </div><!-- /clearfix -->

					          <div class="clearfix">
					            <label for="prependedInput2"></label>
					            <div class="input">
					              <div class="input-prepend">
					                <label class="add-on">&nbsp;<font color="black">password</font> &nbsp;</label>
					                <input class="large" id="prependedInput2" name="prependedInput2" size="16" type="password"> 
					              </div>
					            </div>
					          </div><!-- /clearfix -->


							<div class="clearfix">
					            <label for="signin"></label>
					            <div class="input">
					              <div class="input-prepend">
									&nbsp;<button class="medium btn primary" id="signin" name="signin" size="4">sign up</button> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="">Privacy Policy</a><br/><br/><br/>
					              </div>
					            </div>
					          </div><!-- /clearfix -->
					
					        </fieldset>

				</div>
			</div>
		</div> <!-- /content -->
	<footer></footer> 
	</div> <!-- /container -->
</body>
</html>