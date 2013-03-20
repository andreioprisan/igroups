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
			$modules_main = array(

			);
			
			$modules = array(
				'Metrics' 			=> 'closed', 
				'Voicemail' 		=> 'closed',
				'Transcription' 	=> 'closed',
				'Call Screening' 	=> 'closed',
				
			);
			
			?>
			
			
			
			<div class="accordion">
				<div class="accordionHeaders" onClick="backToDashboardView(<?= $user_id ?>); return false;"><img src="/asset/icons/minimalistica_red/32x32/world.png" height="28" style="position:absolute; padding-top:4px; padding-right: 10px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Dashboard</div>
				<div class="contentHolder">
					<?php
					foreach($modules_main as $module => $module_show) {
						$icon="";
						$header = $module;
						if ($header == "Feed" || $header == "Usage") {
							$icon = "32x32/world_globe.png";
						} else 	if ($header == "Tasks") {
							$icon = "32x32/accept_item.png";
						} else 	if ($header == "Calendar") {
							$icon = "32x32/calendar.png";
						} else 	if ($header == "Messages" || $header == "Voicemail") {
							$icon = "32x32/email.png";
						} else 	if ($header == "Files" || $header == "Analytics") {
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
				<div class="accordionHeaders groups" data-amount="<?= $groupscount; ?>"><img src="/asset/icons/minimalistica_red/32x32/phone.png" height="28" style="position:absolute; padding-top:4px; padding-right: 10px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Phone Numbers</div>
				<div class="groupsmanage" onclick="doActivateModule('groupsusersmanage','<?= $user_id ?>','',''); return false;"><span><img src="/asset/icons/sticker/32x32/tool.png" height="24" style="position:absolute; padding-top:2px;"></span><div style="padding-left: 40px;">Add & Manage Numbers</div></div>
				
				<?php 
//				var_dump($phonenumbers_data);
				
				if (isset($phonenumbers_data)) {?>
					<?php foreach ($phonenumbers_data as $phonenumber_data_item) { ?>
								<div class="accordionHeadersGroup group"><span><img src="/asset/icons/sticker/32x32/right_arrow.png" height="24" style="position:absolute; padding-top:2px;"></span><div style="padding-left: 40px;"><?= $phonenumber_data_item->number; ?></div></div>
								<div class="contentHolder">
									<?php
									foreach($modules as $module => $module_show) {
										$icon="";
										$header = $module;
										if ($header == "Feed" || $header == "Usage") {
											$icon = "32x32/world_globe.png";
										} else 	if ($header == "Tasks") {
											$icon = "32x32/accept_item.png";
										} else 	if ($header == "Calendar") {
											$icon = "32x32/calendar.png";
										} else 	if ($header == "Messages" || $header == "Voicemail") {
											$icon = "32x32/email.png";
										} else 	if ($header == "Files" || $header == "Analytics") {
											$icon = "32x32/note.png";
										} else 	if ($header == "Upcoming") {
											$icon = "32x32/search_magnifier.png";
										} else 	if ($header == "Groups") {
											$icon = "32x32/users.png";
											
										} else 	if ($header == "Metrics") {
											$icon = "32x32/chart.png";
										} else 	if ($header == "Transcription") {
											$icon = "32x32/edit_item.png";
										} else 	if ($header == "Call Screening") {
											$icon = "32x32/note_accept.png";
										
										}
										?>
										<div class="accordionContent" data-amount="2" id="<?= strtolower($module) ?>_sidebar_header"  onclick="doActivateModule('<?= strtolower($module) ?>','<?= $user_id ?>','<?= $phonenumber_data_item->number ?>','1'); return false;"><span><img src="/asset/icons/sticker/<?= $icon;?>" height="24" style="position:absolute; padding-top:2px;"></span><div style="padding-left: 40px;"><?= $module ?></div></div>
									<?php } ?>
								</div>
								
					<?php $thiscounter++; } ?>
				<?php } ?>
				
				<div class="accordionHeaders" onClick=" return false;"><span><img src="/asset/icons/minimalistica_red/32x32/mail.png" height="24" style="position:absolute; padding-top:2px;"></span><div style="padding-left: 40px;">Voicemail</div></div>
				<div class="contentHolder">
					<div class="accordionContent" id="tasks_sidebar_header" onclick="doActivateModule('',1,'','0')"><span><img src="/asset/icons/sticker/32x32/process.png" height="24" style="position:absolute; padding-top:2px;"></span><div style="padding-left: 40px;">Visual Voicemail</div></div>
					<div class="accordionContent" id="tasks_sidebar_header" onclick="doActivateModule('',1,'','0')"><span><img src="/asset/icons/sticker/32x32/unlock.png" height="24" style="position:absolute; padding-top:2px;"></span><div style="padding-left: 40px;">Transcriptions</div></div>
				</div>

				<div class="accordionHeaders" onClick=" return false;"><span><img src="/asset/icons/minimalistica_red/32x32/chart.png" height="24" style="position:absolute; padding-top:2px;"></span><div style="padding-left: 40px;">Metrics</div></div>
				<div class="contentHolder">
					<div class="accordionContent" id="tasks_sidebar_header" onclick="doActivateModule('',1,'','0')"><span><img src="/asset/icons/sticker/32x32/process.png" height="24" style="position:absolute; padding-top:2px;"></span><div style="padding-left: 40px;">Analytics</div></div>
					<div class="accordionContent" id="tasks_sidebar_header" onclick="doActivateModule('',1,'','0')"><span><img src="/asset/icons/sticker/32x32/unlock.png" height="24" style="position:absolute; padding-top:2px;"></span><div style="padding-left: 40px;">Usage</div></div>
					<div class="accordionContent" id="tasks_sidebar_header" onclick="doActivateModule('',1,'','0')"><span><img src="/asset/icons/sticker/32x32/unlock.png" height="24" style="position:absolute; padding-top:2px;"></span><div style="padding-left: 40px;">Reports</div></div>
				</div>				
				
				<div class="accordionHeaders" onClick=" return false;"><span><img src="/asset/icons/minimalistica_red/32x32/comments.png" height="24" style="position:absolute; padding-top:2px;"></span><div style="padding-left: 40px;">Conference Calls</div></div>
				<div class="contentHolder">
					<div class="accordionContent" id="tasks_sidebar_header" onclick="doActivateModule('',1,'','0')"><span><img src="/asset/icons/sticker/32x32/process.png" height="24" style="position:absolute; padding-top:2px;"></span><div style="padding-left: 40px;">Overview</div></div>
					<div class="accordionContent" id="tasks_sidebar_header" onclick="doActivateModule('',1,'','0')"><span><img src="/asset/icons/sticker/32x32/unlock.png" height="24" style="position:absolute; padding-top:2px;"></span><div style="padding-left: 40px;">Manage</div></div>
					<div class="accordionContent" id="tasks_sidebar_header" onclick="doActivateModule('',1,'','0')"><span><img src="/asset/icons/sticker/32x32/unlock.png" height="24" style="position:absolute; padding-top:2px;"></span><div style="padding-left: 40px;">Schedule</div></div>
					<div class="accordionContent" id="tasks_sidebar_header" onclick="doActivateModule('',1,'','0')"><span><img src="/asset/icons/sticker/32x32/unlock.png" height="24" style="position:absolute; padding-top:2px;"></span><div style="padding-left: 40px;">Recordings</div></div>
				</div>
				
				<div class="accordionHeaders" onClick=" return false;"><span><img src="/asset/icons/minimalistica_red/32x32/business_user.png" height="24" style="position:absolute; padding-top:2px;"></span><div style="padding-left: 40px;">Business Phone System</div></div>
				<div class="contentHolder">
					<div class="accordionContent" id="tasks_sidebar_header" onclick="doActivateModule('',1,'','0')"><span><img src="/asset/icons/sticker/32x32/process.png" height="24" style="position:absolute; padding-top:2px;"></span><div style="padding-left: 40px;">Overview</div></div>
					<div class="accordionContent" id="tasks_sidebar_header" onclick="doActivateModule('',1,'','0')"><span><img src="/asset/icons/sticker/32x32/unlock.png" height="24" style="position:absolute; padding-top:2px;"></span><div style="padding-left: 40px;">Extensions</div></div>
				</div>
				
				<div class="accordionHeaders" onClick=" return false;"><span><img src="/asset/icons/minimalistica_red/32x32/users.png" height="24" style="position:absolute; padding-top:2px;"></span><div style="padding-left: 40px;">Call Center</div></div>
				<div class="contentHolder">
					<div class="accordionContent" id="tasks_sidebar_header" onclick="doActivateModule('',1,'','0')"><span><img src="/asset/icons/sticker/32x32/process.png" height="24" style="position:absolute; padding-top:2px;"></span><div style="padding-left: 40px;">Overview</div></div>
					<div class="accordionContent" id="tasks_sidebar_header" onclick="doActivateModule('',1,'','0')"><span><img src="/asset/icons/sticker/32x32/unlock.png" height="24" style="position:absolute; padding-top:2px;"></span><div style="padding-left: 40px;">Metrics</div></div>
					<div class="accordionContent" id="tasks_sidebar_header" onclick="doActivateModule('',1,'','0')"><span><img src="/asset/icons/sticker/32x32/unlock.png" height="24" style="position:absolute; padding-top:2px;"></span><div style="padding-left: 40px;">Agents</div></div>
				</div>
				
				<div class="accordionHeaders" onClick=" return false;"><span><img src="/asset/icons/minimalistica_red/32x32/link.png" height="24" style="position:absolute; padding-top:2px;"></span><div style="padding-left: 40px;">Advanced Workflows</div></div>
				<div class="contentHolder">
					<div class="accordionContent" id="tasks_sidebar_header" onclick="doActivateModule('',1,'','0')"><span><img src="/asset/icons/sticker/32x32/process.png" height="24" style="position:absolute; padding-top:2px;"></span><div style="padding-left: 40px;">Overview</div></div>
					<div class="accordionContent" id="tasks_sidebar_header" onclick="doActivateModule('',1,'','0')"><span><img src="/asset/icons/sticker/32x32/unlock.png" height="24" style="position:absolute; padding-top:2px;"></span><div style="padding-left: 40px;">Add Call Trigger</div></div>
					<div class="accordionContent" id="tasks_sidebar_header" onclick="doActivateModule('',1,'','0')"><span><img src="/asset/icons/sticker/32x32/unlock.png" height="24" style="position:absolute; padding-top:2px;"></span><div style="padding-left: 40px;">Add SMS Trigger</div></div>
					<div class="accordionContent" id="tasks_sidebar_header" onclick="doActivateModule('',1,'','0')"><span><img src="/asset/icons/sticker/32x32/unlock.png" height="24" style="position:absolute; padding-top:2px;"></span><div style="padding-left: 40px;">Manage</div></div>
				</div>
				
				<div class="accordionHeaders" onClick=" return false;"><span><img src="/asset/icons/minimalistica_red/32x32/database.png" height="24" style="position:absolute; padding-top:2px;"></span><div style="padding-left: 40px;">Call Rolls</div></div>
				<div class="contentHolder">
					<div class="accordionContent" id="tasks_sidebar_header" onclick="doActivateModule('',1,'','0')"><span><img src="/asset/icons/sticker/32x32/process.png" height="24" style="position:absolute; padding-top:2px;"></span><div style="padding-left: 40px;">Overview</div></div>
					<div class="accordionContent" id="tasks_sidebar_header" onclick="doActivateModule('',1,'','0')"><span><img src="/asset/icons/sticker/32x32/unlock.png" height="24" style="position:absolute; padding-top:2px;"></span><div style="padding-left: 40px;">Manage</div></div>
					<div class="accordionContent" id="tasks_sidebar_header" onclick="doActivateModule('',1,'','0')"><span><img src="/asset/icons/sticker/32x32/unlock.png" height="24" style="position:absolute; padding-top:2px;"></span><div style="padding-left: 40px;">Schedule</div></div>
				</div>
				
				

				

				
				
				<div class="accordionHeaders" onClick="backToDashboardView(<?= $user_id ?>); return false;"><img src="https://graph.facebook.com/<?= $fbuid ?>/picture" height="28" style="position:absolute; padding-top:4px; padding-right: 10px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?= $fullname; ?></div>
				<div class="contentHolder">
					<div class="accordionContent" id="tasks_sidebar_header" onclick="doActivateModule('tasks',1,'','0')"><span><img src="/asset/icons/sticker/32x32/process.png" height="24" style="position:absolute; padding-top:2px;"></span><div style="padding-left: 40px;">Settings</div></div>
					<div class="accordionContent" id="tasks_sidebar_header" onclick="doActivateModule('tasks',1,'','0')"><span><img src="/asset/icons/sticker/32x32/unlock.png" height="24" style="position:absolute; padding-top:2px;"></span><div style="padding-left: 40px;">Upgrade Plan</div></div>
					<div class="accordionContent" id="tasks_sidebar_header" onclick="window.location='<?= $logoutUrl ?>';"><span><img src="/asset/icons/sticker/32x32/delete_item.png" height="24" style="position:absolute; padding-top:2px;"></span><div style="padding-left: 40px;">Log Out</div></div>
				</div>
				
				
			</div>
			<div class="bottom-box" style="background-color: black; width: 210px; height: 18px;">version 0.9.1</div>

		</div>
</div>