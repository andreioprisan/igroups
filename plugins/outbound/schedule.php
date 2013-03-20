<?php
	$user = OpenVBX::getCurrentUser();
	$tenant_id = $user->values['tenant_id'];
	$ci =& get_instance();
	$queries = explode(';', file_get_contents(dirname(__FILE__) . '/db.sql'));
	foreach($queries as $query)
		if(trim($query))
			$ci->db->query($query);
	if(!empty($_POST['number'])) {
		$type = $_POST['type'];
		$number = normalize_phone_to_E164($_POST['number']);
		$callerId = normalize_phone_to_E164($_POST['callerId']);
		$time = strtotime($_POST['date'] . ' ' . $_POST['time']);
		if('sms' == $type && !empty($_POST['message'])) {
			if($number)
				$ci->db->insert('outbound_queue', array(
					'tenant' => $tenant_id,
					'number' => $number,
					'type' => $type,
					'time' => $time,
					'callerId' => $callerId,
					'data' => json_encode(array(
						'message' => $_POST['message']
					))
				));
		}
		elseif('call' == $type) {
			$flow = OpenVBX::getFlows(array('id' => $_POST['flow'], 'tenant_id' => $tenant_id));
			if($number && $flow && $flow[0]->values['data'])
				$ci->db->insert('outbound_queue', array(
					'tenant' => $tenant_id,
					'number' => $number,
					'type' => $type,
					'time' => $time,
					'callerId' => $callerId,
					'data' => json_encode(array(
						'id' => $flow[0]->values['id'],
						'name' => $flow[0]->values['name']
					))
				));
		}
	}
	$flows = OpenVBX::getFlows(array('tenant_id' => $tenant_id));
//	OpenVBX::addJS('jquery-ui-1.7.3.custom.min.js');
	OpenVBX::addJS('schedule.js');
	OpenVBX::addCSS('jquery-ui-1.7.3.custom.css');
?>
<style>
	.vbx-schedule form {
		display: none;
		padding: 0px 10px;
	}
	.vbx-schedule h3 {
		font-size: 16px;
		font-weight: bold;
		margin-top: 0;
	}
	.vbx-queue h3 {
		font-size: 16px;
		font-weight: bold;
		margin-top: 0;
	}
	.vbx-queue .event {
		clear: both;	
		width: 95%;
		overflow: hidden;
		margin: 0 auto;
		padding: 5px 0;
		border-bottom: 1px solid #eee;
	}
	.vbx-queue .event span {
		display: inline-block;
		width: 20%;
		text-align: center;
		float: left;
		vertical-align: middle;
		line-height: 24px;
	}
	.vbx-queue a.delete {
		display: inline-block;
		height: 24px;
		width: 24px;
		text-indent: -999em;
		background: transparent url(/assets/i/action-icons-sprite.png) no-repeat -68px 0;
	}
	
</style>
<div class="vbx-content-main">
	<h2 class="" style="display:inline; padding: 20px 0px 10px 8px; line-height: 60px">Schedule <small>an automated voice call or SMS</small></h2>
	<button id="schedule-sms" class="btn primary large add number addnewflow addcallorsmsschedule" style="padding: 2px 15px 2px 15px;float: right;margin-top: 15px;margin-right: 33px;">SMS</button>
	<button id="schedule-call" class="btn primary large add number addnewflow addcallorsmsschedule" style="padding: 2px 15px 2px 15px;float: right;margin-top: 15px;margin-right: 33px;">Voice Call</button>

	<div class="vbx-table-section vbx-schedule">
		<form class="schedule-sms" method="post" action="">
			<h2>Schedule SMS</h2>
			<fieldset class="vbx-input-container">
<?php if(count($callerid_numbers)): ?>
				<p>
					<label class="field-label">Number<br/>
						<input type="text" name="number" class="medium" />
					</label>
				</p>
				<p>
					<label class="field-label">Date<br/>
						<input id="datepicker" type="text" name="date" class="date medium" value="<?php echo date('m/d/Y'); ?>" />
					</label>
				</p>
				<p>
					<label class="field-label">Time<br/>
						<input id="hourminutepicker" type="text" name="time" class="time medium" value="12:00 AM" />
					</label>
				</p>
				<p>
					<label class="field-label">Caller ID<br/>
						<select name="callerId" class="medium">
<?php foreach($callerid_numbers as $number): ?>
							<option value="<?php echo $number->phone; ?>"><?php echo $number->name; ?></option>
<?php endforeach; ?>
						</select>
					</label>
				</p>
				<p><input type="hidden" name="type" value="sms" /></p>
				<p>
					<label class="field-label">Message
						<textarea rows="20" cols="100" name="message" class="medium"></textarea>
					</label>
				</p>
				<p><button type="submit" class="submit-button btn primary">&nbsp; Create Scheduled SMS Action</button></p>
<?php else: ?>
				<p>You do not have any phone numbers!</p>
<?php endif; ?>
			</fieldset>
		</form>
		<form class="schedule-call" method="post" action="">
			<h2>Schedule Voice Call</h2>
			<fieldset class="vbx-input-container">
<?php if(count($callerid_numbers)): ?>
				<p>
					<label class="field-label">Number<br/>
						<input type="text" name="number" class="medium" />
					</label>
				</p>
				<p>
					<label class="field-label">Date<br/>
						<input type="text" name="date" class="date medium" value="<?php echo date('m/d/Y'); ?>" />
					</label>
				</p>
				<p>
					<label class="field-label">Time<br/>
						<input type="text" name="time" class="time medium" value="12:00 AM" />
					</label>
				</p>
<?php if(count($flows)): ?>
				<p>
					<label class="field-label">Flow<br/>
						<select name="flow" class="medium">
<?php foreach($flows as $flow): ?>
							<option value="<?php echo $flow->values['id']; ?>"><?php echo $flow->values['name']; ?></option>
<?php endforeach; ?>
						</select>
					</label>
				</p>
				<p>
					<label class="field-label">Caller ID<br/>
						<select name="callerId" class="medium">
<?php foreach($callerid_numbers as $number): ?>
							<option value="<?php echo $number->phone; ?>"><?php echo $number->name; ?></option>
<?php endforeach; ?>
						</select>
					</label>
				</p>
				<p><input type="hidden" name="type" value="call" /></p>
				<p><button type="submit" class="submit-button btn primary">&nbsp; Create Scheduled Voice Call Action</button></p>
<?php else: ?>
				<p>You do not have any flows!</p>
<?php endif; ?>
<?php else: ?>
				<p>You do not have any phone numbers!</p>
<?php endif; ?>
			</fieldset>
		</form>
	</div>

	<?php
		$ci =& get_instance();
		if(defined("HOOK") AND HOOK) {
			set_time_limit(0);
			$events = $ci->db->query(sprintf('SELECT id, tenant, number, type, time, callerId, data FROM outbound_queue WHERE time < %d ORDER BY time ASC', time()))->result();
			if(count($events)) {
				require_once(APPPATH . 'libraries/Services/Twilio.php');
				foreach($events as $event) {
					$event->data = json_decode($event->data);
					$twilio_sid = $ci->settings->get('twilio_sid', $event->tenant);
					$twilio_token = $ci->settings->get('twilio_token', $event->tenant);
					$service = new Services_Twilio($twilio_sid, $ci->twilio_token);
					if('sms' == $event->type)
					  $service->account->sms_messages->create($event->callerId, $event->number, $event->data->message);
					else
					  $service->account->calls->create($event->callerId, $event->number, site_url('twiml/start/voice/' . $event->data->id));
					 $ci->db->delete('outbound_queue', array('id' => $event->id));
				}
			}
			die;
		}
		$user = OpenVBX::getCurrentUser();
		$tenant_id = $user->values['tenant_id'];
		$queries = explode(';', file_get_contents(dirname(__FILE__) . '/db.sql'));
		foreach($queries as $query)
			if(trim($query))
				$ci->db->query($query);
		if(!empty($_POST['remove'])) {
			$ci->db->delete('outbound_queue', array('id' => intval($_POST['remove']), 'tenant' => $tenant_id));
			die;
		}
		$events = $ci->db->query(sprintf('SELECT id, number, type, time, callerId, data FROM outbound_queue WHERE tenant=%d ORDER BY time ASC', $tenant_id))->result();
		OpenVBX::addJS('queue.js');
	?>
	
	<h2 class="" style="display:inline; padding: 20px 0px 10px 8px; line-height: 60px">Scheduled Events <small>are listed below</small></h2>
	<?php
	if (count($events) > 0) 
	{
	?>
	<table class="phone-numbers-table vbx-items-grid" data-type="incoming">
		<thead>
			<tr class="items-head">
				<th class="incoming-number-phone">Date and Time</th>
				<th class="incoming-number-phone">To Phone Number</th>
				<th class="incoming-number-phone">From Phone Number</th>
				<th class="incoming-number-phone">Scheduled Event Type</th>
				<th class="incoming-number-delete" style="width:70px">&nbsp;</th>
			</tr>
		</thead>
		<tbody>
			<?php 
				foreach($events as $event) {
					$event->data = json_decode($event->data); ?>
			<tr class="items-row" id="event_<?php echo $event->id; ?>">
				<td class="incoming-number-phone"><?php echo date('m/d/y g:i A', $event->time); ?></td>
				<td class="incoming-number-phone"><?php echo $event->number; ?></td>
				<td class="incoming-number-phone"><?php echo $event->callerId; ?></td>
				
				<?php if('sms' == $event->type): ?>
				<td class="incoming-number-phone" title="<?php echo htmlentities($event->data->message); ?>">SMS</td>
				<?php else: ?>
				<td class="incoming-number-phone"><?php echo htmlentities($event->data->name); ?></td>
				<?php endif; ?>
				
				<td class="incoming-number-delete">
					<a id="scheduleeventdelete" href="" class="delete btn danger" style="height: 14px; width:35px;"><font color="white">Delete</font></a>
				</td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
	<?php } else { ?>
		<p style="padding-left: 8px;">You have no scheduled voice calls or SMSs at this time. Add one above!</p><br /><br />
	<?php } ?>

</div>

