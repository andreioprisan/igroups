<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Bootstrap, from Twitter</title>
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le HTML5 shim, for IE6-8 support of HTML elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Le styles -->
	<link type="text/css" rel="stylesheet" href="http://igrou.ps.dev/asset/css/bootstrap-1.4/bootstrap.css" />
    <style type="text/css">
      body {
        padding-top: 0px;
		padding-left: 0px;
      }

		.container-fluid {
			padding-left: 0px;
		}
		
		.container-fluid .content {
			padding-left: 20px;
		}
		
		.container-fluid .sidebar {
			padding-left: 0px;
			left: 0px;
			color: red;
			width: 240px;

			height: 100%;
			position: fixed;

		}
		
		.container-fluid .sidebar .well {
			margin-bottom: 0px;
			min-height: 100%;
			background-color: #4A4A4A;
			
			background-image: -webkit-gradient(linear, 50% 0%, 50% 100%, color-stop(0%, #000), color-stop(100%, #444));
			background-image: -webkit-linear-gradient(#444,#000);
			background-image: -moz-linear-gradient(#000,#444);
			background-image: -o-linear-gradient(#000,#444);
			background-image: -ms-linear-gradient(#000,#444);
			background-image: linear-gradient(#000,#444);
			
			-webkit-border-radius: 0px;
			-moz-border-radius: 0px;
			border-radius: 0px;
			
			padding-top: 0px;
			padding-right: 0px;
			padding-bottom: 0px;
			padding-left: 0px;
			
			border: 0px solid rgba(0, 0, 0, 0.05);
			
		}
		
		.container-fluid .sidebar .well .padded {
			padding-top: 19px;
			padding-right: 19px;
			padding-bottom: 19px;
			padding-left: 19px;
		}
		
		.container-fluid .sidebar .well .top-box {
			height:90px;
			width: 212px;

			padding-top: 22px;
			padding-right: 20px;
			padding-bottom: 24px;
			padding-left: 8px;
			position: relative;
			top: 0px;
		}
		
		.container-fluid .sidebar .well .top-box .ig_logo {
			position: absolute;
			top: 0px;
			-moz-box-shadow: 0px 0px 5px #000;
			-webkit-box-shadow: 0px 0px 5px #000;
			box-shadow: 0px 0px 5px #000;	
			border: 1px solid red;
			left:50px;
		
					
		}
		
		.container-fluid .sidebar .well .bottom-box {
			height:90px;
			width: 212px;
			padding: 3px 15px 3px 14px;
			background-color: #666;
			position: absolute;
			left: 0px;
			bottom: 0px;
		}

		.container-fluid .sidebar .well h2 {
			font-weight: bold;
			font-size: 12px;
			text-transform: uppercase;
			text-shadow: rgba(0, 0, 0, 0.3) 0 1px 1px;
			color:white;
		}
		
		.container-fluid .sidebar .well .divheaderb {
			background: #003F81;
			padding: 3px 15px 3px 14px;
			position: relative;
			cursor: pointer;
			border-top: 1px solid black;
			border-bottom: 1px solid black;
			
		}
		
		.container-fluid .sidebar .well .divheader {
			background: #0064CD;
			padding: 3px 15px 3px 14px;
			position: relative;
			cursor: pointer;
		}
		
		.container-fluid .sidebar .well ul li {
			color: white;
		}
		
		.container-fluid .sidebar .well h5 {
			color: white;
		}
	
		.badge_count {
			height: 14px;
			padding: 0px 4px 3px 4px;
			-moz-border-radius: 9px;
			-webkit-border-radius: 9px;
			-o-border-radius: 9px;
			-ms-border-radius: 9px;
			-khtml-border-radius: 9px;
			border-radius: 9px;
			background: #CCC;
			color: red;
			display: inline-block;
			position: absolute;
			bottom: 13px;
			min-width: 20px;
			text-align: center;
			right: 10px;
			font-weight: bold;
			font-size: 14px;
		}
		
		
		/* ribbon right style */

	            .rib .rright.ribbon-wrapper {
				    /*position: absolute;
				    right:14px;
				    */
				    position:absolute;
				    left:0px;

				    border-bottom: 0px solid #ccc;
				    border-top: 0px solid #ccc;
				    -moz-border-bottom-colors: rgba(0, 0, 0, 0.02) rgba(0, 0, 0, 0.04) rgba(0, 0, 0, 0.06) rgba(0, 0, 0, 0.08) rgba(0, 0, 0, 0.10) rgba(0, 0, 0, 0.12) rgba(0, 0, 0, 0.14) rgba(0, 0, 0, 0.16) rgba(0, 0, 0, 0.18) rgba(0, 0, 0, 0.20);
				    -webkit-border-bottom-colors: rgba(0, 0, 0, 0.02) rgba(0, 0, 0, 0.04) rgba(0, 0, 0, 0.06) rgba(0, 0, 0, 0.08) rgba(0, 0, 0, 0.10) rgba(0, 0, 0, 0.12) rgba(0, 0, 0, 0.14) rgba(0, 0, 0, 0.16) rgba(0, 0, 0, 0.18) rgba(0, 0, 0, 0.20);
				    -moz-border-top-colors: rgba(0, 0, 0, 0.02) rgba(0, 0, 0, 0.04) rgba(0, 0, 0, 0.06) rgba(0, 0, 0, 0.08) rgba(0, 0, 0, 0.10) rgba(0, 0, 0, 0.12) rgba(0, 0, 0, 0.14) rgba(0, 0, 0, 0.16) rgba(0, 0, 0, 0.18) rgba(0, 0, 0, 0.20);
				    -webkit-border-top-colors: rgba(0, 0, 0, 0.02) rgba(0, 0, 0, 0.04) rgba(0, 0, 0, 0.06) rgba(0, 0, 0, 0.08) rgba(0, 0, 0, 0.10) rgba(0, 0, 0, 0.12) rgba(0, 0, 0, 0.14) rgba(0, 0, 0, 0.16) rgba(0, 0, 0, 0.18) rgba(0, 0, 0, 0.20);
				}
				.rib .rright .ribbon-front {
				    background-color: #012957;  height: 35px;
				    width: 270px;
				    position: relative;
				    left:-20px;
				    z-index: 2;
				}

				.rib .rright .ribbon-front,
				.rib .rright .ribbon-back-left,
				.rib .rright .ribbon-back-right
				{
				    -moz-box-shadow: 0px 0px 4px rgba(0,0,0,0.55);
				    -khtml-box-shadow: 0px 0px 4px rgba(0,0,0,0.55);
				    -webkit-box-shadow: 0px 0px 4px rgba(0,0,0,0.55);
				    -o-box-shadow: 0px 0px 4px rgba(0,0,0,0.55);
				}

				.rib .rright .ribbon-edge-topleft,
				.rib .rright .ribbon-edge-topright,
				.rib .rright .ribbon-edge-bottomleft,
				.rib .rright .ribbon-edge-bottomright {
				    position: absolute;
				    z-index: 1;
				    border-style:solid;
				    height:0px;
				    width:0px;
				}

				.rib .rright .ribbon-edge-topleft,
				.rib .rright .ribbon-edge-topright {
				}

				.rib .rright .ribbon-edge-bottomleft,
				.rib .rright .ribbon-edge-bottomright {
				    top: 35px;
				}

				.rib .rright .ribbon-edge-topleft,
				.rib .rright .ribbon-edge-bottomleft {
				    left: -20px;
				    border-color: transparent #000000 transparent transparent;
				}

				.rib .rright .ribbon-edge-topleft {
				    top: -10px;
				    border-width: 10px 0px 0 0;
				}
				.rib .rright .ribbon-edge-bottomleft {
				    border-width: 0 0px 35px 0;
				}

				.rib .rright .ribbon-edge-topright,
				.rib .rright .ribbon-edge-bottomright {
				    left: 240px;
				    border-color: transparent transparent transparent #000000;
				}

				.rib .rright .ribbon-edge-topright {
				    top: 0px;
				    border-width: 0px 0 0 10px;
				}
				.rib .rright .ribbon-edge-bottomright {
				    border-width: 0 0 10px 10px;
				}

				.rib .rright .ribbon-back-left {
				    position: absolute;
				    top: -10px;
				    left: -20px;
				    width: 0px;
				    height: 80px;
				    background-color: #8D0A0A;  z-index: 0;
				}

				.rib .rright .ribbon-back-right {
				    position: absolute;
				    top: 10px;
				    right: -20px;
				    width: 0px;
				    height: 35px;
				    background-color: #fff; z-index: 0;
				}
				
	 			.labelbig {
					color: white; 
					padding: 3px 0px 0px 0px; 
					display: inline; 
					position: absolute; 
					top: 7px; 
				}
	
				.ribbon_headerbar {
					color: white; 
					padding: 0px 20px 0px 10px; 
					display: inline; 
					position: relative; 
					left: 60px;
				}
				
				.ribbon_icon {
					position: absolute; 
					display: inline; 
					right: 2px; 
					padding: 3px 0px 20px 0px;
				}
				
    </style>

  </head>

  <body>
    <div class="container-fluid">
      <div class="sidebar">
        <div class="well">
		
			<div class="top-box">
				 <img src="/asset/images/igroups.png" class="ig_logo"> 
			</div>

          <div class="divheaderb"><h2>Feed</h2><span class="badge_count">0</span></div><br>
<br>
          <div class="divheaderb"><h2>Tasks</h2><span class="badge_count">0</span></div><br>
	
	<!--

          <div class="divheader"><h2>Members</h2><span class="badge_count">0</span></div>

          <div class="divheaderb"><h2>Calendar</h2><span class="badge_count">0</span></div>

          <div class="divheader"><h2>Messages</h2><span class="badge_count">0</span></div>

          <div class="divheader"><h2>Files</h2><span class="badge_count">0</span></div>
-->
		<div class="rib">
		<div class="rright">
		<div class="ribbon-wrapper rright">
			<div class="ribbon-front">
				<span class="labelbig important"> &nbsp;&nbsp;<strong>4</strong>&nbsp;&nbsp; </span>
				<h2 name="Messages_header" id="Messages_header" class="ribbon_headerbar">Messages</h2>
				<div class="ribbon_icon">
					<a href="#" onclick="$('#messages_module').slideToggle('slow');"><img src="/asset/icons/sticker/32x32/comment_bubble.png" height="32"></a></div>
			</div>
			<div class="ribbon-edge-topleft"></div>
			<div class="ribbon-edge-topright"></div>
			<div class="ribbon-edge-bottomleft"></div>
			<div class="ribbon-edge-bottomright"></div>
			<div class="ribbon-back-left"></div>
			<div class="ribbon-back-right"></div>
		</div>
		</div>
	</div>
		
		<br/>
		<br/>
		<br/>

		<div class="rib">
		<div class="rright">
		<div class="ribbon-wrapper rright">
			<div class="ribbon-front">
						<span class="labelbig important" style="color: white; padding: 2px 0px 0px 0px; display: inline; position:absolute; top:6px; "> &nbsp;&nbsp;<strong>4</strong>&nbsp;&nbsp; </span><h2 name="Messages_header" id="Messages_header" style="color: white; padding: 0px 20px 0px 10px; display: inline; position:relative; left: 60px">Messages</h2><div style=" position:absolute; display:inline; right:2px; padding: 3px 0px 20px 0px;"><font color="gray"><a href="#" onclick="$('#messages_module').slideToggle('slow');"><img src="/asset/icons/sticker/32x32/comment_bubble.png" height="32"></a></font></div>
			</div>
			<div class="ribbon-edge-topleft"></div>
			<div class="ribbon-edge-topright"></div>
			<div class="ribbon-edge-bottomleft"></div>
			<div class="ribbon-edge-bottomright"></div>
			<div class="ribbon-back-left"></div>
			<div class="ribbon-back-right"></div>
		</div>
		</div>
	</div>



          
          <h2>Sidebar</h2>
	        <div class="padded">

          <h2>Subitem</h2>
          <ul>
            <li><a href="#">Link</a></li>
            <li><a href="#">Link</a></li>
          </ul>

			<div class="bottom-box">
				<h2>profile</h2>
				something here
			</div>

      </div>
        </div>
      </div>
      <div class="content">
        <!-- Main hero unit for a primary marketing message or call to action -->
        <div class="hero-unit">
          <h1>Hello, world!</h1>
          <p>Vestibulum id ligula porta felis euismod semper. Integer posuere erat a ante venenatis dapibus posuere velit aliquet. Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit.</p>
          <p><a class="btn primary large">Learn more &raquo;</a></p>
        </div>

        <!-- Example row of columns -->
        <div class="row">
          <div class="span6">
            <h2>Heading</h2>
            <p>Etiam porta sem malesuada magna mollis euismod. Integer posuere erat a ante venenatis dapibus posuere velit aliquet. Aenean eu leo quam. Pellentesque ornare sem lacinia quam venenatis vestibulum. Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit.</p>
            <p><a class="btn" href="#">View details &raquo;</a></p>
          </div>
          <div class="span5">
            <h2>Heading</h2>
             <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
            <p><a class="btn" href="#">View details &raquo;</a></p>
         </div>
          <div class="span5">
            <h2>Heading</h2>
            <p>Donec sed odio dui. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula porta felis euismod semper. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.</p>
            <p><a class="btn" href="#">View details &raquo;</a></p>
          </div>
        </div>

        <hr>

        <!-- Example row of columns -->
        <div class="row">
          <div class="span6">
            <h2>Heading</h2>
            <p>Etiam porta sem malesuada magna mollis euismod. Integer posuere erat a ante venenatis dapibus posuere velit aliquet. Aenean eu leo quam. Pellentesque ornare sem lacinia quam venenatis vestibulum. Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit.</p>
            <p><a class="btn" href="#">View details &raquo;</a></p>
          </div>
          <div class="span5">
            <h2>Heading</h2>
             <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
            <p><a class="btn" href="#">View details &raquo;</a></p>
         </div>
          <div class="span5">
            <h2>Heading</h2>
            <p>Donec sed odio dui. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula porta felis euismod semper. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.</p>
            <p><a class="btn" href="#">View details &raquo;</a></p>
          </div>
        </div>

        <footer>
          <p>&copy; Company 2011</p>
        </footer>
      </div>
    </div>

  </body>
</html>