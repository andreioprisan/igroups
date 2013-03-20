<?php if (count($callDetails) == 0) { ?>
<h2 style="display:inline; padding: 20px 0px 10px 8px; line-height: 60px"><font color="white">No Call Statistics Available</font> <small>statistics are recorded instantly</small></h2>
<?php } else { ?>
<h2 style="display:inline; padding: 20px 0px 10px 8px; line-height: 60px"><font color="white">Call Details</font> <small>shows you a history of all calls, duration, geo-location of customers, and more</small></h2>
<?php } ?>

<div class="charts">
	<br/>
	<table class="bordered-table">
	<thead>
		<tr>
			<td>Date</td>
			<td>To</td>
			<td>From</td>
			<td>From Geo Data</td>
			<td>Call Status</td>
			<td>Direction</td>
			<td>Duration</td>
			<td>Cost</td>
			
		</tr>
	</thead>
	<tbody>
	<?php 
	$chargetotal = 0;
	$durationtotal = 0;
	$tonumberstotal = array();
	$fromnumberstotal = array();
	
	foreach ($callDetails as $call) {?>
		<tr>
			<td><?= date("m/d/y h:m A", strtotime($call->Date)) ?></td>
			<td><?php echo format_phone($call->To); $tonumberstotal[] = format_phone($call->To); ?></td>
			<td><?php echo format_phone($call->From); $fromnumberstotal[] = format_phone($call->From); ?></td>
			<td><?= $call->FromGeoIP ?></td>
			<td><?= $call->CallStatus ?></td>
			<td><?= $call->Direction ?></td>
			<td><?php 
				$thiscallprice = 0.00;
				
				if ($call->CallStatus == "completed") { echo $call->Duration." min (".$call->CallDuration ." sec)"; 
					$minprice = 0.02;
					if 	( 	strstr("(800)", format_phone($call->To)) ||
						 	strstr("(888)", format_phone($call->To)) ||
						 	strstr("(877)", format_phone($call->To)) ||
						 	strstr("(866)", format_phone($call->To)) ||
						 	strstr("(855)", format_phone($call->To))
						) 
					{
						$minprice = 0.05;
					}
					$thiscallprice = number_format($call->Duration*$minprice, 2, '.', '');
				
					$durationtotal += $call->Duration;
					$chargetotal += $thiscallprice;
				} else { echo ""; } ?></td>
			<td><?= "$".number_format($thiscallprice, 2, '.', '') ?></td>
			
		</tr>
	<?php } ?>
		<tr>
			<td><?= "Total ".count($callDetails)." calls"; ?></td>
			<td><?= "To ".count(array_unique($tonumberstotal))." numbers"; ?></td>
			<td><?= "From ".count(array_unique($fromnumberstotal))." numbers"; ?></td>
			<td></td>
			<td></td>
			<td></td>
			<td><?= $durationtotal." min"; ?></td>
			<td><?= "$".number_format($chargetotal, 2, '.', '') ?></td>
		</tr>
	
	</tbody>
	</table>
	
	<div id="vbx-context-menu" class="context-menu" style="background: none;">
		<div class="notify <?php echo (isset($error) && !empty($error))? '' : 'hide' ?>">
		 	<p class="message">
				<?php if(isset($error) && $error): ?>
					<?php echo $error ?>
				<?php endif; ?>
				<a href="" class="close action"><span class="replace">Close</span></a>
			</p>
		</div>
	</div>
	
</div>
