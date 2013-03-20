<div id="feed_module" style="display: block">

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
									<h3><a href=""></a></h3>
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

							if ($inGroupView) 
							{
								$stream = $this->feed_model->group($group_id, $user_id); 
							} else {
								$stream = $this->feed_model->user($user_id); 
							}
							
							//var_dump($stream);
							
							foreach($stream as $feed) 
							{
								$this_group = $this->usergroups_model->get_group_by_id($feed->group_id);
								if (count($this_group) > 0)
								{
									$date_formatted_gr = explode(" ", $feed->datetime);
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

									$type = $feed->type;
									//var_dump($feed);
								?>
								
								<li onclick="$('.listings-holder li').removeClass('selected'); changeClass(this, 'selected'); var model = []; model[0]=['header','stream details','','','','','order','0']; model[1]=['desc','group','elemType','text','elemLabel','<?= $this_group->name; ?>','order','1'];  model[2]=['desc','by','elemType','text','elemLabel','<?= $feed->author; ?>','order','2']; model[3]=['desc','@','elemType','text','elemLabel','<?= $date_formatted; ?>','order','3']; model[4]=['desc','event type','elemType','text','elemLabel','<?= $feed->type; ?>','order','4']; model[5]=['desc','what','elemType','text','elemLabel','<?= $feed->contentAmend; ?>','order','5']; model[6]=['desc','objecttype','elemType','text','elemLabel','feed','order','6']; model[7]=['desc','objectid','elemType','text','elemLabel','<?= $feed->id; ?>','order','7'];  setMRP(model); jQuery(function(){ $('#priority').fcbkcomplete({ json_url: '/autocomplete/priority',addontab: true, maxitems: 1,height: 2,firstselected: true,cache: true,filter_case: true,filter_hide: true,newel: true }); }); ">
									<span class="row-spacer"></span>
										<?php if ($inGroupView == "0") {?>
											<span class="group-name" style="margin-top: 11px;"><strong><?= $this_group->name; ?></strong></span>
										<?php } else { ?>
											<span class="group-name" style="margin-top: 11px;"><strong><?= $date_formatted ?></strong></span>
										<?php } ?>
									<span class="event-type" style="margin-top: 11px;"><?= $feed->type; ?></span>
								<?php 
								if ($inGroupView == "0") { 
									$strLimit = "132";
								} else {
									$strLimit = "150";
								}
								
								$f =  $feed->contentAmend;
								if (strlen($f) > $strLimit)
								{
									$d = substr($f, 0, $strLimit).'...';
								} else {
									$d = $f;
								}
								?>
									<span class="user-info" style="margin-top: 11px;"><?= $d ?></span>
								</li>
								<?php } ?>
							<?php } ?>

						</ul>
					</div>
				</section>
			</div>		
		</div>
	</div>




<?php if (count($stream) <= 0) { ?>
<div class="alert-message info" style="width: 362px;">
        <p><strong>Whaa, there's no activity to show you.</strong> Start doing stuff!</p>
      </div>
<br>
<img src="/asset/images/sad_panda.png" height="320px">
<?php } ?>


</div>
