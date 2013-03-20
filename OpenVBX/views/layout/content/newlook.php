<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8"> 
	<title>dashboard</title>
	<link rel="stylesheet" type="text/css" href="/assets/themes/bluelook/style.css" media="screen">
</head>
<body id="merch">
	<div id="background"></div>
	<div class="main-view">
		<div id="application">
			<div class="small" id="header">
			</div>
			<!--
			<div class="small" id="header">
				<div class="header-view">
					<h1>
						<a class="main-header-link" href="#dashboard">iGroups</a>
					</h1>
					<div class="navigation">
						<div id="account-dropdown-view">
							<div class="account-dropdown-view">
								<a class="account"><img src="img/c0345e3f1e0b71161d086cbc97a7adf9.png" height="16" width="16"> <span>Your Account</span></a>
								<div class="submenu">
									<ul class="root">
										<li class="save">
											<a>Save Account</a>
										</li>
										<li class="account-app">
											<a href="#account/activate">Activate Account</a>
										</li>
										<li class="settings">
											<a class="first" name="settings" id="settings">Account Settings</a>
										</li>
										<li>
											<div class="divider"></div>
										</li>
										<li>
											<a class="open-feedback">Send Feedback</a>
										</li>
										<li>
											<div class="divider"></div>
										</li>
										<li>
											<a class="logout">Sign Out</a>
										</li>
									</ul>
								</div>
							</div>
						</div>
						<ul class="global">
							<li class="selected">
								<a href="#dashboard">Dashboard</a>
							</li>
							<li>
								<a id="global-documentation-link" href="https://igrou.ps/docs" name="global-documentation-link">Documentation</a>
							</li>
							<li>
								<a href="https://igrou.ps/help">Help &amp; Support</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
		-->
			<div id="notification-view"></div>
			<div id="main-body" class="box">
				<div id="toolbar-view">
					<div class="toolbar-view">
						<div id="main-toolbar">
							<div class="inner">
								<div id="livemode-switch">
									<div class="switch-view">
										<img src="/assets/themes/bluelook/images/igroups.png" style="-moz-box-shadow: 0px 0px 3px black;
										-webkit-box-shadow: 0px 0px 3px black;
										box-shadow: 0px 0px 3px black;
										border: 1px solid red;
										position: absolute;
										left: -36px;
										top: -19px;">
									</div>
								</div>
								<div id="breadcrumbs"></div>
							</div>
						</div>
					</div>
				</div>
				<div id="quicksearch-view">
					<div class="quicksearch-view">
						
						<div class="navigation" style="padding-top:4px;">
							<ul class="global">
								<li class="selected">
									<a href="#dashboard">Your Account</a>
								</li>
							</ul>
						</div>
						
						
						<!--
						<form>
							<div class="mask">
								<input name="search" autocomplete="off" spellcheck="false" tabindex="1" placeholder="Search..." type="text">
							</div>
							<div class="clear"></div>
						</form>
						<div style="display: box;" class="search-results-popover">
							<div class="inner">
								<div class="arrow"></div>
								<div class="search-results-container"></div>
								<div style="display: box;" class="loading-indicator">
									<span><img src="img/spinner.gif" height="16" width="16"> Searching…</span>
								</div>
							</div>
						</div>
						-->
					</div>
				</div>
				<div class="wrap">
					<div id="welcome-box"></div>
					<div id="sidebar-view-gradient"></div>
					<div id="sidebar-view">
						<div class="sidebar-view" id="sidebar">
							<div class="gradient"></div>
							
							<h4>General</h4>
							<ul class="navigation">
								<li class="dashboard selected">
									<a href="#dashboard"><span>Dashboard</span></a>
								</li>
								<li class="stats">
									<a href="#stats"><span>Metrics</span></a>
								</li>
							</ul>

							<h4>Messages</h4>
							<ul class="navigation">
								<li class="messages">
									<a href="#messages"><span>Inbox</span></a>
								</li>
							</ul>
							
							<h4>Manage</h4>
							<ul class="navigation">
								<li class="numbers">
									<a href="#numbers"><span>Numbers</span></a>
								</li>
								<li class="builder">
									<a href="#builder"><span>Builder</span></a>
								</li>
								<li class="members">
									<a href="#members"><span>Members</span></a>
								</li>
							</ul>
							
							<h4>Reports</h4>
							<ul class="navigation"><!--
								<li class="usage">
									<a href="#usage"><span>Usage</span></a>
								</li>-->
								<li class="analytics">
									<a href="#analytics"><span>Usage</span></a>
								</li>
							</ul>
						</div>
					</div>
					<div id="main-content">
						<div id="section">
							<div class="dashboard-view">
								<div class="dashboard-content">
									<div class="summary clearfix">
										
										<div class="summary-block total-volume">
											<div class="value">
												<span class="container"><strong data-text="$20.00">3</strong></span>
											</div>
											<div class="label">
												Phone Numbers
											</div>
										</div>
										
										<div class="summary-block next-transfer">
											<div class="value">
												<span class="container"><strong data-text="500">500</strong></span>
											</div>
											<div class="label">
												Minutes Left
											</div>
										</div>
										<div class="summary-block total-customers">
											<div class="value">
												<span class="container"><strong data-text="0">100</strong></span>
											</div>
											<div class="label">
												SMSs Left
											</div>
										</div>
										
										<div class="summary-block last-transfer">
											<div class="value">
												<span class="container"><strong data-text="$19.12">$19.12</strong></span>
											</div>
											<div class="label">
												Balance
											</div>
										</div>
										
									</div>
									<div class="charts">
										<div class="section-header">
											<h3>
												<span>Overview</span>
											</h3>
											<hr>
										</div>
<!--
										<div class="gross-volume-chart">
											<div class="chart-view">
												<div class="head">
													<span class="title">Gross volume</span> <span class="total">$0.00 total</span>
												</div>
												<div style="height: 120px; display: none;" class="spinner">
													<img src="Stripe_%20Manage_files/spinner_24x24.gif" height="24" width="24">
												</div>
											</div>
										</div>
										-->
aasdf
									</div>
									<div class="dashboard-welcome"></div>
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
				<p>©iGroups, Inc.</p>
				<ul>
					<li>
						<a href="https://igrou.ps/about">About</a>
					</li>
					<li>
						<a href="https://igrou.ps/help">FAQ</a>
					</li>
					<li>
						<a href="https://igrou.ps/help">Support</a>
					</li>
				</ul>
			</div>
		</div>
	</div>	
</body>
</html>