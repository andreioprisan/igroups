<div id="tasks_module" style="display: block">

	<div class="openlookbox">
		<div class="oplholder">	
			<div class="oplspacer">
				<div class="oplspacer-inner"></div>
			</div>
			<div id="bgshadow"></div>		
			<div class="inner">	
				<section class="oplcontent">
					<div class="oplspacer"></div>

					<aside id="olk-details" style="height: 100%; display: none; position:fixed;">
						<div class="olk-details-inner">	
							<div id="olk-details-content" style="height: 100%;">
								<a href="#" id="detail-close" onclick="$('#olk-details').fadeOut();"></a>
								<div id="indepth">
									<h3><a href="#"></a></h3>
									<a href="" style="display: none; "></a><br>
									<a href="" style="display: none; "></a>
								</div>
								<dl id="avail-status">
								</dl>
								<!--
								<hr>
								<span id="app-count">1</span> App Ideas
								<ul id="app-ideas"><li><a href=""></a></li></ul>
								<hr>
								<dl id="wants-to-build">
									<dt></dt>
									<dd></dd>
								</dl>
								<hr>
								<dl id="skills">
									<dt></dt>
									<dd></dd>
								</dl>
								<hr>
								<p id="additional_info">My iPhone app? It went from nothing, to submitted to Apple in 7 days.</p>
								-->
							</div>
						</div>
					</aside>

					<div id="listings">
						<ul class="listings-holder">
							<!--
							<li class="selected">
								<div class="more"><a href="" class="gen-btn"><span>View More</span></a></div>
								<span class="user-img">
									<img src="" alt="">
								</span>
								<div class="name"><h2>element2</h2></div>								
								<span class="user-info type">element2</span>
								<span class="user-info"><strong>element2</strong> App Ideas</span>
								<span class="user-info">element2element2element2element2element2</span>
							</li>
							-->
							<?php 

							if ($inGroupView == "1") 
							{
								$stream = $this->tasks_model->get_group_tasks($group_id, $user_id); 
							} else {
								$stream = $this->tasks_model->get_tasks_userhasaccessto($user_id); 
							}
								
//							var_dump($stream);
								
							foreach($stream as $task) 
							{
								$groupname = "Personal Task";
								if ($task->group_id != "0") 
								{
									$this_group = $this->usergroups_model->get_group_by_id($task->group_id);
									$groupname = $this_group->name;
								}
								
								$date_formatted_gr = explode(" ", $task->datetime);
								$date_formatted_ymd = explode("-", $date_formatted_gr[0]);
								$date_formatted_hr = explode(":", $date_formatted_gr[1]);

								$date_formatted_1 = $date_formatted_ymd[1]."/".$date_formatted_ymd[2]."/".substr($date_formatted_ymd[0], 2, 2);

								if ($date_formatted_hr[0] >= "12")
								{
									$date_formatted_hr[2] = "PM";
									$date_formatted_hr[0] -= 12;
								} else {
									$date_formatted_hr[2] = "AM";
								}

								$date_formatted_2 = $date_formatted_hr[0].":".$date_formatted_hr[1]." ".$date_formatted_hr[2];
//								$date_formatted = $date_formatted_1." ".$date_formatted_2;
								$date_formatted = $date_formatted_1;

								$type = $task->type;
								?>
								
								<li onclick="$('.listings-holder li').removeClass('selected'); changeClass(this, 'selected'); var model = []; model[0]=['header','stream details','','','','','order','0']; model[1]=['desc','group','elemType','text','elemLabel','<?= $groupname; ?>','order','1'];  model[2]=['desc','by','elemType','text','elemLabel','<?= $task->fromMember; ?>','order','2']; model[3]=['desc','@','elemType','text','elemLabel','<?= $date_formatted; ?>','order','3'];   model[4]=['desc','due','elemType','text','elemLabel','<?= $task->duedate; ?>','order','4'];  model[5]=['desc','event type','elemType','text','elemLabel','<?= $task->type; ?>','order','5']; model[6]=['desc','priority','elemType','text','elemLabel','<?= $task->priority; ?>','order','6']; model[7]=['desc','private','elemType','text','elemLabel','<?= $task->private; ?>','order','7']; model[8]=['desc','what','elemType','text','elemLabel','<?= str_replace("\n",'', nl2br("$task->content")); ?>','order','10']; model[9]=['desc','control','elemType','text','elemLabel','<?php if ($task->user_id == $user_id) { echo "editdelete"; } ?>','order','11']; model[10]=['desc','objecttype','elemType','text','elemLabel','tasks','order','12']; model[11]=['desc','objectid','elemType','text','elemLabel','<?= $task->id; ?>','order','13']; model[12]=['desc','group','elemType','autocomplete','elemLabel','<?= $groupname; ?>','order','8']; model[13]=['desc','groupid','elemType','data','elemLabel','<?= $task->group_id; ?>','order','']; model[14]=['desc','to_user_id','elemType','data','elemLabel','<?= $task->to_user_id; ?>','order','']; model[15]=['desc','member','elemType','autocomplete','elemLabel','','order','9']; setMRP(model);">
									<span class="row-spacer"></span>
									<?php if ($inGroupView == "0") {?>
										<?php if ($groupname != "") {?>
											<?php if (trim($groupname) == "Personal Task") { ?>
											<span class="event-type5 label success" style="font-size: 15px; margin-top: 8px; width:300px;"><?= $groupname; ?></span>
											<?php } else { ?>
											<span class="event-type5 label success" style="font-size: 15px; margin-top: 8px; width:300px;"><b>group</b> <?= $groupname; ?></span>
											<?php } ?>
										<?php } ?>
									<?php } else { ?>
									<span class="event-type5 label success" style="font-size: 15px; margin-top: 8px; width:300px;"><b>date</b> <?= $date_formatted ?></span>
									<?php } ?>
								
									<?php if ($task->toself == "1") { ?>
									<span class="event-type0 label blue" style="margin-top: 8px;"><b>To Self</b></span> 
									<?php } else { ?>
<!--									<span class="<?php if (strlen($task->fromMember) <= '12') { echo 'event-type2'; } else { echo 'event-type3'; }?> label blue" style="margin-top: 8px;"><b>from</b> <?= $task->fromMember ?></span>
-->
									<?php } ?>

									<?php if ($task->toself != "1" && $task->to_user_id > 0) { $fullname_by = $this->usersm->get_name($task->to_user_id); ?>
									<span class="<?php if (strlen($fullname_by) <= '12') { echo 'event-type2'; } else { echo 'event-type3'; }?> label blue" style="margin-top: 8px;"><b>to</b> <?= $fullname_by ?></span>
									<?php } ?>

									<span class="event-type2 label notice" style="margin-top: 8px; width: 68px;"><b>due</b> <?= $task->duedate ?></span>


									<?php 
									if (isset($task->priority)) {
										if ($task->priority == "0") { ?>
				
										<?php } else if ($task->priority == "1") { ?>
										<span class="event-type2 label warning" style="margin-top: 8px;"><b>medium</b> priority</span>
										<?php } else if ($task->priority == "2") { ?>
										<span class="event-type label warning" style="margin-top: 8px;"><b>high</b> priority</span>
									<?php } } ?>

									<?php if ($task->private == "1") { ?>
									<span class="event-type0 label important" style="margin-top: 8px;">Private</span> 
									<?php } ?>

									
									<?php 
									if ($inGroupView == "0") { 
										$strLimit = "132";
									} else {
										$strLimit = "150";
									}
								
									$f =  $task->content;
									if (strlen($f) > $strLimit)
									{
										$d = substr($f, 0, $strLimit).'...';
									} else {
										$d = $f;
									}
									?>
									<span class="user-info" style="margin-top: 17px; padding-left: 13px;"><?= $d ?></span>
								</li>
							<?php } ?>

						</ul>
					</div>
				</section>
			</div>		
		</div>
	</div>


<!--
	<div class="message-threadhead" style="background-color: white;">
		<a class="close" href="#" onclick=";"></a>



			<div class="input-prepend" style="display: inline"><span class="add-on">task</span><input class="medium" id="prependedInput" name="prependedInput" size="16" type="text"> <input class="medium" id="prependedInput" name="prependedInput" size="16" type="text" placeholder="priority"></div>
			
<div class="btn primary small">save</div>
		</div>
<div class="edit" id="div_1">Dolor</div>

a
<div id="search_box_container"></div>
    <div id="search_query">&nbsp;</div>
d
    <div id="search_box_container3"></div>
    <div id="search_query3">&nbsp;</div>
-->   
    


</div>