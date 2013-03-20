<div id="messages_module" style="display: block">

<?php 

if ($inGroupView) 
{
	$stream = $this->messages_model->get_group_messages($group_id, $user_id); 
} else {
	$stream = $this->messages_model->get_user_messages($user_id); 
}

if (count($stream) == 0 ) {
?>

<div class="alert-message info" style="width: 362px;">
        <p><strong>You've got no messages.</strong> You know what this means..</p>
      </div>
<br>
<img src="/asset/images/sad_panda.png" height="320px">

<?php
} else { ?>
	

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
								<a href="#" id="detail-close" onclick="$('#olk-details').fadeOut();$('#listings').width('100%');"></a>
								<div id="indepth">
									<h3><a href="#"></a></h3>
									<a href="" style="display: none; "></a><br>
									<a href="" style="display: none; "></a>
								</div>
								<dl id="avail-status">
								</dl>
							</div>
						</div>
					</aside>

					<div id="listings">
						<ul class="listings-holder">
						<?php
						foreach($stream as $message) 
						{
							$groupname = "Message";
							if ($message->group_id != "0") 
							{
								$this_group = $this->usergroups_model->get_group_by_id($message->group_id);
								$groupname = $this_group->name;
							}
							
							$date_formatted_gr = explode(" ", $message->datetime);
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
							$date_formatted = $date_formatted_1." ".$date_formatted_2;

							$priority = $message->priority;
							//var_dump($message);
							$color = "#E5E5E5";
							if ($priority == "0") 
							{ 
								$color = "info"; 
							} else if ($priority == "1") { 
								$color = "error"; 
							}

							if (isset($message->group_id) && $message->group_id != "0" && $message->group_id != "")
							{
								if (!$inGroupView) {
									$this_group = $this->usergroups_model->get_group_by_id($message->group_id);
								}
							}
							?>
							<li onclick="$('.listings-holder li').removeClass('selected'); changeClass(this, 'selected'); var model = []; model[0]=['header','stream details','','','','','order','0']; model[1]=['desc','group','elemType','text','elemLabel','<?= $this_group->name; ?>','order','1'];  model[2]=['desc','by','elemType','text','elemLabel','<?= $message->fromMember; ?>','order','2']; model[3]=['desc','@','elemType','text','elemLabel','<?= $message->dateformat; ?>','order','3']; model[4]=['desc','priority','elemType','text','elemLabel','<?= $message->priority; ?>','order','4']; model[5]=['desc','private','elemType','text','elemLabel','<?= $message->private; ?>','order','5']; model[6]=['desc','what','elemType','text','elemLabel','<?= str_replace("\n",'', nl2br("$message->content")); ?>','order','8']; model[7]=['desc','control','elemType','text','elemLabel','<?php if ($message->user_id == $user_id) { echo "editdelete"; } ?>','order','9']; model[8]=['desc','objecttype','elemType','text','elemLabel','messages','order','']; model[9]=['desc','objectid','elemType','text','elemLabel','<?= $message->id; ?>','order','']; model[10]=['desc','group','elemType','autocomplete','elemLabel','<?= $groupname; ?>','order','6']; model[11]=['desc','groupid','elemType','data','elemLabel','<?= $message->group_id; ?>','order','']; model[12]=['desc','to_user_id','elemType','data','elemLabel','<?= $message->to_user_id; ?>','order','']; model[13]=['desc','member','elemType','autocomplete','elemLabel','','order','7']; setMRP(model);">
								<span class="row-spacer"></span>
								<?php 
								$this_group = null;
								if (isset($message->group_id) && $message->group_id != "0" && $message->group_id != "")
								{
									if (!$inGroupView) 
									{
										$this_group = $this->usergroups_model->get_group_by_id($message->group_id);
									?> 
									<span class="event-type5 label success" style="font-size: 15px; margin-top: 9px; width:300px;"><b>group</b> <?= $this_group->name; ?></span>
									<?php
									}
								}
								?>
							
								<span class="<?php if (strlen($message->fromMember) <= '12') { echo 'event-type2'; } else { echo 'event-type3'; }?> label blue" style="margin-top: 9px;"><b>from</b> <?= $message->fromMember ?></span>
								<span class="event-type2 label notice" style="margin-top: 9px;"><b>@</b><?= $message->dateformat ?></span>
							
								<?php 
								if (isset($message->priority)) 
								{
									if ($message->priority == "0") 
									{ ?>

									<?php } else if ($message->priority == "1") { ?>
									<span class="event-type2 label warning" style="margin-top: 9px;"><b>medium</b> priority</span>
									<?php } else if ($message->priority == "2") { ?>
									<span class="event-type label warning" style="margin-top: 9px;"><b>high</b> priority</span>
								<?php } ?>
								<?php } ?>

								<?php if ($message->private == "1") { ?>
								<span class="event-type0 label important" style="margin-top: 9px;">Private</span> 
								<?php } ?>
							
								<?php 
								if ($inGroupView == "0") { 
									$strLimit = "132";
								} else {
									$strLimit = "150";
								}

								$f =  $message->content;
								if (strlen($f) > $strLimit)
								{
									$d = substr($f, 0, $strLimit).'...';
								} else {
									$d = $f;
								}
								?>
								<span class="user-info" style="margin-top: 17px; padding-left: 13px;"><?= $d ?></span>
							</li>
							<?php }
						}
						?>
						</ul>
					</div>
				</section>
			</div>		
		</div>
	</div>

<br/>
</div>