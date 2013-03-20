<div class="sidebar">
		<div class="well">
			<div class="top-box">
				 <img src="/asset/images/igroups.png" class="ig_logo"> 
			</div>
			
			<!--
			<div class="divheaderb"><h2>Feed</h2><span class="badge_count">0</span></div>
			<h3>Sidebar2</h3>
			<h3>Sidebar2</h3>
			<h4>Sidebar2</h4>
			<h3>Sidebar2</h3>
			<div class="padded">
				<h2>Sidebar2</h2>
			</div>
			
			<div class="divheaderb"><h2>Feed</h2><span class="badge_count">0</span></div><br>
			-->
			<?php 
			$modules = array(
				'Feed' 		=> 'closed', 
				'Tasks' 	=> 'closed',
				'Messages' 	=> 'closed', 
				'Calendar' 	=> 'closed',
				'Files' 	=> 'closed'
			);?>
			
			
			
			<div class="accordion">
				<div class="accordionHeaders" onClick="backToDashboardView(<?= $user_id ?>); return false;"><img src="/asset/icons/minimalistica_red/32x32/world.png" height="28" style="position:absolute; padding-top:4px; padding-right: 10px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Dashboard</div>
				<div class="contentHolder">
					<?php
					foreach($modules as $module => $module_show) {
						$icon="";
						$header = $module;
						if ($header == "Feed") {
							$icon = "32x32/world_globe.png";
						} else 	if ($header == "Tasks") {
							$icon = "32x32/accept_item.png";
						} else 	if ($header == "Calendar") {
							$icon = "32x32/calendar.png";
						} else 	if ($header == "Messages") {
							$icon = "32x32/email.png";
						} else 	if ($header == "Files") {
							$icon = "32x32/note.png";
						} else 	if ($header == "Upcoming") {
							$icon = "32x32/search_magnifier.png";
						} else 	if ($header == "Groups") {
							$icon = "32x32/users.png";
						}
						?>
						<div class="accordionContent" data-amount="2" id="<?= strtolower($module) ?>_sidebar_header"  onclick="doActivateModule('<?= strtolower($module) ?>','<?= $user_id ?>','0','0'); return false;"><span><img src="/asset/icons/sticker/<?= $icon;?>" height="24" style="position:absolute; padding-top:2px;"></span><div style="padding-left: 40px;"><?= $module ?></div></div>
					<?php } ?>
				</div>

				<?php $groupscount = 0; if (isset($groups_data)) { $groupscount = count($groups_data);  } $thiscounter = 0; ?>
				<div class="accordionHeaders groups" data-amount="<?= $groupscount; ?>"><img src="/asset/icons/minimalistica_red/32x32/users.png" height="28" style="position:absolute; padding-top:4px; padding-right: 10px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Groups</div>
				<div class="groupsmanage" onclick="doActivateModule('groupsusersmanage','<?= $user_id ?>','',''); return false;"><span><img src="/asset/icons/sticker/32x32/tool.png" height="24" style="position:absolute; padding-top:2px;"></span><div style="padding-left: 40px;">Manage Groups</div></div>
				
				<?php 
				/*onClick="backToGroupView('<?= $groups_data_item->id ?>', '<?= $groups_data_item->name ?>', '<?= $user_id ?>');"*/
				if (isset($groups_data)) {?>
					<?php foreach ($groups_data as $groups_data_item) { ?>
							<?php if ($groups_data_item->is_active) {?>
								<div class="accordionHeadersGroup group"><div style="padding-left: 0px;"><?= $groups_data_item->name; ?></div></div>
								<div class="contentHolder">
									<?php
									foreach($modules as $module => $module_show) {
										$icon="";
										$header = $module;
										if ($header == "Feed") {
											$icon = "32x32/world_globe.png";
										} else 	if ($header == "Tasks") {
											$icon = "32x32/accept_item.png";
										} else 	if ($header == "Calendar") {
											$icon = "32x32/calendar.png";
										} else 	if ($header == "Messages") {
											$icon = "32x32/email.png";
										} else 	if ($header == "Files") {
											$icon = "32x32/note.png";
										} else 	if ($header == "Upcoming") {
											$icon = "32x32/search_magnifier.png";
										} else 	if ($header == "Groups") {
											$icon = "32x32/users.png";
										}
										?>
										<div class="accordionContent" data-amount="2" id="<?= strtolower($module) ?>_sidebar_header"  onclick="doActivateModule('<?= strtolower($module) ?>','<?= $user_id ?>','<?= $groups_data_item->id?>','1'); return false;"><span><img src="/asset/icons/sticker/<?= $icon;?>" height="24" style="position:absolute; padding-top:2px;"></span><div style="padding-left: 40px;"><?= $module ?></div></div>
									<?php } ?>
								</div>
								
							<?php } ?>
					<?php $thiscounter++; } ?>
				<?php } ?>
				
				<div class="accordionHeaders" onClick="backToDashboardView(<?= $user_id ?>); return false;"><img src="https://graph.facebook.com/<?= $fbuid ?>/picture" height="28" style="position:absolute; padding-top:4px; padding-right: 10px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?= $fullname; ?></div>
				<div class="contentHolder">
					<div class="accordionContent" id="tasks_sidebar_header" onclick="doActivateModule('tasks',1,'','0')"><span><img src="/asset/icons/sticker/32x32/process.png" height="24" style="position:absolute; padding-top:2px;"></span><div style="padding-left: 40px;">Settings</div></div>
					<div class="accordionContent" id="tasks_sidebar_header" onclick="doActivateModule('tasks',1,'','0')"><span><img src="/asset/icons/sticker/32x32/unlock.png" height="24" style="position:absolute; padding-top:2px;"></span><div style="padding-left: 40px;">Upgrade Plan</div></div>
					<div class="accordionContent" id="tasks_sidebar_header" onclick="window.location='<?= $logoutUrl ?>';"><span><img src="/asset/icons/sticker/32x32/delete_item.png" height="24" style="position:absolute; padding-top:2px;"></span><div style="padding-left: 40px;">Log Out</div></div>
				</div>
				
				
			</div>
			<div class="bottom-box" style="background-color: black; width: 210px; height: 18px;">version 0.9.1</div>
			<!--
			<div class="bottom-box" style="background-color: black; width: 210px; height: 64px;">
				<div class="rib">
						<div class="rrighttop" id="groups_ribbon">
						<div class="ribbon-wrapper rrighttop">
							<div class="ribbon-front" style="background-color: red">
								<span class="labelbig important" style="top: 1px"> 
									<img src="https://graph.facebook.com/<?= $fbuid ?>/picture" height="24" style="-moz-box-shadow: 0px 0px 5px black; -webkit-box-shadow: 0px 0px 5px black; box-shadow: 0px 0px 5px black; border: 1px solid black;"></span>
									<h2 name="groups_header" id="groups_header" class="ribbon_headerbar"><?= $fullname; ?></h2>
									<div class="ribbon_icon">
										<a href="#" id="groups_sidebar_header"><img src="/asset/icons/sticker/32x32/process.png" height="24"></a>
									</div>
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
				<br />
				<br />
				<input type="button" class="btn primary disabled small" value="3 GB plan" style="width:80px"> <a href="#" class="btn success small">settings</a> <a href="<?= $logoutUrl ?>" class="btn danger small">sign out</a>
			</div>
			-->
		</div>
</div>