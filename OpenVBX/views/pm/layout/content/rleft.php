<div class="rleft">
<div class="ribbon-wrapper rleft">
	<div class="ribbon-front">
		<?php
		$icon="";
		if ($header == "Feed")
		{
			$icon = "32x32/world_globe.png";
		} else 	if ($header == "Tasks")
		{
			$icon = "32x32/accept_item.png";

		} else 	if ($header == "Calendar")
		{
			$icon = "32x32/calendar.png";


		} else 	if ($header == "Members")
		{
			$icon = "32x32/users.png";


		} else 	if ($header == "Messages")
		{
			$icon = "32x32/comment_bubble.png";

		} else 	if ($header == "Files")
		{
			$icon = "32x32/note.png";
		}

		?>
		<span class="labelbig important" style="color: white; padding: 3px 0px 0px 0px; display: inline; position:relative "> &nbsp;&nbsp;<strong>4</strong>&nbsp;&nbsp; </span><h2 name='<?= $header ?>_header' id='<?= $header ?>_header' style="color: white; padding: 0px 0px 0px 10px; display: inline; position:absolute; "><?= $header ?></h2><div style=" position:absolute; display:inline; right:2px; padding: 3px 0px 20px 0px;"><font color=gray><a href="#" onclick='$("#<?= strtolower($header) ?>_module").slideToggle("slow");'><img src="/asset/icons/sticker/<?= $icon ?>" height="32"></a></font></div>
	</div>
	<div class="ribbon-edge-topleft"></div>
	<div class="ribbon-edge-topright"></div>
	<div class="ribbon-edge-bottomleft"></div>
	<div class="ribbon-edge-bottomright"></div>
	<div class="ribbon-back-left"></div>
	<div class="ribbon-back-right"></div>
</div>
</div>
<br />