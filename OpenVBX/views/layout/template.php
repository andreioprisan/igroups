<?php if (isset($newlook)) { #echo $newlook; 
	}; ?>
<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<title>iGroups Phone System - <?php echo empty($title) ? ' ' : "$title " ?> <?php echo (isset($counts))? '('.$counts[0]->new.')' : '' ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<?php echo $_styles; ?>
	<?php foreach($css as $link): ?>
	<link type="text/css" rel="stylesheet" href="<?php echo ASSET_ROOT ?>/<?php echo $link ?>.css" />
	<?php endforeach; ?>
	<!--[if IE 7]>
		<link type="text/css" rel="stylesheet" href="<?php echo ASSET_ROOT ?>/c/ie.css" />
	<![endif]-->
	<?php 
	if (strstr($_SERVER['REQUEST_URI'], "dashboard")) { ?>
 	<script type="text/javascript" src="/assets/j/frameworks/jquery-1.6.2.min.js"></script>
	<script type="text/javascript" src="/assets/j/highcharts/highcharts.js"></script>
	<script type="text/javascript" src="/assets/j/highcharts/modules/exporting.js"></script>
	<?php 
	} ?>
</head>
<body id="merch" style="text-align:left;">
	<?php if (strstr($section, "/p/flowtest") || strstr($section, "/p/import") || strstr($section, "/p/export")) { 
	// thin look for plugin passthrough
	?>
		<?php $this->load->view('banners/bug-banners'); ?>
		<div id="doc3" class="<?php echo $layout ?>">
			<div id="wrapper" class="<?php echo $theme;?>-theme">
				<div id="bd">
					<?= $context_menu; ?>
					<div id="yui-main">
							<div class="<?php echo $layout_override ?> yui-b">
									<div id="vbx-main">
										<div class="vbx-content-banner info-banner hide">
											<a href="" class="close action"><span class="replace">Close</span></a>
											<div class="info-message">
												<h3>Duis quis justo libero</h3>
												<p>Nam egestas libero vitae metus iaculis at scelerisque nisi sollicitudin.</p>
											</div>
										</div><!-- .vbx-banner -->

									<?php echo $content ?>
									</div><!-- #vbx-main -->
							</div><!-- .yui-b -->
					</div><!-- #yui-main -->
				</div><!-- #bd -->
			</div><!-- #wrapper .theme -->
		</div><!-- #doc -->
		<div id="audio-player"></div> <!-- #audio-player -->
		<div title="Error Occurred" class="dialog error-dialog show">
			 <div class="error-window">
				 <p class="error-code">0</p>
				 <p class="error-message">An error occurred</p>
			 </div>
		</div>
		
	<?php } else { 
	// regular flow
	?>
	<div id="background"></div>
	<div class="main-view">
		<div id="application">
			<div class="small" id="header">
			</div>
			<div id="notification-view"></div>
			<div id="main-body" class="box">
				<div id="toolbar-view">
					<div class="toolbar-view">
						<div id="main-toolbar">
							<div class="inner">
								<div id="livemode-switch">
									<div class="switch-view">
										<img src="/assets/themes/bluelook/images/igroups.png" style="
										position: absolute;
										left: -58px;
										top: -17px;">
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div id="quicksearch-view">
					<div class="quicksearch-view2" style="position: absolute; top: 10px;left: 166px; z-index: 100;">
						<div class="navigation" style="padding-top:4px;">
							<ul class="global">
								<li>
									<button class="btn large twilio-call small" data-href="<?php echo site_url('messages/call') ?>" style="padding: 2px 15px 2px 15px;  height:20px;">Browser Phone</button>
									<a href="#"><button class="btn large client-button twilio-client small <?php if ($user_online == 1) { echo 'online success'; } else { echo 'offline danger'; } ?>" id="incomingcalls2browserphone" style="padding: 2px 15px 2px 15px; height:20px;"><?php if ($user_online == 1) { echo 'Accepting'; } else { echo 'Not Accepting'; } ?></button> Incoming Calls to Your Browser</a>

									
								</li>
							</ul>
						</div>
					</div>
					<div class="quicksearch-view">
						<div class="navigation" style="padding-top:4px;">
							<ul class="global">
								<li class="selected">
									<a href="/account">Your Account</a>
								</li>
								<li class="">
									<a href="/auth/logout">Logout</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
				
				<div class="wrap">
					<div id="welcome-box"></div>
					<div id="sidebar-view-gradient"></div>
					<div id="sidebar-view">
						<div class="sidebar-view" id="sidebar">
							<div class="gradient"></div>
							<?php

							$ci=& get_instance();
							$path = $ci->uri->uri_string();
							?>
							<?php if ($user->values['is_admin']) { ?>

							<h4>General</h4>
							<ul class="navigation side">
								<li class="dashboard <?php if (strstr($path, 'dashboard')) { echo "selected"; }?>">
									<a href="/dashboard/index"><span>Dashboard</span></a>
								</li>
								<?php if ($user->values['is_admin']) { ?>
								<li class="stats <?php if (strstr($path, 'calldetails')) { echo "selected"; }?>">
									<a href="/calldetails/index"><span>Call Details</span></a>
								</li>
								<?php } ?>
							</ul>
							
							<?php } ?>
							
							<h4>Messages</h4>
							<ul class="navigation side">
								<li class="messages <?php if (strstr($path, 'messages')) { echo "selected"; }?>">
									<a href="/messages"><span>Inbox</span></a>
								</li>
							</ul>

							<?php if ($user->values['is_admin']) { ?>

							<h4>Manage</h4>
							<ul class="navigation side">
								<li class="numbers <?php if (strstr($path, 'numbers')) { echo "selected"; }?>">
									<a href="/numbers"><span>Numbers</span></a>
								</li>
								<li class="devices <?php if (strstr($path, 'devices')) { echo "selected"; }?>">
									<a href="/devices"><span>Devices</span></a>
								</li>
								<li class="builder <?php if (strstr($path, 'flows')) { echo "selected"; }?>">
									<a href="/flows"><span>Builder</span></a>
								</li>
								<li class="schedule <?php if (strstr($path, 'outbound')) { echo "selected"; }?>">
									<a href="/p/outbound/schedule"><span>Scheduled Events</span></a>
								</li>
								<li class="polls <?php if (strstr($path, 'polls')) { echo "selected"; }?>">
									<a href="/p/polls"><span>Polls</span></a>
								</li>
								<li class="members <?php if (strstr($path, 'accounts')) { echo "selected"; }?>">
									<a href="/accounts"><span>Members</span></a>
								</li>
							</ul>
							
							<?php if ($user->values['id'] == "0") {?>
								
							<h4>Reports</h4>
							<ul class="navigation side"><!--
								<li class="usage">
									<a href="#usage"><span>Usage</span></a>
								</li>-->
								<li class="analytics <?php if (strstr($path, 'usage')) { echo "selected"; }?>">
									<a href="/usage"><span>Usage</span></a>
								</li>
							</ul>
							
							<h4>Settings</h4>
							<ul class="navigation side"><!--
								<li class="usage">
									<a href="#usage"><span>Usage</span></a>
								</li>-->
								<li class="analytics <?php if (strstr($path, 'settings')) { echo "selected"; }?>">
									<a href="/settings/site#theme"><span>Manage</span></a>
								</li>
							</ul>

							<?php if(!empty($plugin_menus)): ?>
							<?php foreach($plugin_menus as $name => $links): ?>
							<h4 class="vbx-nav-title"><?php echo $name ?></h3>
							<ul class="vbx-main-nav-items navigation side">
							<?php foreach($links as $link => $name): 
									$class = (isset($section) && $section == $link)? 'selected vbx-nav-item' :'vbx-nav-item' ?>
									<?php if(is_array($name)): ?>
										<?php foreach($name as $sub_id => $sub_name): ?>
											<li class="<?php echo $class ?>">
								                <a title="<?php echo $sub_name ?>" href="<?php echo site_url($link) ?>"><?php echo $sub_id + 1 ?>. <?php echo $sub_name?></a>
											</li>
										<?php endforeach;?>
									<?php else: ?>
									<li class="<?php echo $class ?>">
										<a title="<?php echo $name ?>" href="<?php echo site_url($link) ?>"><?php echo $name?></a>
									</li>
									<?php endif; ?>
							<?php endforeach; ?>
							</ul>
							<?php endforeach; ?>
							<?php endif; ?>
							
							<?php } ?>
							<?php } ?>
								
						</div>
					</div>
					<div id="main-content">
						<div id="section">
							<div class="dashboard-view">
								<div class="dashboard-content">
									
									<?php //var_dump($user->values);?>
									
									<?php $this->load->view('banners/bug-banners'); ?>
									<div id="doc3" class="<?php echo $layout ?>">
										<div id="wrapper" class="<?php echo $theme;?>-theme">
											<div id="bd">
												<?= $context_menu; ?>
												<div id="yui-main">
														<div class="<?php echo $layout_override ?> yui-b">
																<div id="vbx-main">
																	<div class="vbx-content-banner info-banner hide">
																		<a href="" class="close action"><span class="replace">Close</span></a>
																		<div class="info-message">
																			<h3>Duis quis justo libero</h3>
																			<p>Nam egestas libero vitae metus iaculis at scelerisque nisi sollicitudin.</p>
																		</div>
																	</div><!-- .vbx-banner -->

																<?php echo $content ?>
																</div><!-- #vbx-main -->
														</div><!-- .yui-b -->
												</div><!-- #yui-main -->
											</div><!-- #bd -->
										</div><!-- #wrapper .theme -->
									</div><!-- #doc -->

									<div id="audio-player"></div> <!-- #audio-player -->

									<div title="Error Occurred" class="dialog error-dialog show">
										 <div class="error-window">
											 <p class="error-code">0</p>
											 <p class="error-message">An error occurred</p>
										 </div>
									</div>


								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="box-shadow top"></div>
				<div class="box-shadow center"></div>
				<div class="box-shadow bottom"></div>
			</div>
			<div id="footer" class="box">
				
			
				<p>© iGroups, Inc. 2012</p>
				<ul><!--
					<li>
						<a href="/home/about">About</a>
					</li>
					<li>
						<a href="/home/help">FAQ</a>
					</li>
					<li>
						<a href="/home/help">Support</a>
					</li>-->
					<li>
						<a href="/home/tos">Terms of Service</a>
					</li>
					<li>
						<a href="/home/privacy">Privacy Policy</a>
					</li>
				</ul>
			</div>
		</div>
	</div>
	<?php } ?>
<!-- google analytics -->
<?php echo $analytics; ?>

<?php $this->load->view('js-init'); ?>
<?php echo $_scripts; ?>

<script type="text/javascript">
/*
	if (window == window.top && (!window.location.href.match('\/auth\/') || !window.location.href.match('\/home\/'))) {
		$.cookie('last_known_url', window.location.href, 0, '/home');
		window.location = OpenVBX.home;
	}
*/
	if (window == window.top && (!window.location.href.match('\/auth\/') ))
	{
		window.location = OpenVBX.home;
	}	

// && !window.location.href.match('\/home\/') && !window.location.href.match('\/%2Fhome\/')

</script>



</body>
</html>
