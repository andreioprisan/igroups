<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>igrou.ps</title>
	<?php echo $_styles; ?>
	<!-- Le HTML5 shim, for IE6-8 support of HTML elements -->
	<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<?php echo $_scripts; ?>
	<script type="text/javascript">

	var user_id = "";
	var group_id = "";

	function changeClass(btn, cls)
	{
		if(!hasClass(btn, cls))
		{
			addClass(btn, cls);
		}
	}

	function hasClass(ele, cls) 
	{
	    return ele.className.match(new RegExp('(\\s|^)' + cls + '(\\s|$)'));
	}

	function addClass(ele, cls) 
	{
		if (!this.hasClass(ele, cls)) ele.className += " " + cls;
	}
	
	function removeClass(ele, cls) 
	{
		if (hasClass(ele, cls)) 
		{
			var reg = new RegExp('(\\s|^)' + cls + '(\\s|$)');
			ele.className = ele.className.replace(reg, ' ');
		}
	}
	
	$(document).ready(function(){
		$('.group').hide();
		$('.groupsmanage').hide();
	
		$('.accordionHeaders:first').addClass('selected').next('.contentHolder').slideDown();
		$('.accordionHeaders').click(function(){
			$('.group').removeClass('selected');
			$('.group').hide();
			$('.groupsmanage').hide();
			
			$('.accordionHeaders').removeClass('selected');
			$('.contentHolder').slideUp();
			$(this).addClass('selected').next('.contentHolder').slideDown();
		});
		
		$('.accordionHeadersGroup').click(function(){
			$('.accordionHeadersGroup').removeClass('selected');
			$('.contentHolder').slideUp();
			$(this).addClass('selected').next('.contentHolder').slideDown();
		});
		
		$('.groups').click(function(){
			$('.group').removeClass('selected');
			$('.group').show();
			$('.groupsmanage').show();
			
			$('.accordionHeaders').removeClass('selected');
			$('.contentHolder').slideUp();
			$(this).addClass('selected').next('.contentHolder').slideDown();
		});
		
		$('.groupsmanage').click(function(){
			$('.group').removeClass('selected');
			$('.accordionHeaders').removeClass('selected');
		});
	
			
	});
	
	</script>
	
	<script type="text/javascript">
	  var _gaq = _gaq || [];
	  _gaq.push(['_setAccount', 'UA-26105028-1']);
	  _gaq.push(['_setDomainName', 'igrou.ps']);
	  _gaq.push(['_trackPageview']);

	  (function() {
	    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
	    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
	    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	
	  })();
	
	</script>
</head>
<body>
	<div class="container-fluid">
	<script type="text/javascript" charset="utf-8">
    $(document).ready(function() {
		document.getElementById('toolbar').getElementsByTagName('h2')[0].innerHTML = 'Dashboard';
		document.getElementById('pane1content').innerHTML = '<img src="/asset/images/ajax-loader-circle.gif" style="top: 250px; left: 450px; position: relative;">';
		
      });
    </script>
    <?= $leftbar ?>
	<div class="content">
		<?= $main; ?>
	</div> <!-- /content -->
</div> <!-- /container -->
<?php echo $footer2; ?>
</body>
</html>
